@extends('nahau-account.layout')
@section('title', $title)
@section('content')
<div class="ph rise"><div><h2>{{ $title }}</h2><p>{{ $sub }}</p></div></div>
<div class="card rise">
@forelse($stories as $s)
  @php $img = nimage($s); @endphp
  <div class="lrow"><div class="cv" @if($img) style="background-image:url('{{ $img }}')" @endif></div>
    <div class="gw"><b>{{ $s->title }}</b><span>{{ nsection($s->section, 'name') }}@if($s->format) · {{ $s->format }}@endif · {{ \App\Nahau\Stories::authorName($s) }}</span></div>
    <div class="acts"><a class="btn sm" href="{{ \App\Nahau\Stories::url($s) }}">Soma</a>
      @if($action === 'fav')<form method="post" action="{{ route('account.favourites.remove', $s->id) }}">@csrf @method('DELETE')<button class="btn sm sec" type="submit">Ondoa</button></form>@endif
      @if($action === 'later')<form method="post" action="{{ route('account.later.toggle', $s->id) }}">@csrf<button class="btn sm sec" type="submit">Ondoa</button></form>@endif</div></div>
@empty
  <div class="empty">{{ $empty }}</div>
@endforelse
</div>
@endsection
