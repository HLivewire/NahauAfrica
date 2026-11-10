@extends('nahau.layout')
@section('nx_title'){{ nsection($section,'name') }}@endsection
@section('nx_desc'){{ nsection($section,'tagline') }}. {{ nsection($section,'intro') }}@endsection
@section('nx_class')nx-s-{{ $section }}@endsection

@section('nx')
@include('nahau.partials.banner')
@if($section === 'jobs-careers')
<div class="nx-wrap"><div class="nx-tabs" role="group" aria-label="{{ __('View') }}">
    <a class="nx-chip is-on" href="{{ nroute('jobs-careers') }}" aria-current="page" aria-pressed="true">{{ __('Stories') }}</a>
    <a class="nx-chip" href="{{ nroute('opportunities') }}" aria-pressed="false">{{ __('Opportunities') }}</a>
</div></div>
@endif
<div class="nx-wrap" data-nx-listing data-url="{{ nsection_url($section) }}">
    <form class="nx-toolbar" method="GET" action="{{ nsection_url($section) }}" role="search" data-nx-filter>
        <div class="nx-chips" role="group" aria-label="{{ __('Filter by format') }}">
            <a class="nx-chip {{ !$format ? 'is-on' : '' }}" aria-pressed="{{ !$format ? 'true' : 'false' }}" href="{{ nsection_url($section, array_filter(['q'=>$q])) }}">{{ __('All') }}</a>
            @foreach($cfg['formats'] as $f)
            <a class="nx-chip {{ $format === $f ? 'is-on' : '' }}" aria-pressed="{{ $format === $f ? 'true' : 'false' }}" href="{{ nsection_url($section, array_filter(['format'=>$f,'q'=>$q])) }}">{{ __($f) }}</a>
            @endforeach
        </div>
        <div style="display:flex;gap:10px;flex:1 1 280px;max-width:420px">
            @if($format)<input type="hidden" name="format" value="{{ $format }}">@endif
            <label for="nx-sq" class="nx-hp">{{ __('Search this section') }}</label>
            <input id="nx-sq" class="nx-input" type="search" name="q" value="{{ $q }}" placeholder="{{ __('Search this section') }}">
            <button class="nx-btn nx-btn--sm" type="submit">{{ __('Search') }}</button>
        </div>
    </form>
    <div id="nx-results" aria-live="polite">@include('nahau.partials.results')</div>
    <div class="nx-sec nx-sec--sm">
        <div class="nx-prompt">
            <h3>{{ __('Have a') }} {{ nsection($section,'prompt') }}?</h3>
            <a class="nx-btn nx-btn--dark" href="{{ nroute('write') }}?section={{ $section }}">{{ __('Submit your story') }}</a>
        </div>
    </div>
</div>
@endsection
