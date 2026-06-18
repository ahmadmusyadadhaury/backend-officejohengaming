<?php

namespace App\Providers;

use App\Models\Asset;
use App\Models\Meeting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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

        // Share notification data dengan semua views
        View::composer('*', function ($view) {
            if (auth()->check()) {
                // Jadwal meeting terdekat
                $upcomingMeetings = Meeting::with(['requester', 'team', 'room'])
                    ->whereIn('status', ['approved', 'confirmed', 'in_progress'])
                    ->where('meeting_date', '>=', today())
                    ->orderBy('meeting_date')
                    ->orderBy('start_time')
                    ->take(3)
                    ->get();

                // Pembayaran Mendatang
                $upcomingPayments = Meeting::with(['requester', 'room'])
                    ->where('status', 'pending')
                    ->orderBy('meeting_date')
                    ->take(3)
                    ->get();

                // Peringatan Kadaluarsa (Aset dengan stock rendah)
                $upcomingAlerts = Asset::where('quantity', '<=', 2)
                    ->orderBy('quantity')
                    ->take(3)
                    ->get();

                $view->with(compact('upcomingMeetings', 'upcomingPayments', 'upcomingAlerts'));
            }
        });
    }
}
