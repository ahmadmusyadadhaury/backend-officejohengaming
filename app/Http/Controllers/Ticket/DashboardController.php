<?php

namespace App\Http\Controllers\Ticket;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Services\TicketSlaService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(protected TicketSlaService $slaService) {}

    public function index(Request $request)
    {
        $user = auth()->user();
        $isTeam = $user->isTicketTeam();

        $query = Ticket::query()->with(['requester', 'category', 'technician', 'rating']);

        if (! $isTeam) {
            $query->where('user_id', $user->id);
        }

        $statusFilter = $request->get('status', 'active');

        $stats = [
            'total' => $query->count(),
            'open' => (clone $query)->where('status', 'open')->count(),
            'processing' => (clone $query)->whereIn('status', ['assigned', 'in_progress', 'reopened'])->count(),
            'waiting_user' => (clone $query)->where('status', 'waiting_user')->count(),
            'over_sla' => (clone $query)->active()->whereNotNull('sla_due_at')->where('sla_due_at', '<', now())->count(),
            'resolved' => (clone $query)->where('status', 'resolved')->count(),
            'closed' => (clone $query)->where('status', 'closed')->count(),
        ];

        $recent = (clone $query)
            ->when($statusFilter === 'active', fn ($q) => $q->active())
            ->when($statusFilter === 'closed', fn ($q) => $q->whereIn('status', ['closed', 'cancelled', 'rejected']))
            ->when($statusFilter === 'all', fn ($q) => $q)
            ->when(in_array($statusFilter, \App\Support\Ticket::statuses(), true), fn ($q) => $q->where('status', $statusFilter))
            ->latest()
            ->limit(10)
            ->get();

        $byStatus = Ticket::query()
            ->selectRaw('status, count(*) as total')
            ->when(! $isTeam, fn ($q) => $q->where('user_id', $user->id))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        return view('tickets.dashboard', compact('stats', 'recent', 'byStatus', 'statusFilter'));
    }
}
