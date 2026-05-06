<?php

use App\Http\Controllers\Admin\AssetController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminAccountController;
use App\Http\Controllers\Admin\WeeklyMeetingController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\MeetingController as AdminMeetingController;
use App\Http\Controllers\Leader\DashboardController as KoordinatorDashboard;
use App\Http\Controllers\Leader\MeetingController as KoordinatorMeetingController;
use App\Http\Controllers\Leader\MomController;
use App\Http\Controllers\User\DashboardController as UserDashboard;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\WeeklySessionController;
use App\Http\Controllers\RealtimeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        $role = auth()->user()->role;
        if (in_array($role, \App\Models\User::FULL_ACCESS_ROLES)) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route($role . '.dashboard');
    }
    return redirect()->route('login');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::resource('teams', TeamController::class);
    Route::resource('rooms', AdminRoomController::class);
    Route::resource('assets', AssetController::class);
    Route::get('meetings', [AdminMeetingController::class, 'index'])->name('meetings.index');
    Route::get('meetings/{meeting}', [AdminMeetingController::class, 'show'])->name('meetings.show');
    Route::patch('meetings/{meeting}/approve', [AdminMeetingController::class, 'approve'])->name('meetings.approve');
    Route::patch('meetings/{meeting}/reject', [AdminMeetingController::class, 'reject'])->name('meetings.reject');
    Route::resource('weekly-meetings', WeeklyMeetingController::class);
});

// Kelola Akun — hanya Admin Master dan HR
Route::middleware(['auth', 'manage_accounts'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('admins', AdminAccountController::class);
});

// Koordinator Routes
Route::middleware(['auth', 'leader'])->prefix('koordinator')->name('koordinator.')->group(function () {
    Route::get('/dashboard', [KoordinatorDashboard::class, 'index'])->name('dashboard');
    Route::resource('meetings', KoordinatorMeetingController::class);
    Route::patch('meetings/{meeting}/confirm', [KoordinatorMeetingController::class, 'confirm'])->name('meetings.confirm');
    Route::patch('meetings/{meeting}/cancel', [KoordinatorMeetingController::class, 'cancel'])->name('meetings.cancel');
    Route::patch('meetings/{meeting}/finish', [KoordinatorMeetingController::class, 'finish'])->name('meetings.finish');
    Route::resource('meetings.mom', MomController::class)->shallow();
    Route::patch('mom/{mom}/send', [MomController::class, 'send'])->name('mom.send');
});

// User Routes
Route::middleware(['auth', 'role:user,koordinator,admin,head_of_store,gm,hr'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboard::class, 'index'])->name('dashboard');
});

// Calendar & Invitation (semua role)
Route::middleware('auth')->group(function () {
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');
    Route::get('/calendar/events', [CalendarController::class, 'events'])->name('calendar.events');
    Route::get('/realtime/meetings', [RealtimeController::class, 'meetings'])->name('realtime.meetings');
    Route::get('/realtime/weekly', [RealtimeController::class, 'weeklySessions'])->name('realtime.weekly');
    Route::get('/realtime/notif', [RealtimeController::class, 'notifCount'])->name('realtime.notif');
    Route::get('/realtime/dashboard', [RealtimeController::class, 'dashboardStats'])->name('realtime.dashboard');
    Route::get('/undangan/{invitation}', [InvitationController::class, 'show'])->name('invitation.show');
    Route::get('/undangan', [InvitationController::class, 'index'])->name('invitation.index');

    // Weekly Meeting Sessions
    Route::get('/weekly-undangan', [WeeklySessionController::class, 'index'])->name('weekly.index');
    Route::get('/weekly-undangan/{invitation}', [WeeklySessionController::class, 'show'])->name('weekly.show');
    Route::post('/weekly-session/{session}/contribute', [WeeklySessionController::class, 'contribute'])->name('weekly.contribute');
    Route::post('/weekly-session/{session}/extend', [WeeklySessionController::class, 'extend'])->name('weekly.extend');
    Route::post('/weekly-session/{session}/complete', [WeeklySessionController::class, 'complete'])->name('weekly.complete');
});
