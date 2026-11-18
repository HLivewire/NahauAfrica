@extends('nahau-account.layout')
@section('title', 'Taarifa')
@section('content')
<div class="ph rise"><div><h2>Taarifa</h2><p>Hadithi mpya, African Heroes, hali ya hadithi yako, kazi na fursa.</p></div><div class="sp"></div>
  @if($unread)<form method="post" action="{{ route('account.notifications.read') }}">@csrf<button class="btn sec" type="submit">Weka zote zimesomwa</button></form>@endif</div>
<div class="card rise">@include('nahau-account._notes', ['list' => $notes])</div>
@endsection
