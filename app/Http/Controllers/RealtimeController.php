<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\MeetingInvitation;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\PembayaranAsetDigital;
use App\Models\PembayaranIplRuko;
use App\Models\User;
use App\Models\WeeklyMeetingInvitation;
use App\Models\WeeklyMeetingSession;
use App\Models\WifiPayment;
use App\Services\MeetingQueueService;
use App\Services\WeeklyMeetingService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RealtimeController extends Controller
{
    public function meetings()
    {
        $meetings = Meeting::with(['room', 'team', 'requester'])
            ->whereIn('status', ['approved', 'confirmed', 'in_progress', 'completed'])
            ->whereDate('meeting_date', '>=', today()->subDay())
            ->get()
            ->map(function ($m) {
                $rt = MeetingQueueService::realtimeStatus($m);

                return [
                    'id' => $m->id,
                    'title' => $m->title,
                    'requester' => $m->requester->name,
                    'room' => $m->room->name,
                    'team' => $m->team->name,
                    'date' => $m->meeting_date->format('Y-m-d'),
                    'start_time' => substr($m->start_time, 0, 5),
                    'end_time' => substr($m->actual_end_time ?? $m->end_time, 0, 5),
                    'status' => $m->status,
                    'rt_label' => $rt['label'],
                    'rt_color' => $rt['color'],
                    'rt_dot' => $rt['dot'],
                    'queue_pos' => $m->queue_position,
                ];
            });

        return response()->json($meetings);
    }

    public function weeklySessions()
    {
        // Auto-generate & complete expired sessions
        $service = app(WeeklyMeetingService::class);
        $service->generateTodaySessions();
        $service->completeExpiredSessions();

        $now = Carbon::now();

        $sessions = WeeklyMeetingSession::with(['weeklyMeeting.room'])
            ->whereDate('session_date', today())
            ->get()
            ->map(function ($s) use ($now) {
                $startDt = Carbon::parse($s->session_date->format('Y-m-d').' '.$s->start_time);
                $endDt = Carbon::parse($s->session_date->format('Y-m-d').' '.$s->end_time);

                if ($s->status === 'completed') {
                    $rtLabel = 'Selesai';
                    $rtDot = '#6b7280';
                } elseif ($now->gte($startDt) && $now->lte($endDt)) {
                    $rtLabel = 'Sedang Berlangsung';
                    $rtDot = '#0891b2';
                } elseif ($now->lt($startDt)) {
                    $rtLabel = 'Akan Dimulai '.$startDt->format('H:i');
                    $rtDot = '#0891b2';
                } else {
                    $rtLabel = 'Selesai';
                    $rtDot = '#6b7280';
                    // Auto complete jika belum
                    if ($s->status !== 'completed') {
                        $s->update(['status' => 'completed', 'actual_end_time' => $s->end_time]);
                        $s->invitations()->update(['is_read' => true, 'read_at' => now()]);
                    }
                }

                return [
                    'id' => $s->id,
                    'title' => $s->weeklyMeeting->title,
                    'room' => $s->weeklyMeeting->room->name,
                    'date' => $s->session_date->format('Y-m-d'),
                    'start_time' => substr($s->start_time, 0, 5),
                    'end_time' => substr($s->end_time, 0, 5),
                    'status' => $s->status,
                    'rt_label' => $rtLabel,
                    'rt_dot' => $rtDot,
                ];
            });

        return response()->json($sessions);
    }

    public function notifCount()
    {
        $activeInvitations = MeetingInvitation::where('user_id', auth()->id())
            ->whereHas('meeting', function ($q) {
                $q->whereIn('status', ['approved', 'confirmed', 'in_progress'])
                    ->where(function ($q2) {
                        $q2->where('meeting_date', '>', today())
                            ->orWhere(function ($q3) {
                                $q3->where('meeting_date', today())
                                    ->where('end_time', '>', Carbon::now()->format('H:i:s'));
                            });
                    });
            })->count();

        $activeWeeklyInvitations = WeeklyMeetingInvitation::where('user_id', auth()->id())
            ->whereHas('session', fn ($q) => $q->whereIn('status', ['active', 'extended']))
            ->count();

        $pendingInvitations = MeetingInvitation::where('user_id', auth()->id())
            ->where('is_read', false)
            ->whereHas('meeting', function ($q) {
                $q->whereIn('status', ['approved', 'confirmed', 'in_progress'])
                    ->where(function ($q2) {
                        $q2->where('meeting_date', '>', today())
                            ->orWhere(function ($q3) {
                                $q3->where('meeting_date', today())
                                    ->where('end_time', '>', Carbon::now()->format('H:i:s'));
                            });
                    });
            })->count();

        $pendingWeeklyInvitations = WeeklyMeetingInvitation::where('user_id', auth()->id())
            ->where('is_read', false)
            ->whereHas('session', fn ($q) => $q->whereIn('status', ['active', 'extended']))
            ->count();

        $totalTagihan = Notification::where('user_id', auth()->id())
            ->where('type', 'tagihan')
            ->where('is_read', false)
            ->count();

        $totalApproval = Notification::where('user_id', auth()->id())
            ->where('type', 'approval')
            ->where('is_read', false)
            ->count();

        return response()->json([
            'total_active' => $activeInvitations + $activeWeeklyInvitations,
            'total_pending' => $pendingInvitations + $pendingWeeklyInvitations,
            'total_tagihan' => $totalTagihan,
            'total_pending_approvals' => $totalApproval,
        ]);
    }

    public function dashboardStats()
    {
        $role = auth()->user()->role;

        if (in_array($role, User::FULL_ACCESS_ROLES)) {
            return response()->json([
                'pending' => Meeting::where('status', 'pending')->count(),
                'today_meetings' => Meeting::whereDate('meeting_date', today())
                    ->whereIn('status', ['approved', 'confirmed', 'in_progress'])
                    ->count(),
            ]);
        }

        if ($role === 'koordinator' || in_array($role, ['head_of_store', 'gm', 'hr', 'ceo'])) {
            return response()->json([
                'pending' => Meeting::where('requested_by', auth()->id())->where('status', 'pending')->count(),
                'approved' => Meeting::where('requested_by', auth()->id())->where('status', 'approved')->count(),
                'completed' => Meeting::where('requested_by', auth()->id())->where('status', 'completed')->count(),
            ]);
        }

        return response()->json([]);
    }

    public function notifications()
    {
        // Cek meeting yang baru mulai & kirim notif jika belum ada
        $this->checkMeetingStart();

        // Cek tagihan jatuh tempo & hampir jatuh tempo
        $this->checkDueTagihan();

        // Cek pending approval (GM/CEO)
        $this->checkPendingApprovals();

        $notifs = Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->latest()
            ->take(20)
            ->get(['id', 'type', 'title', 'message', 'url', 'created_at']);

        return response()->json([
            'count' => $notifs->count(),
            'items' => $notifs,
        ]);
    }

    private function checkMeetingStart(): void
    {
        $userId = auth()->id();
        $now = Carbon::now();
        $today = $now->toDateString();

        // ── 1. Meeting biasa yang baru mulai (dalam 2 menit terakhir) ──
        $startedMeetings = MeetingInvitation::where('user_id', $userId)
            ->whereHas('meeting', function ($q) use ($now, $today) {
                $q->whereIn('status', ['approved', 'confirmed', 'in_progress'])
                    ->where('meeting_date', $today)
                    ->where('start_time', '<=', $now->format('H:i:s'))
                    ->where('start_time', '>=', $now->copy()->subMinutes(2)->format('H:i:s'));
            })
            ->with('meeting.room')
            ->get();

        foreach ($startedMeetings as $inv) {
            $m = $inv->meeting;
            $key = 'meeting_start_'.$m->id;
            // Cek apakah notif ini sudah pernah dikirim (pakai message sebagai key unik)
            $already = Notification::where('user_id', $userId)
                ->where('type', 'meeting')
                ->where('message', 'LIKE', '%'.$key.'%')
                ->exists();

            if (! $already) {
                Notification::create([
                    'user_id' => $userId,
                    'type' => 'meeting',
                    'title' => 'Meeting Dimulai 🟢',
                    'message' => $m->title.' di '.$m->room->name.' sudah dimulai! ['.$key.']',
                    'url' => route('invitation.index'),
                    'is_read' => false,
                ]);
            }
        }

        // ── 2. Meeting mingguan yang baru mulai (dalam 2 menit terakhir) ──
        $startedWeekly = WeeklyMeetingInvitation::where('user_id', $userId)
            ->whereHas('session', function ($q) use ($now, $today) {
                $q->whereIn('status', ['active', 'extended'])
                    ->where('session_date', $today)
                    ->where('start_time', '<=', $now->format('H:i:s'))
                    ->where('start_time', '>=', $now->copy()->subMinutes(2)->format('H:i:s'));
            })
            ->with('session.weeklyMeeting.room')
            ->get();

        foreach ($startedWeekly as $inv) {
            $s = $inv->session;
            $key = 'weekly_start_'.$s->id;
            $already = Notification::where('user_id', $userId)
                ->where('type', 'meeting')
                ->where('message', 'LIKE', '%'.$key.'%')
                ->exists();

            if (! $already) {
                Notification::create([
                    'user_id' => $userId,
                    'type' => 'meeting',
                    'title' => 'Meeting Mingguan Dimulai 🔁',
                    'message' => $s->weeklyMeeting->title.' di '.$s->weeklyMeeting->room->name.' sudah dimulai! ['.$key.']',
                    'url' => route('weekly.index'),
                    'is_read' => false,
                ]);
            }
        }
    }

    private function checkDueTagihan(): void
    {
        $userId = auth()->id();

        // Cache: cek cukup sekali per 5 menit per user
        $cacheKey = 'tagihan_check_'.$userId;
        if (Cache::get($cacheKey)) {
            return;
        }

        $today = Carbon::today();
        $threeDays = Carbon::today()->addDays(3);

        $models = [
            'payments' => ['class' => Payment::class, 'query' => fn ($q) => $q->where('jenis', 'listrik')],
            'wifi_payments' => ['class' => WifiPayment::class, 'query' => null],
            'pembayaran_aset_digital' => ['class' => PembayaranAsetDigital::class, 'query' => null],
            'pembayaran_ipl_ruko' => ['class' => PembayaranIplRuko::class, 'query' => null],
        ];

        $labelMap = ['payments' => 'Listrik', 'wifi_payments' => 'Internet', 'pembayaran_aset_digital' => 'Aset Digital', 'pembayaran_ipl_ruko' => 'IPL Ruko'];

        $inserts = [];

        foreach ($models as $table => $cfg) {
            $dueColumn = $table === 'wifi_payments' ? 'masa_tenggang' : 'jatuh_tempo';
            $q = $cfg['class']::where(function ($q) use ($today, $threeDays, $dueColumn) {
                $q->where('status', 'jatuh_tempo')
                    ->orWhere(function ($q2) use ($today, $threeDays, $dueColumn) {
                        $q2->where($dueColumn, '>=', $today)
                            ->where($dueColumn, '<=', $threeDays)
                            ->where('status', '!=', 'lunas')
                            ->where('status', '!=', 'pending');
                    });
            });

            if ($cfg['query']) {
                ($cfg['query'])($q);
            }

            $records = $q->get();

            foreach ($records as $r) {
                $keyId = "tagihan_{$table}_{$r->id}";

                // Cek dedup via indexed column
                $already = Notification::where('user_id', $userId)
                    ->where('dedup_key', $keyId)
                    ->exists();

                if (! $already) {
                    $label = $r->periode ?? $r->nama_internet ?? $cfg['class']::class.' #'.$r->id;
                    $nominal = $r->nominal ?? $r->biaya ?? 0;
                    $inserts[] = [
                        'user_id' => $userId,
                        'type' => 'tagihan',
                        'title' => 'Tagihan '.($labelMap[$table] ?? $table),
                        'message' => "{$label} — Rp ".number_format($nominal, 0, ',', '.'),
                        'dedup_key' => $keyId,
                        'url' => route('payment-approval.tagihan'),
                        'is_read' => false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        if ($inserts) {
            Notification::insert($inserts);
        }

        Cache::put($cacheKey, true, now()->addMinutes(5));
    }

    private function checkPendingApprovals(): void
    {
        $role = auth()->user()->role;
        if (! in_array($role, ['gm', 'ceo'])) {
            return;
        }

        $userId = auth()->id();

        // Cache: cek cukup sekali per 5 menit per user
        $cacheKey = 'approval_check_'.$userId;
        if (Cache::get($cacheKey)) {
            return;
        }

        $models = [
            'payments' => ['class' => Payment::class, 'query' => fn ($q) => $q->where('jenis', 'listrik')],
            'wifi_payments' => ['class' => WifiPayment::class, 'query' => null],
            'pembayaran_aset_digital' => ['class' => PembayaranAsetDigital::class, 'query' => null],
            'pembayaran_ipl_ruko' => ['class' => PembayaranIplRuko::class, 'query' => null],
        ];

        $labelMap = ['payments' => 'Listrik', 'wifi_payments' => 'Internet', 'pembayaran_aset_digital' => 'Aset Digital', 'pembayaran_ipl_ruko' => 'IPL Ruko'];

        $inserts = [];

        foreach ($models as $table => $cfg) {
            $q = $cfg['class']::where('status', 'pending');

            if ($cfg['query']) {
                ($cfg['query'])($q);
            }

            $records = $q->get();

            foreach ($records as $r) {
                $keyId = "approval_{$table}_{$r->id}";

                $already = Notification::where('user_id', $userId)
                    ->where('dedup_key', $keyId)
                    ->exists();

                if (! $already) {
                    $label = $r->periode ?? $r->nama_internet ?? $cfg['class']::class.' #'.$r->id;
                    $inserts[] = [
                        'user_id' => $userId,
                        'type' => 'approval',
                        'title' => 'Persetujuan '.($labelMap[$table] ?? $table),
                        'message' => "{$label} menunggu persetujuan",
                        'dedup_key' => $keyId,
                        'url' => route('admin.payment-approvals.index'),
                        'is_read' => false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        if ($inserts) {
            Notification::insert($inserts);
        }

        Cache::put($cacheKey, true, now()->addMinutes(5));
    }

    public function clearDueTagihanCache(): void
    {
        Cache::forget('tagihan_check_'.auth()->id());
        Cache::forget('approval_check_'.auth()->id());
    }

    public function markRead(Request $request)
    {
        $query = Notification::where('user_id', auth()->id())
            ->where('is_read', false);

        if ($request->input('type')) {
            $query->where('type', $request->input('type'));
        }

        $query->update(['is_read' => true, 'read_at' => now()]);

        return response()->json(['success' => true]);
    }

    public function markReadSingle(int $id)
    {
        Notification::where('id', $id)
            ->where('user_id', auth()->id())
            ->update(['is_read' => true, 'read_at' => now()]);

        return response()->json(['success' => true]);
    }
}
