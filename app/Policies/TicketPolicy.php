<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    /**
     * Melihat detail ticket — pemilik / anggota tim IT / admin.
     */
    public function view(User $user, Ticket $ticket): bool
    {
        return $user->isTicketTeam() || $ticket->user_id === $user->id;
    }

    /**
     * Membuat ticket — semua user login.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Menambahkan komentar/lampiran — pemilik / tim IT.
     */
    public function comment(User $user, Ticket $ticket): bool
    {
        return $this->view($user, $ticket);
    }

    /**
     * Mengambil / memproses ticket — khusus tim IT.
     */
    public function take(User $user, Ticket $ticket): bool
    {
        return $user->isTicketTeam();
    }

    /**
     * Menugaskan teknisi — khusus leader IT / admin.
     */
    public function assign(User $user, Ticket $ticket): bool
    {
        return $user->isTicketLeader();
    }

    /**
     * Mengubah status — tim IT (atau pemilik untuk close/reopen).
     */
    public function updateStatus(User $user, Ticket $ticket): bool
    {
        return $user->isTicketTeam() || $ticket->user_id === $user->id;
    }

    /**
     * Menyelesaikan ticket — khusus tim IT.
     */
    public function resolve(User $user, Ticket $ticket): bool
    {
        return $user->isTicketTeam();
    }

    /**
     * Menutup ticket — pemilik (konfirmasi selesai) atau admin.
     */
    public function close(User $user, Ticket $ticket): bool
    {
        return $ticket->user_id === $user->id || $user->hasFullAccess();
    }

    /**
     * Membuka kembali — pemilik atau admin.
     */
    public function reopen(User $user, Ticket $ticket): bool
    {
        return $ticket->user_id === $user->id || $user->hasFullAccess();
    }

    /**
     * Memberi rating — hanya pemilik, ticket harus closed.
     */
    public function rate(User $user, Ticket $ticket): bool
    {
        return $ticket->user_id === $user->id && $ticket->status === 'closed';
    }
}
