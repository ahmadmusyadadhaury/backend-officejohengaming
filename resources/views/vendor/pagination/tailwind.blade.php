@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}">

        {{-- Mobile --}}
        <div class="flex gap-2 items-center justify-between sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center px-4 py-2 text-xs font-medium cursor-not-allowed rounded-full transition-colors"
                    style="color:var(--text-muted);background:var(--bg-surface);border:1px solid var(--border-color);opacity:0.5;">
                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    Prev
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                    class="inline-flex items-center px-4 py-2 text-xs font-medium rounded-full transition-colors"
                    style="color:var(--text-primary);background:var(--bg-surface);border:1px solid var(--border-color);"
                    onmouseover="this.style.background='var(--bg-surface-2)';this.style.borderColor='var(--color-accent)'"
                    onmouseout="this.style.background='var(--bg-surface)';this.style.borderColor='var(--border-color)'">
                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    Prev
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                    class="inline-flex items-center px-4 py-2 text-xs font-medium rounded-full transition-colors"
                    style="color:var(--text-primary);background:var(--bg-surface);border:1px solid var(--border-color);"
                    onmouseover="this.style.background='var(--bg-surface-2)';this.style.borderColor='var(--color-accent)'"
                    onmouseout="this.style.background='var(--bg-surface)';this.style.borderColor='var(--border-color)'">
                    Next
                    <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            @else
                <span class="inline-flex items-center px-4 py-2 text-xs font-medium cursor-not-allowed rounded-full transition-colors"
                    style="color:var(--text-muted);background:var(--bg-surface);border:1px solid var(--border-color);opacity:0.5;">
                    Next
                    <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </span>
            @endif
        </div>

        {{-- Desktop --}}
        <div class="hidden sm:flex sm:items-center sm:justify-end">
            <span class="inline-flex items-center gap-1 rounded-full"
                style="background:var(--bg-surface);border:1px solid var(--border-color);padding:4px;">

                {{-- Previous --}}
                @if ($paginator->onFirstPage())
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full cursor-not-allowed"
                        style="color:var(--text-muted);opacity:0.4;" aria-hidden="true">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                        class="inline-flex items-center justify-center w-8 h-8 rounded-full transition-colors"
                        style="color:var(--text-primary);"
                        onmouseover="this.style.background='var(--bg-surface-2)'"
                        onmouseout="this.style.background='transparent'"
                        aria-label="{{ __('pagination.previous') }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </a>
                @endif

                {{-- Page Numbers --}}
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="inline-flex items-center justify-center w-8 h-8 text-xs cursor-default"
                            style="color:var(--text-muted);">{{ $element }}</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-semibold"
                                    style="background:var(--color-accent);color:#fff;">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}"
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-medium transition-colors"
                                    style="color:var(--text-primary);"
                                    onmouseover="this.style.background='var(--bg-surface-2)'"
                                    onmouseout="this.style.background='transparent'"
                                    aria-label="{{ __('Go to page :page', ['page' => $page]) }}">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                        class="inline-flex items-center justify-center w-8 h-8 rounded-full transition-colors"
                        style="color:var(--text-primary);"
                        onmouseover="this.style.background='var(--bg-surface-2)'"
                        onmouseout="this.style.background='transparent'"
                        aria-label="{{ __('pagination.next') }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                @else
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full cursor-not-allowed"
                        style="color:var(--text-muted);opacity:0.4;" aria-hidden="true">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </span>
                @endif

            </span>
        </div>
    </nav>
@endif
