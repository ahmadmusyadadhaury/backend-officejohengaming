<?php

namespace App\Http\Controllers\Ticket;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ticket\AssignTicketRequest;
use App\Http\Requests\Ticket\CommentTicketRequest;
use App\Http\Requests\Ticket\RatingTicketRequest;
use App\Http\Requests\Ticket\StatusTicketRequest;
use App\Http\Requests\Ticket\StoreTicketRequest;
use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\TicketCategory;
use App\Services\TicketService;
use App\Support\Ticket as TicketSupport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TicketController extends Controller
{
    public function __construct(protected TicketService $ticketService) {}

    /**
     * Daftar semua ticket — khusus tim IT / admin.
     */
    public function index(Request $request)
    {
        abort_unless(auth()->user()->isTicketTeam(), 403);

        $query = Ticket::query()->with(['requester', 'category', 'technician', 'rating']);

        $query
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->input('search');
                $q->where(fn ($qq) => $qq->where('ticket_number', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%"));
            })
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->input('status')))
            ->when($request->filled('priority'), fn ($q) => $q->where('priority', $request->input('priority')))
            ->when($request->filled('category_id'), fn ($q) => $q->where('category_id', $request->input('category_id')))
            ->when($request->filled('technician'), fn ($q) => $q->where('assigned_to', $request->input('technician')))
            ->when($request->input('filter') === 'over_sla', fn ($q) => $q->active()->whereNotNull('sla_due_at')->where('sla_due_at', '<', now()))
            ->when($request->input('filter') === 'waiting', fn ($q) => $q->where('status', 'waiting_user'));

        $tickets = $query->latest()->paginate(15)->withQueryString();

        return view('tickets.index', [
            'tickets' => $tickets,
            'categories' => TicketCategory::orderBy('name')->get(),
            'technicians' => TicketSupport::technicians(),
            'filters' => $request->only(['search', 'status', 'priority', 'category_id', 'technician', 'filter']),
        ]);
    }

    /**
     * Ticket milik user.
     */
    public function my(Request $request)
    {
        $query = auth()->user()->tickets()->with([
            'requester', 'category', 'technician', 'rating',
            'histories' => fn ($q) => $q->latest(),
        ]);

        $query
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->input('status')))
            ->when($request->input('filter') === 'over_sla', fn ($q) => $q->active()->whereNotNull('sla_due_at')->where('sla_due_at', '<', now()))
            ->when($request->input('filter') === 'active', fn ($q) => $q->active())
            ->when($request->input('filter') === 'closed', fn ($q) => $q->whereIn('status', TicketSupport::closedStatuses()));

        $tickets = $query->latest()->paginate(15)->withQueryString();

        return view('tickets.my', [
            'tickets' => $tickets,
            'filters' => $request->only(['status', 'filter']),
        ]);
    }

    public function create()
    {
        return view('tickets.create', [
            'categories' => TicketCategory::orderBy('name')->get(),
        ]);
    }

    public function store(StoreTicketRequest $request)
    {
        $ticket = $this->ticketService->store(
            $request->validated(),
            $request->file('attachments', []),
            auth()->user()
        );

        return redirect()
            ->route('ticket.show', $ticket)
            ->with('success', 'Ticket '.$ticket->ticket_number.' berhasil dibuat.');
    }

    public function show(Request $request, Ticket $ticket)
    {
        Gate::authorize('view', $ticket);

        $ticket->load(['requester', 'category', 'technician', 'comments' => fn ($q) => $q->with(['user', 'attachments'])->oldest(), 'attachments', 'histories' => fn ($q) => $q->with('user')->latest(), 'rating']);

        if ($request->has('embed')) {
            return view('tickets.partials.detail-content', [
                'ticket' => $ticket,
                'user' => auth()->user(),
                'embedded' => true,
            ]);
        }

        return view('tickets.show', [
            'ticket' => $ticket,
            'technicians' => TicketSupport::technicians(),
            'user' => auth()->user(),
        ]);
    }

    public function take(Ticket $ticket)
    {
        Gate::authorize('take', $ticket);

        $this->ticketService->take($ticket, auth()->user());

        return back()->with('success', 'Ticket berhasil diambil.');
    }

    public function assign(Ticket $ticket, AssignTicketRequest $request)
    {
        Gate::authorize('assign', $ticket);

        $this->ticketService->assign($ticket, $request->technician(), auth()->user());

        return back()->with('success', 'Ticket berhasil ditugaskan.');
    }

    public function comment(Ticket $ticket, CommentTicketRequest $request)
    {
        Gate::authorize('comment', $ticket);

        $this->ticketService->comment(
            $ticket,
            auth()->user(),
            $request->input('comment'),
            $request->file('attachments', [])
        );

        return back()->with('success', 'Komentar berhasil dikirim.');
    }

    public function updateStatus(Ticket $ticket, StatusTicketRequest $request)
    {
        Gate::authorize('updateStatus', $ticket);

        try {
            $this->ticketService->updateStatus(
                $ticket,
                $request->input('status'),
                auth()->user(),
                $request->input('note')
            );
        } catch (\InvalidArgumentException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Status ticket diperbarui.');
    }

    public function resolve(Ticket $ticket, Request $request)
    {
        Gate::authorize('resolve', $ticket);

        $this->ticketService->resolve($ticket, auth()->user(), $request->input('note'));

        return back()->with('success', 'Ticket ditandai selesai.');
    }

    public function close(Ticket $ticket)
    {
        Gate::authorize('close', $ticket);

        $this->ticketService->close($ticket, auth()->user());

        return back()->with('success', 'Ticket dikonfirmasi selesai.');
    }

    public function reopen(Ticket $ticket, Request $request)
    {
        Gate::authorize('reopen', $ticket);

        $this->ticketService->reopen($ticket, auth()->user(), $request->input('note'));

        return back()->with('success', 'Ticket dibuka kembali.');
    }

    public function rate(Ticket $ticket, RatingTicketRequest $request)
    {
        Gate::authorize('rate', $ticket);

        $this->ticketService->rate(
            $ticket,
            auth()->user(),
            (int) $request->input('rating'),
            $request->input('comment')
        );

        return back()->with('success', 'Terima kasih atas penilaian Anda.');
    }

    public function destroyAttachment(Ticket $ticket, TicketAttachment $attachment)
    {
        abort_unless($attachment->ticket_id === $ticket->id, 404);
        abort_unless(auth()->id() === $attachment->user_id || auth()->user()->isTicketTeam(), 403);

        $this->ticketService->deleteAttachment($attachment);

        return back()->with('success', 'Lampiran dihapus.');
    }
}
