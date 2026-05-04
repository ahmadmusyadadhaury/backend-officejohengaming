@extends('layouts.app')
@section('title', 'Buat MOM')
@section('page-title', 'Buat Minutes of Meeting')
@section('sidebar-menu') @include('partials.sidebar-leader') @endsection
@section('content')
<div class="pt-2 max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <p class="text-sm text-gray-500 mb-4">Meeting: <span class="font-medium text-primary">{{ $meeting->title }}</span> · {{ $meeting->meeting_date->format('d M Y') }}</p>
        <form method="POST" action="{{ route('koordinator.meetings.mom.store', $meeting) }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ringkasan Pembahasan <span class="text-red-500">*</span></label>
                <textarea name="summary" rows="3" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent">{{ old('summary') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Keputusan <span class="text-red-500">*</span></label>
                <textarea name="decisions" rows="3" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent">{{ old('decisions') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Action Plan <span class="text-red-500">*</span></label>
                <textarea name="action_plan" rows="3" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent">{{ old('action_plan') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Penanggung Jawab (PIC) <span class="text-red-500">*</span></label>
                <input type="text" name="pic" value="{{ old('pic') }}" required placeholder="Nama penanggung jawab"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Upload File (Opsional)</label>
                <input type="file" name="file" accept=".pdf,.doc,.docx"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent">
                <p class="text-xs text-gray-400 mt-1">Format: PDF, DOC, DOCX</p>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="px-5 py-2 bg-accent text-white rounded-lg text-sm hover:bg-accent/90 transition">Simpan Draft</button>
                <a href="{{ route('koordinator.meetings.show', $meeting) }}" class="px-5 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm hover:bg-gray-200 transition">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
