@extends('nahau-account.layout')
@section('title', 'Wafuatwa')
@section('content')
<div class="ph rise"><div><h2>Wafuatwa</h2><p>Waandishi unaowafuata. Wakichapisha mapya, utaona kwenye Arifa.</p></div></div>
<div class="card rise">
@forelse($authors as $a)
  <div class="lrow"><span class="av" style="width:42px;height:42px">{{ strtoupper(mb_substr($a->name, 0, 1)) }}</span>
    <div class="gw"><b>{{ $a->name }}</b><span>Mwandishi wa Nahau Africa</span></div>
    <div class="acts"><form method="post" action="{{ route('account.follows.toggle', $a->id) }}">@csrf<button class="btn sm {{ $a->following ? 'sec' : '' }}" type="submit">{{ $a->following ? 'Unafuata ✓' : 'Fuata' }}</button></form></div></div>
@empty
  <div class="empty">Bado hakuna waandishi.</div>
@endforelse
@include('nahau-account._pager', ['p' => $authors])
</div>
@endsection
