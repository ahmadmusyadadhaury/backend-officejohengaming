@extends('layouts.app')
@section('title', 'Detail MOM')
@section('page-title', 'Minutes of Meeting')
@section('sidebar-menu') @include('partials.sidebar-leader') @endsection
@section('content')
<div class="pt-2 max-w-2xl space-y-4">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-bold text-primary text-lg">{{ $mom->meeting->title }}</h2>
            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $mom->status === 'sent' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                {{ $mom->status === 'sent' ? 'Terkirim' : 'Draft' }}
            </span>
        </div>
        <p class="text-xs text-gray-400 mb-4">{{ $mom->meeting->meeting_date->format('d M Y') }} · {{ $mom->meeting->room->name }}</p>

        <div class="space-y-4">
            @foreach(['summary'=>'Ringkasan Pembahasan','decisions'=>'Keputusan','action_plan'=>'Action Plan'] as $field => $label)
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">{{ $label }}</p>
                <p class="text-sm text-gray-700 bg-gray-50 rounded-lg p-3">{{ $mom->$field }}</p>
            </div>
            @endforeach
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Penanggung Jawab (PIC)</p>
                <p class="text-sm text-gray-700">{{ $mom->pic }}</p>
            </div>
            @if($mom->file_path)
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">File Lampiran</p>
                <a href="{{ Storage::url($mom->file_path) }}" target="_blank" class="text-sm text-accent hover:underline">Download File</a>
            </div>
            @endif
            @if($mom->sent_at)
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Dikirim Pada</p>
                <p class="text-sm text-gray-700">{{ $mom->sent_at->format('d M Y H:i') }}</p>
            </div>
            @endif
        </div>

        @if($mom->status === 'draft')
        <div class="flex gap-3 mt-6 pt-4 border-t">
            <a href="{{ route('leader.mom.edit', $mom) }}" class="px-4 py-2 bg-secondary/10 text-secondary rounded-lg text-sm hover:bg-secondary hover:text-white transition">Edit MOM</a>
            <form method="POST" action="{{ route('leader.mom.send', $mom) }}">
                @csrf @method('PATCH')
                <button class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700 transition">Kirim MOM</button>
            </form>
        </div>
        @endif
    </div>
    <a href="{{ route('leader.meetings.show', $mom->meeting_id) }}" class="inline-block text-sm text-gray-500 hover:text-primary">← Kembali ke Meeting</a>
</div>
@endsection
