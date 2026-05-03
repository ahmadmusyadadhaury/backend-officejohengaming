<?php

use App\Http\Controllers\Admin\AssetController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WeeklyMeetingController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\MeetingController as AdminMeetingController;
use App\Http\Controllers\Leader\DashboardController as LeaderDashboard;
use App\Http\Controllers\Leader\MeetingController as LeaderMeetingController;
use App\Http\Controllers\Leader\MomController;
use App\Http\Controllers\User\DashboardController as UserDashboard;
use App\Http\Controllers\CalendarController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route(auth()->user()->role . '.dashboard');
    }
    return redirect()->route('login');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // User Management
    Route::resource('users', UserController::class);

    // Team Management
    Route::resource('teams', TeamController::class);

    // Room Management
    Route::resource('rooms', AdminRoomController::class);

    // Asset Management
    Route::resource('assets', AssetController::class);

    // Meeting Management
    Route::get('meetings', [AdminMeetingController::class, 'index'])->name('meetings.index');
    Route::get('meetings/{meeting}', [AdminMeetingController::class, 'show'])->name('meetings.show');
    Route::patch('meetings/{meeting}/approve', [AdminMeetingController::class, 'approve'])->name('meetings.approve');
    Route::patch('meetings/{meeting}/reject', [AdminMeetingController::class, 'reject'])->name('meetings.reject');

    // Weekly Meeting
    Route::resource('weekly-meetings', WeeklyMeetingController::class);
});

// Leader Routes
Route::middleware(['auth', 'leader'])->prefix('leader')->name('leader.')->group(function () {
    Route::get('/dashboard', [LeaderDashboard::class, 'index'])->name('dashboard');

    // Meeting Request
    Route::resource('meetings', LeaderMeetingController::class);
    Route::patch('meetings/{meeting}/confirm', [LeaderMeetingController::class, 'confirm'])->name('meetings.confirm');
    Route::patch('meetings/{meeting}/cancel', [LeaderMeetingController::class, 'cancel'])->name('meetings.cancel');
    Route::patch('meetings/{meeting}/finish', [LeaderMeetingController::class, 'finish'])->name('meetings.finish');

    // MOM
    Route::resource('meetings.mom', MomController::class)->shallow();
    Route::patch('mom/{mom}/send', [MomController::class, 'send'])->name('mom.send');
});

// User Routes
Route::middleware(['auth', 'role:user,leader,admin'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboard::class, 'index'])->name('dashboard');
});

// Calendar (semua role bisa akses)
Route::middleware('auth')->group(function () {
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');
    Route::get('/calendar/events', [CalendarController::class, 'events'])->name('calendar.events');
});
