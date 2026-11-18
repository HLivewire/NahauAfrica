@if($p->total() > $p->perPage())
<div class="pgn"><span style="margin-right:auto;color:var(--mut)">{{ $p->firstItem() }} hadi {{ $p->lastItem() }} kati ya {{ $p->total() }}</span>
  @if($p->currentPage() > 1)<a href="{{ $p->previousPageUrl() }}" aria-label="Iliyopita">&lsaquo;</a>@endif
  @foreach(range(max(1, $p->currentPage() - 2), min($p->lastPage(), $p->currentPage() + 2)) as $pg)@if($pg == $p->currentPage())<span class="on" aria-current="page">{{ $pg }}</span>@else<a href="{{ $p->url($pg) }}">{{ $pg }}</a>@endif @endforeach
  @if($p->hasMorePages())<a href="{{ $p->nextPageUrl() }}" aria-label="Inayofuata">&rsaquo;</a>@endif</div>
@endif
