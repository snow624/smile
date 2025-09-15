@if ($products->hasPages())
  <div class="pagination">
    {{-- Prev --}}
    @if ($products->onFirstPage())
      <span class="disabled">«</span>
    @else
      <a href="#" class="page-link" data-page="{{ $products->currentPage()-1 }}">«</a>
    @endif

    {{-- Pages --}}
    @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
      @if ($page == $products->currentPage())
        <span class="current">{{ $page }}</span>
      @else
        <a href="#" class="page-link" data-page="{{ $page }}">{{ $page }}</a>
      @endif
    @endforeach

    {{-- Next --}}
    @if ($products->hasMorePages())
      <a href="#" class="page-link" data-page="{{ $products->currentPage()+1 }}">»</a>
    @else
      <span class="disabled">»</span>
    @endif
  </div>
@endif
