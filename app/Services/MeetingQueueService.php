<?php

namespace App\Services;

use App\Models\Meeting;
use Carbon\Carbon;

class MeetingQueueService
{
    const QUEUE_GAP_MINUTES = 10; // Jarak berdekatan = 10 menit

    /**
     * Saat meeting di-approve:
     * 1. Cek overlap → potong jam jika perlu
     * 2. Tentukan posisi antrian
     */
    public function assignQueue(Meeting $meeting): void
    {
        // Potong jam selesai jika ada yang booking duluan dan overlap
        $this->autoTrimEndTime($meeting);

        // Reload setelah potong
        $meeting->refresh();

        // Cek apakah ada yang overlap setelah dipotong
        $overlapping = $this->getOverlapping($meeting);

        if ($overlapping->isEmpty()) {
            $meeting->update(['queue_position' => 0]);
        } else {
            $maxPosition = $overlapping->max('queue_position') ?? 0;
            $meeting->update(['queue_position' => $maxPosition + 1]);
        }
    }

    /**
     * Auto-potong end_time jika ada meeting lain yang mulai lebih awal dan overlap.
     */
    private function autoTrimEndTime(Meeting $meeting): void
    {
        // Cari meeting yang sudah approved di ruangan & tanggal yang sama
        // yang jam mulainya LEBIH AWAL dari jam selesai meeting ini
        $blocker = Meeting::where('room_id', $meeting->room_id)
            ->where('meeting_date', $meeting->meeting_date)
            ->where('id', '!=', $meeting->id)
            ->whereIn('status', ['approved', 'confirmed'])
            ->where('start_time', '>', $meeting->start_time) // mulai setelah meeting ini
            ->where('start_time', '<', $meeting->end_time)   // tapi sebelum meeting ini selesai
            ->orderBy('start_time')
            ->first();

        if ($blocker) {
            // Potong end_time menjadi start_time blocker
            $meeting->update(['end_time' => $blocker->start_time]);
        }
    }

    /**
     * Ambil meeting yang overlap dengan meeting ini.
     */
    private function getOverlapping(Meeting $meeting)
    {
        return Meeting::where('room_id', $meeting->room_id)
            ->where('meeting_date', $meeting->meeting_date)
            ->where('id', '!=', $meeting->id)
            ->whereIn('status', ['approved', 'confirmed'])
            ->where(function ($q) use ($meeting) {
                $q->where('start_time', '<', $meeting->end_time)
                  ->where('end_time', '>', $meeting->start_time);
            })
            ->orderBy('queue_position')
            ->get();
    }

    /**
     * Saat meeting selesai, geser antrian berikutnya.
     */
    public function shiftQueue(Meeting $completedMeeting): void
    {
        $queue = Meeting::where('room_id', $completedMeeting->room_id)
            ->where('meeting_date', $completedMeeting->meeting_date)
            ->whereIn('status', ['approved', 'confirmed'])
            ->where('queue_position', '>', 0)
            ->orderBy('queue_position')
            ->get();

        foreach ($queue as $m) {
            $newPosition = $m->queue_position - 1;
            $m->update(['queue_position' => $newPosition]);

            if ($newPosition === 0) {
                $actualEnd = $completedMeeting->actual_end_time ?? $completedMeeting->end_time;
                $duration  = Carbon::parse($m->start_time)->diffInMinutes(Carbon::parse($m->end_time));
                $newStart  = Carbon::parse($actualEnd);
                $newEnd    = $newStart->copy()->addMinutes($duration);

                $m->update([
                    'start_time' => $newStart->format('H:i:s'),
                    'end_time'   => $newEnd->format('H:i:s'),
                ]);
            }
        }
    }

    /**
     * Hitung status real-time berdasarkan jam sekarang.
     * Status ini dikirim ke frontend untuk ditampilkan secara real-time.
     */
    public static function realtimeStatus(Meeting $meeting): array
    {
        $now       = Carbon::now();
        $date      = $meeting->meeting_date;
        $startDt   = Carbon::parse($date->format('Y-m-d') . ' ' . $meeting->start_time);
        $endDt     = Carbon::parse($date->format('Y-m-d') . ' ' . ($meeting->actual_end_time ?? $meeting->end_time));
        $position  = $meeting->queue_position;

        // Sudah selesai
        if ($meeting->status === 'completed') {
            return ['label' => 'Selesai', 'color' => 'bg-gray-100 text-gray-600', 'dot' => '#6b7280'];
        }

        // Dibatalkan/ditolak
        if (in_array($meeting->status, ['cancelled', 'rejected'])) {
            return ['label' => ucfirst($meeting->status), 'color' => 'bg-red-100 text-red-600', 'dot' => '#ef4444'];
        }

        // Pending (belum diapprove)
        if ($meeting->status === 'pending') {
            return ['label' => 'Menunggu Persetujuan', 'color' => 'bg-yellow-100 text-yellow-700', 'dot' => '#f59e0b'];
        }

        // Sudah approved/confirmed — cek waktu
        $dateOnly  = $date->format('Y-m-d');
        $todayOnly = $now->format('Y-m-d');

        // Hari sudah lewat
        if ($dateOnly < $todayOnly) {
            return ['label' => 'Selesai', 'color' => 'bg-gray-100 text-gray-600', 'dot' => '#6b7280'];
        }

        // Hari mendatang
        if ($dateOnly > $todayOnly) {
            if ($position !== null && $position > 0) {
                return ['label' => 'Dalam Antrian ' . $position, 'color' => 'bg-orange-100 text-orange-700', 'dot' => '#f97316'];
            }
            return ['label' => 'Di Booking', 'color' => 'bg-blue-100 text-blue-700', 'dot' => '#3b82f6'];
        }

        // Hari ini
        if ($now->gte($startDt) && $now->lte($endDt)) {
            if ($position === 0) {
                return ['label' => 'Sedang Berlangsung', 'color' => 'bg-purple-100 text-purple-700', 'dot' => '#7c3aed'];
            }
            return ['label' => 'Menunggu Antrian ' . $position, 'color' => 'bg-orange-100 text-orange-700', 'dot' => '#f97316'];
        }

        if ($now->lt($startDt)) {
            $diffMinutes = $now->diffInMinutes($startDt);
            if ($position !== null && $position > 0) {
                if ($diffMinutes <= self::QUEUE_GAP_MINUTES) {
                    return ['label' => 'Menunggu Antrian ' . $position, 'color' => 'bg-orange-100 text-orange-700', 'dot' => '#f97316'];
                }
                return ['label' => 'Dalam Antrian ' . $position, 'color' => 'bg-orange-100 text-orange-700', 'dot' => '#f97316'];
            }
            return ['label' => 'Di Booking', 'color' => 'bg-blue-100 text-blue-700', 'dot' => '#3b82f6'];
        }

        return ['label' => 'Selesai', 'color' => 'bg-gray-100 text-gray-600', 'dot' => '#6b7280'];
    }

    public static function queueLabel(?int $position): string
    {
        if ($position === null) return '';
        if ($position === 0)    return 'Sedang Berlangsung';
        return 'Dalam Antrian ' . $position;
    }

    public static function queueColor(?int $position): string
    {
        if ($position === null) return 'bg-gray-100 text-gray-600';
        if ($position === 0)    return 'bg-purple-100 text-purple-700';
        return 'bg-orange-100 text-orange-700';
    }
}
