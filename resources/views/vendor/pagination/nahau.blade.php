@if ($paginator->hasPages())
    <ul class="nahau-pagination" role="navigation" aria-label="{{ __('Pagination') }}">
        @if ($paginator->onFirstPage())
            <li class="disabled" aria-disabled="true"><span aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M15 6l-6 6 6 6"/></svg></span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="{{ __('Previous') }}"><svg viewBox="0 0 24 24"><path d="M15 6l-6 6 6 6"/></svg></a></li>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="dots"><span>{{ $element }}</span></li>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active" aria-current="page"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="{{ __('Next') }}"><svg viewBox="0 0 24 24"><path d="M9 6l6 6-6 6"/></svg></a></li>
        @else
            <li class="disabled" aria-disabled="true"><span aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M9 6l6 6-6 6"/></svg></span></li>
        @endif
    </ul>
@endif
