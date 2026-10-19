@if ($paginator->hasPages())
    <nav class="custom-pagination-nav" aria-label="Pagination">
        <ul class="pagination-list">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link-btn"><i class="fa-solid fa-chevron-left"></i></span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link-btn" href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fa-solid fa-chevron-left"></i></a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link-text">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link-btn active">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link-btn" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link-btn" href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="fa-solid fa-chevron-right"></i></a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link-btn"><i class="fa-solid fa-chevron-right"></i></span>
                </li>
            @endif
        </ul>
    </nav>
@endif
