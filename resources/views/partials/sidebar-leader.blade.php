@php
    $hasInvitations = \App\Models\MeetingInvitation::where('user_id', auth()->id())
        ->whereHas('meeting', function($q) {
            $q->whereIn('status', ['approved','confirmed','in_progress'])
              ->where(function($q2) {
                  $q2->where('meeting_date', '>', today())
                     ->orWhere(function($q3) {
                         $q3->where('meeting_date', today())
                            ->where('end_time', '>', \Carbon\Carbon::now()->format('H:i:s'));
                     });
              });
        })->exists();

    $menus = [
        ['route' => 'koordinator.dashboard',       'label' => 'Dashboard',       'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
        ['route' => 'koordinator.meetings.index',  'label' => 'Meeting Saya',    'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
        ['route' => 'koordinator.meetings.create', 'label' => 'Request Meeting', 'icon' => 'M12 4v16m8-8H4'],
        ['route' => 'calendar',                    'label' => 'Kalender',        'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
    ];
@endphp

<p class="sidebar-section-label">Menu Utama</p>

@foreach($menus as $menu)
@php $isMeetingSaya = $menu['route'] === 'koordinator.meetings.index'; @endphp
    <a href="{{ route($menu['route']) }}"
        class="sidebar-item {{ request()->routeIs($menu['route'] . '*') ? 'active' : '' }}">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $menu['icon'] }}"/>
        </svg>
        <span class="flex-1">{{ $menu['label'] }}</span>
        @if($isMeetingSaya)
            <span class="notif-badge-activity" style="display:none;background:#ef4444;color:white;font-size:0.6rem;font-weight:700;padding:1px 5px;border-radius:999px;min-width:18px;text-align:center;"></span>
        @endif
    </a>
@endforeach

@if($hasInvitations)
    <p class="sidebar-section-label">Notifikasi</p>
    <a href="{{ route('invitation.index') }}"
        class="sidebar-item {{ request()->routeIs('invitation.*') ? 'active' : '' }}">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
        <span class="flex-1">Undangan</span>
        <span class="notif-badge-meeting" style="display:none;background:#ef4444;color:white;font-size:0.6rem;font-weight:700;padding:1px 5px;border-radius:999px;min-width:18px;text-align:center;"></span>
    </a>
@endif

<p class="sidebar-section-label">Akun</p>
<a href="{{ route('profile.edit') }}"
    class="sidebar-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
    </svg>
    Profil Saya
</a>
