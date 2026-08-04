@extends('layouts.app')
@section('title', $ticket->ticket_number)
@section('page-title', $ticket->ticket_number)
@section('page-subtitle', $ticket->title)
@section('sidebar-menu')
@if(auth()->user()->isTicketTeam())
    @include('partials.sidebar-admin')
@elseif(in_array(auth()->user()->role, ['koordinator', 'head_of_store', 'gm', 'hr', 'ceo']))
    @include('partials.sidebar-leader')
@else
    @include('partials.sidebar-user')
@endif
@endsection

@section('content')
@include('tickets.partials.detail-content')
@endsection

@push('scripts')
<script>
    (function() {
        const stars = document.querySelectorAll('.rating-star');
        const valueInput = document.getElementById('rating-value');
        if (!stars.length || !valueInput) return;

        function highlight(n) {
            stars.forEach(s => {
                const val = parseInt(s.dataset.rating, 10);
                s.classList.toggle('active', val <= n);
            });
        }

        stars.forEach(star => {
            const val = parseInt(star.dataset.rating, 10);
            star.addEventListener('mouseenter', () => highlight(val));
            star.addEventListener('click', () => {
                valueInput.value = val;
                highlight(val);
            });
        });

        document.getElementById('rating-stars').addEventListener('mouseleave', () => {
            highlight(valueInput.value || 0);
        });

        const commentsBox = document.getElementById('ticket-comments');
        if (commentsBox) commentsBox.scrollTop = commentsBox.scrollHeight;
    })();
</script>
@endpush
