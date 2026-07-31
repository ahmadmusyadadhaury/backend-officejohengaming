<?php

namespace App\Http\Controllers\Ticket;

use App\Http\Controllers\Controller;
use App\Models\TicketSla;
use App\Support\Ticket as TicketSupport;
use Illuminate\Http\Request;

class SlaController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()->isTicketLeader(), 403);

        $slas = TicketSla::orderBy('priority')->get();

        return view('tickets.sla', ['slas' => $slas, 'priorities' => TicketSupport::priorities()]);
    }

    public function update(Request $request)
    {
        abort_unless(auth()->user()->isTicketLeader(), 403);

        $data = $request->validate([
            'duration_minutes' => 'required|array',
            'duration_minutes.*' => 'required|integer|min:1',
        ]);

        foreach (TicketSupport::priorities() as $priority) {
            TicketSla::updateOrCreate(
                ['priority' => $priority],
                ['duration_minutes' => (int) ($data['duration_minutes'][$priority] ?? 1)]
            );
        }

        return back()->with('success', 'Pengaturan SLA berhasil disimpan.');
    }
}
