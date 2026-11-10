@extends('nahau.layout')
@section('nx_title'){{ __("We couldn't find that page") }}@endsection
@section('nx')
<div class="nx-404"><div class="nx-wrap">
    <p class="nx-eyebrow" style="color:var(--nx-red-text)">404</p>
    <h1 class="nx-h1" style="margin:12px 0 14px">{{ __("We couldn't find that page") }}</h1>
    <p class="nx-lead">{{ __('Try a search, or head to one of our sections.') }}</p>
    <form class="nx-searchbar" method="GET" action="{{ nroute('search') }}" role="search"><label class="nx-hp" for="n-q">{{ __('Search') }}</label><input id="n-q" class="nx-input" type="search" name="q" placeholder="{{ __('Search') }}"><button class="nx-btn" type="submit">{{ __('Search') }}</button></form>
    <div class="nx-chips" style="justify-content:center">@foreach(nsections() as $k=>$c)<a class="nx-chip" href="{{ nroute($k) }}">{{ nsection($k,'name') }}</a>@endforeach</div>
</div></div>
@endsection
