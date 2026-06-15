<?php

use App\Http\Middleware\AdminHrMiddleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CanManageAccountsMiddleware;
use App\Http\Middleware\LeaderMiddleware;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->group(base_path('routes/auth.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'leader' => LeaderMiddleware::class,
            'role' => RoleMiddleware::class,
            'manage_accounts' => CanManageAccountsMiddleware::class,
            'admin_hr' => AdminHrMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
