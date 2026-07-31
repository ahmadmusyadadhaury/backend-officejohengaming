<?php

namespace App\Http\Controllers\Ticket;

use App\Exports\TicketsExport;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\TicketRating;
use App\Support\Ticket as TicketSupport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(auth()->user()->isTicketTeam(), 403);

        $from = $request->date('from');
        $to = $request->date('to');

        $query = Ticket::query()->with(['requester', 'category', 'technician', 'rating'])
            ->when($from, fn ($q) => $q->whereDate('created_at', '>=', $from))
            ->when($to, fn ($q) => $q->whereDate('created_at', '<=', $to))
            ->when($request->filled('category_id'), fn ($q) => $q->where('category_id', $request->input('category_id')))
            ->when($request->filled('priority'), fn ($q) => $q->where('priority', $request->input('priority')))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->input('status')));

        $tickets = (clone $query)->latest()->get();
        $baseQuery = Ticket::query()
            ->when($from, fn ($q) => $q->whereDate('created_at', '>=', $from))
            ->when($to, fn ($q) => $q->whereDate('created_at', '<=', $to))
            ->when($request->filled('category_id'), fn ($q) => $q->where('category_id', $request->input('category_id')))
            ->when($request->filled('priority'), fn ($q) => $q->where('priority', $request->input('priority')))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->input('status')));

        $summary = [
            'total' => (clone $baseQuery)->count(),
            'open' => (clone $baseQuery)->where('status', 'open')->count(),
            'processing' => (clone $baseQuery)->whereIn('status', ['assigned', 'in_progress', 'reopened'])->count(),
            'waiting_user' => (clone $baseQuery)->where('status', 'waiting_user')->count(),
            'resolved' => (clone $baseQuery)->where('status', 'resolved')->count(),
            'closed' => (clone $baseQuery)->where('status', 'closed')->count(),
            'cancelled' => (clone $baseQuery)->whereIn('status', ['cancelled', 'rejected'])->count(),
            'over_sla' => (clone $baseQuery)->active()->whereNotNull('sla_due_at')->where('sla_due_at', '<', now())->count(),
        ];

        $byCategory = $baseQuery->clone()
            ->selectRaw('category_id, count(*) as total')
            ->groupBy('category_id')
            ->with('category')
            ->get()
            ->mapWithKeys(fn ($t) => [$t->category?->name ?? 'Tanpa Kategori' => $t->total]);

        $avgRating = TicketRating::query()
            ->when($from, fn ($q) => $q->whereHas('ticket', fn ($qq) => $qq->whereDate('created_at', '>=', $from)))
            ->when($to, fn ($q) => $q->whereHas('ticket', fn ($qq) => $qq->whereDate('created_at', '<=', $to)))
            ->avg('rating');

        return view('tickets.reports', [
            'tickets' => $tickets,
            'summary' => $summary,
            'byCategory' => $byCategory,
            'avgRating' => $avgRating ? number_format($avgRating, 1) : '-',
            'categories' => TicketCategory::orderBy('name')->get(),
            'filters' => $request->only(['from', 'to', 'category_id', 'priority', 'status']),
        ]);
    }

    public function export(Request $request)
    {
        abort_unless(auth()->user()->isTicketTeam(), 403);

        $query = Ticket::query()->with(['category', 'technician', 'rating'])
            ->when($request->date('from'), fn ($q) => $q->whereDate('created_at', '>=', $request->date('from')))
            ->when($request->date('to'), fn ($q) => $q->whereDate('created_at', '<=', $request->date('to')))
            ->when($request->filled('category_id'), fn ($q) => $q->where('category_id', $request->input('category_id')))
            ->when($request->filled('priority'), fn ($q) => $q->where('priority', $request->input('priority')))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->input('status')))
            ->latest();

        $filterLabel = trim(collect([
            $request->date('from') ? 'Dari '.$request->date('from')->format('d/m/Y') : null,
            $request->date('to') ? 's/d '.$request->date('to')->format('d/m/Y') : null,
            $request->filled('category_id') ? TicketCategory::find($request->input('category_id'))?->name : null,
            $request->filled('priority') ? TicketSupport::priorityLabel($request->input('priority')) : null,
        ])->filter()->implode(', '));

        return Excel::download(
            new TicketsExport($query->get(), $filterLabel),
            'laporan-ticket-'.now()->format('Ymd-His').'.xlsx'
        );
    }

    public function print(Request $request)
    {
        abort_unless(auth()->user()->isTicketTeam(), 403);

        $query = Ticket::query()->with(['requester', 'category', 'technician', 'rating'])
            ->when($request->date('from'), fn ($q) => $q->whereDate('created_at', '>=', $request->date('from')))
            ->when($request->date('to'), fn ($q) => $q->whereDate('created_at', '<=', $request->date('to')))
            ->when($request->filled('category_id'), fn ($q) => $q->where('category_id', $request->input('category_id')))
            ->when($request->filled('priority'), fn ($q) => $q->where('priority', $request->input('priority')))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->input('status')))
            ->latest();

        return view('tickets.print', [
            'tickets' => $query->get(),
            'filters' => $request->only(['from', 'to', 'category_id', 'priority', 'status']),
        ]);
    }
}
