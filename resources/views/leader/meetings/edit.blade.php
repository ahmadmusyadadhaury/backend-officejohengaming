@extends('layouts.app')
@section('title', 'Edit Meeting')
@section('page-title', 'Edit Meeting')
@section('sidebar-menu') @include(auth()->user()->hasFullAccess() ? 'partials.sidebar-admin' : 'partials.sidebar-leader') @endsection
@section('content')
<div class="pt-2 max-w-lg">
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 text-center">
        <p class="text-yellow-700 font-medium">Meeting yang sudah disubmit tidak dapat diedit.</p>
        <p class="text-yellow-600 text-sm mt-1">Batalkan meeting ini dan buat request baru jika perlu perubahan.</p>
        <a href="{{ route('koordinator.meetings.show', $meeting) }}" class="inline-block mt-4 px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary-light transition">Kembali ke Detail</a>
    </div>
</div>
@endsection
