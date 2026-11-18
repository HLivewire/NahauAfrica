@extends('nahau-account.layout')
@section('title', 'Hadithi zangu')
@section('content')
@php
  use App\Nahau\ReaderNotes;
  $tag = ['new' => ['to', 'Imetumwa'], 'under_review' => ['to', 'Inapitiwa'], 'revisions' => ['tb', 'Marekebisho'], 'accepted' => ['g', 'Imekubaliwa'], 'declined' => ['tb', 'Haijakubaliwa']];
  $step = ['new' => 1, 'under_review' => 2, 'revisions' => 2, 'accepted' => 3, 'declined' => 3];
@endphp
<div class="ph rise"><div><h2>Hadithi zangu</h2><p>Hadithi ulizotuma na hali ya kila moja.</p></div><div class="sp"></div><a class="btn" href="{{ nroute('write') }}">Tuma hadithi mpya</a></div>
@forelse($subs as $s)
<div class="card rise" style="margin-bottom:14px">
  <div style="display:flex;gap:12px;align-items:center;flex-wrap:wrap"><div style="min-width:0;flex:1"><h4>{{ $s->title }}</h4><p class="sub-t">{{ $s->reference }} · {{ nsection($s->section, 'name') ?: $s->section }} · {{ $s->language }} · {{ $s->created_at?->format('d M Y') }}</p></div>
    <span class="tag {{ ($tag[$s->status][0] ?? 'o') === 'g' ? 'g' : (($tag[$s->status][0] ?? 'o') === 'tb' ? 'o' : 'o') }}">{{ $tag[$s->status][1] ?? $s->status }}</span></div>
  @php $n = $step[$s->status] ?? 1; @endphp
  <div class="steps2"><div class="d">Imetumwa</div><div class="{{ $n >= 2 ? 'd' : '' }}">Inapitiwa</div><div class="{{ $n >= 3 ? 'd' : '' }}">{{ $s->status === 'declined' ? 'Haijakubaliwa' : 'Imekubaliwa' }}</div></div>
  @if($s->notes && in_array($s->status, ['revisions', 'declined', 'accepted'], true))<div class="sub-t" style="margin-top:8px"><b>Maelezo ya mhariri:</b> {{ $s->notes }}</div>@endif
  @if($s->status === 'revisions')<a class="btn sm sec" style="margin-top:10px" href="{{ nroute('write') }}">Tuma toleo jipya</a>@endif
</div>
@empty
<div class="card rise"><div class="empty">Bado hujatuma hadithi. Bonyeza "Tuma hadithi" ili uanze. Hadithi unazotuma kwa barua pepe ile ile ya akaunti yako zinaonekana hapa.</div></div>
@endforelse
@if($subs->total() > $subs->perPage())<div class="card rise">@include('nahau-account._pager', ['p' => $subs])</div>@endif
@endsection
