<?php

namespace App\Support;

use App\Models\Team;
use App\Models\TicketTeamMember;
use App\Models\User;
use Illuminate\Support\Collection;

/**
 * Helper statis untuk modul IT Ticketing System.
 */
class Ticket
{
    public static function locations(): array
    {
        return config('ticket.locations', []);
    }

    public static function priorities(): array
    {
        return config('ticket.priorities', []);
    }

    public static function statuses(): array
    {
        return config('ticket.statuses', []);
    }

    public static function statusLabels(): array
    {
        return config('ticket.status_labels', []);
    }

    public static function priorityLabels(): array
    {
        return config('ticket.priority_labels', []);
    }

    public static function statusLabel(string $status): string
    {
        return static::statusLabels()[$status] ?? ucwords(str_replace('_', ' ', $status));
    }

    public static function priorityLabel(string $priority): string
    {
        return static::priorityLabels()[$priority] ?? ucfirst($priority);
    }

    public static function statusColor(string $status): string
    {
        return config('ticket.status_colors', [])[$status] ?? '#94a3b8';
    }

    public static function priorityColor(string $priority): string
    {
        return config('ticket.priority_colors', [])[$priority] ?? '#3b82f6';
    }

    public static function isClosedStatus(string $status): bool
    {
        return in_array($status, config('ticket.closed_statuses', []), true);
    }

    /**
     * Nama departemen pengaju, diambil dari tim (snapshot saat pembuatan ticket).
     */
    public static function departmentFromUser(User $user): ?string
    {
        if ($user->team) {
            return $user->team->name;
        }

        return null;
    }

    /**
     * Nama jabatan pengaju, diambil dari role (snapshot saat pembuatan ticket).
     */
    public static function positionFromUser(User $user): ?string
    {
        return $user->role_label;
    }

    /**
     * Semua user yang merupakan anggota tim IT.
     */
    public static function teamMembers(): Collection
    {
        return User::query()
            ->where('is_active', true)
            ->whereIn('id', TicketTeamMember::query()->select('user_id'))
            ->orderBy('name')
            ->get();
    }

    /**
     * Semua anggota tim IT (termasuk yang ditandai leader).
     */
    public static function technicians(): Collection
    {
        return static::teamMembers();
    }

    public static function teamUserIds(): array
    {
        return TicketTeamMember::query()->pluck('user_id')->all();
    }

    /**
     * Daftar user yang bisa dipilih sebagai teknisi (anggota tim IT).
     */
    public static function assignableTechnicians(): Collection
    {
        return static::teamMembers();
    }

    public static function departmentNameOf(?Team $team): ?string
    {
        return $team?->name;
    }
}
