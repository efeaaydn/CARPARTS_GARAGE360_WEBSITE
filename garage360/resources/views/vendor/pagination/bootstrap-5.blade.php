@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Sayfalama">
        <ul class="pagination justify-content-center flex-wrap gap-1">

            {{-- Önceki Sayfa --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link rounded-2"><i class="bi bi-chevron-left"></i> Önceki</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link rounded-2" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                        <i class="bi bi-chevron-left"></i> Önceki
                    </a>
                </li>
            @endif

            {{-- Sayfa Numaraları --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link rounded-2">{{ $element }}</span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link rounded-2">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link rounded-2" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Sonraki Sayfa --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link rounded-2" href="{{ $paginator->nextPageUrl() }}" rel="next">
                        Sonraki <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link rounded-2">Sonraki <i class="bi bi-chevron-right"></i></span>
                </li>
            @endif
        </ul>

        <p class="text-center text-muted small mt-2 mb-0">
            Toplam <strong>{{ $paginator->total() }}</strong> sonuçtan
            <strong>{{ $paginator->firstItem() }}–{{ $paginator->lastItem() }}</strong> arası gösteriliyor.
        </p>
    </nav>
@endif
