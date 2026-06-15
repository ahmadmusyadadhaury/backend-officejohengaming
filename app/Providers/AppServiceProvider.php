<?php

namespace App\Providers;

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
    }
}
