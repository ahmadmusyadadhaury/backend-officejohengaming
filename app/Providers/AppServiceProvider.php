<?php

namespace App\Providers;

use App\Models\Asset;
use App\Models\Meeting;
use App\Models\Team;
use App\Models\VehiclePajakRequest;
use App\Models\WeeklyMeetingSession;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Auto-sync gaming.css ke public/css (pakai hash agar selalu sync)
        $src = resource_path('css/gaming.css');
        $dest = public_path('css/gaming.css');
        if (file_exists($src)) {
            if (! file_exists($dest) || md5_file($src) !== md5_file($dest)) {
                @mkdir(public_path('css'), 0755, true);
                @copy($src, $dest);
            }
        }

        // Auto-sync Tailwind CSS dari Vite build output ke public/css/tailwind.css
        $twDest = public_path('css/tailwind.css');
        $buildDir = public_path('build/assets');
        if (is_dir($buildDir)) {
            $cssFiles = glob($buildDir.'/app-*.css');
            if (! empty($cssFiles)) {
                usort($cssFiles, function ($a, $b) {
                    return filemtime($b) - filemtime($a);
                });
                $twSrc = $cssFiles[0];
                if (! file_exists($twDest) || md5_file($twSrc) !== md5_file($twDest)) {
                    @mkdir(public_path('css'), 0755, true);
                    @copy($twSrc, $twDest);
                }
            }
        }

        // Share notification data hanya untuk layout utama (bukan partials/ajax)
        View::composer('layouts.app', function ($view) {
            if (auth()->check()) {
                // Jadwal meeting terdekat
                $upcomingMeetings = Meeting::with(['requester', 'team', 'room'])
                    ->whereIn('status', ['approved', 'confirmed', 'in_progress'])
                    ->where('meeting_date', '>=', today())
                    ->orderBy('meeting_date')
                    ->orderBy('start_time')
                    ->take(3)
                    ->get()
                    ->map(function ($m) {
                        $m->meeting_type = 'regular';

                        return $m;
                    });

                $upcomingWeeklySessions = WeeklyMeetingSession::with('weeklyMeeting.room')
                    ->where('session_date', '>=', today())
                    ->whereIn('status', ['active', 'extended'])
                    ->orderBy('session_date')
                    ->orderBy('start_time')
                    ->take(3)
                    ->get()
                    ->map(function ($s) {
                        $m = new Meeting;
                        $m->title = $s->weeklyMeeting->title;
                        $m->meeting_date = $s->session_date;
                        $m->start_time = $s->start_time;
                        $m->end_time = $s->end_time;
                        $m->room = $s->weeklyMeeting->room;
                        $team = new Team;
                        $team->name = 'Weekly';
                        $m->team = $team;
                        $m->meeting_type = 'weekly';

                        return $m;
                    });

                $upcomingMeetings = $upcomingMeetings->merge($upcomingWeeklySessions)
                    ->sortBy('meeting_date')
                    ->sortBy('start_time')
                    ->take(3);

                // Peringatan Kadaluarsa (Aset dengan stock rendah)
                $upcomingAlerts = Asset::where('quantity', '<=', 2)
                    ->orderBy('quantity')
                    ->take(3)
                    ->get();

                // Pengajuan Pajak Pending (untuk approver)
                $pendingPajakApprovalsCount = VehiclePajakRequest::where('status', 'pending')->count();

                $view->with(compact('upcomingMeetings', 'upcomingAlerts', 'pendingPajakApprovalsCount'));
            }
        });
    }
}
