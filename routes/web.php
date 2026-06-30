<?php

use App\Http\Controllers\Admin\AdminAccountController;
use App\Http\Controllers\Admin\AsetRukoController;
use App\Http\Controllers\Admin\AssetController;
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\DigitalAssetController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\MeetingController as AdminMeetingController;
use App\Http\Controllers\Admin\MomController as AdminMomController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\PeralatanKantorController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SimCardController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\Admin\VehiclePajakRequestController;
use App\Http\Controllers\Admin\WeeklyMeetingController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\Leader\DashboardController as KoordinatorDashboard;
use App\Http\Controllers\Leader\MeetingController as KoordinatorMeetingController;
use App\Http\Controllers\Leader\MomController;
use App\Http\Controllers\MomExportController;
use App\Http\Controllers\OverrideRequestController;
use App\Http\Controllers\PaymentApprovalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PushController;
use App\Http\Controllers\RealtimeController;
use App\Http\Controllers\User\DashboardController as UserDashboard;
use App\Http\Controllers\WeeklySessionController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('storage/{path}', function (string $path) {
    $fullPath = Storage::disk('public')->path($path);
    if (!file_exists($fullPath)) {
        abort(404);
    }
    return response()->file($fullPath);
})->where('path', '.*');

Route::get('/', function () {
    if (auth()->check()) {
        $role = auth()->user()->role;
        if (in_array($role, User::FULL_ACCESS_ROLES)) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route($role.'.dashboard');
    }

    return redirect()->route('login');
});

// Admin Routes — semua role full access
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::resource('teams', TeamController::class);
    Route::resource('assets', AssetController::class);
    Route::get('moms', [AdminMomController::class, 'index'])->name('moms.index');
    Route::resource('vehicles', VehicleController::class)->except(['create', 'show', 'edit']);
    Route::patch('vehicles/{vehicle}/status', [VehicleController::class, 'updateStatus'])->name('vehicles.status');
    Route::post('vehicles/{vehicle}/pajak-request', [VehiclePajakRequestController::class, 'store'])->name('vehicles.pajak-request.store');
    Route::get('vehicles/pajak-requests/pending', [VehiclePajakRequestController::class, 'pending'])->name('vehicles.pajak-requests.pending');
    Route::post('vehicles/pajak-requests/{id}/approve', [VehiclePajakRequestController::class, 'approve'])->name('vehicles.pajak-requests.approve');
    Route::post('vehicles/pajak-requests/{id}/reject', [VehiclePajakRequestController::class, 'reject'])->name('vehicles.pajak-requests.reject');
    Route::resource('digital-assets', DigitalAssetController::class)->except(['create', 'show', 'edit']);
    Route::resource('sim-cards', SimCardController::class)->except(['create', 'show', 'edit']);
    Route::resource('peralatan-kantor', PeralatanKantorController::class)->except(['create', 'show', 'edit']);
    Route::resource('ruko', AsetRukoController::class)->except(['create', 'show', 'edit']);
    Route::get('pembayaran', [PaymentController::class, 'index'])->name('pembayaran.index');
    Route::post('pembayaran', [PaymentController::class, 'store'])->name('pembayaran.store');
    Route::put('pembayaran/{id}', [PaymentController::class, 'update'])->name('pembayaran.update');
    Route::delete('pembayaran/{id}', [PaymentController::class, 'destroy'])->name('pembayaran.destroy');
    Route::post('pembayaran/ipl-bulk', [PaymentController::class, 'bulkIpl'])->name('pembayaran.ipl-bulk');
    Route::post('token-reading', [PaymentController::class, 'storeTokenReading'])->name('pembayaran.token-reading.store');
    Route::delete('token-reading/{id}', [PaymentController::class, 'destroyTokenReading'])->name('pembayaran.token-reading.destroy');
    Route::post('token-topup', [PaymentController::class, 'storeTokenPayment'])->name('pembayaran.token-topup.store');
    Route::delete('token-topup/{id}', [PaymentController::class, 'destroyTokenPayment'])->name('pembayaran.token-topup.destroy');
    Route::get('payment-approvals', [PaymentApprovalController::class, 'index'])->name('payment-approvals.index');
    Route::post('payment-approvals/{id}/approve', [PaymentApprovalController::class, 'approve'])->name('payment-approvals.approve');
    Route::post('payment-approvals/{id}/reject', [PaymentApprovalController::class, 'reject'])->name('payment-approvals.reject');
    Route::get('payment-approvals/export', [PaymentApprovalController::class, 'exportApprovals'])->name('payment-approvals.export');
    Route::get('export', [ExportController::class, 'export'])->name('export');

    // // Chat — hidden
    // Route::get('/chat/conversations', [ChatController::class, 'conversations'])->name('chat.conversations');
    // Route::get('/chat/messages', [ChatController::class, 'messages'])->name('chat.messages');
    // Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');
    // Route::get('/chat/unread', [ChatController::class, 'unreadCount'])->name('chat.unread');
});

// Hanya Admin & HR
Route::middleware(['auth', 'admin_hr'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('rooms', AdminRoomController::class);
    Route::get('meetings', [AdminMeetingController::class, 'index'])->name('meetings.index');
    Route::get('meetings/{meeting}', [AdminMeetingController::class, 'show'])->name('meetings.show');
    Route::patch('meetings/{meeting}/approve', [AdminMeetingController::class, 'approve'])->name('meetings.approve');
    Route::patch('meetings/{meeting}/reject', [AdminMeetingController::class, 'reject'])->name('meetings.reject');
    Route::delete('meetings/{meeting}', [AdminMeetingController::class, 'destroy'])->name('meetings.destroy');
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
Route::middleware(['auth', 'role:user,koordinator,admin,head_of_store,gm,hr,ceo'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboard::class, 'index'])->name('dashboard');
});

// Payment Approval — Staff, Koordinator, HR, Admin submit
Route::middleware(['auth', 'role:user,koordinator,hr,admin'])->prefix('payment-approval')->name('payment-approval.')->group(function () {
    Route::get('create', [PaymentApprovalController::class, 'create'])->name('create');
    Route::post('/', [PaymentApprovalController::class, 'store'])->name('store');
    Route::get('/', [PaymentApprovalController::class, 'myRequests'])->name('status');
    Route::get('tagihan', [PaymentApprovalController::class, 'tagihan'])->name('tagihan');
    Route::post('tagihan/{id}/bayar', [PaymentApprovalController::class, 'bayar'])->name('tagihan.bayar');
    Route::get('export', [PaymentApprovalController::class, 'exportStatus'])->name('export');
    Route::get('export-tagihan', [PaymentApprovalController::class, 'exportTagihan'])->name('export-tagihan');
});

// Calendar & Invitation (semua role)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');

    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');
    Route::get('/calendar/events', [CalendarController::class, 'events'])->name('calendar.events');
    Route::get('/push/vapid-key', [PushController::class, 'vapidPublicKey'])->name('push.vapid');
    Route::post('/push/subscribe', [PushController::class, 'subscribe'])->name('push.subscribe');
    Route::post('/push/unsubscribe', [PushController::class, 'unsubscribe'])->name('push.unsubscribe');
    Route::get('/realtime/meetings', [RealtimeController::class, 'meetings'])->name('realtime.meetings');
    Route::get('/realtime/weekly', [RealtimeController::class, 'weeklySessions'])->name('realtime.weekly');
    Route::get('/realtime/notif', [RealtimeController::class, 'notifCount'])->name('realtime.notif');
    Route::get('/realtime/dashboard', [RealtimeController::class, 'dashboardStats'])->name('realtime.dashboard');
    Route::get('/realtime/notifications', [RealtimeController::class, 'notifications'])->name('realtime.notifications');
    Route::post('/realtime/notifications/read', [RealtimeController::class, 'markRead'])->name('realtime.notifications.read');
    Route::post('/realtime/notifications/{id}/read', [RealtimeController::class, 'markReadSingle'])->name('realtime.notifications.read.single');
    Route::get('/undangan/{invitation}', [InvitationController::class, 'show'])->name('invitation.show');
    Route::get('/undangan', [InvitationController::class, 'index'])->name('invitation.index');

    // Weekly Meeting Sessions
    Route::get('/weekly-undangan', [WeeklySessionController::class, 'index'])->name('weekly.index');
    Route::get('/weekly-undangan/{invitation}', [WeeklySessionController::class, 'show'])->name('weekly.show');
    Route::post('/weekly-session/{session}/contribute', [WeeklySessionController::class, 'contribute'])->name('weekly.contribute');
    Route::post('/weekly-session/{session}/extend', [WeeklySessionController::class, 'extend'])->name('weekly.extend');
    Route::post('/weekly-session/{session}/complete', [WeeklySessionController::class, 'complete'])->name('weekly.complete');

    // Override Routes
    Route::get('/override/create', [OverrideRequestController::class, 'create'])->name('override.create');
    Route::post('/override', [OverrideRequestController::class, 'store'])->name('override.store');
    Route::get('/override/{override}', [OverrideRequestController::class, 'show'])->name('override.show');
    Route::patch('/override/{override}/accept', [OverrideRequestController::class, 'accept'])->name('override.accept');
    Route::patch('/override/{override}/reject', [OverrideRequestController::class, 'reject'])->name('override.reject');

    // MOM Export
    Route::get('/mom/{mom}/export', [MomExportController::class, 'export'])->name('mom.export');
});
