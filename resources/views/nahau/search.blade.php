@extends('nahau.layout')
@section('nx_title'){{ $term !== '' ? __('Search').': '.$term : __('Search') }}@endsection
@section('nx')
@php use App\Nahau\Stories; @endphp
<div class="nx-banner" style="background:var(--nx-grey);border-bottom-color:var(--nx-red)">
    <div class="nx-wrap">
        <h1 class="nx-h1" style="font-size:clamp(34px,5vw,52px)">{{ __('Search') }}</h1>
        <form class="nx-searchbar" method="GET" action="{{ nroute('search') }}" role="search">
            <label class="nx-hp" for="s-q">{{ __('Search') }}</label>
            <input id="s-q" class="nx-input" type="search" name="q" value="{{ $term }}" placeholder="{{ __('Search stories, heroes, authors…') }}">
            <select class="nx-input" name="section" aria-label="{{ __('Section') }}" style="flex:0 1 190px"><option value="">{{ __('All sections') }}</option>@foreach(nsections() as $k=>$c)<option value="{{ $k }}" @selected($section===$k)>{{ nsection($k,'name') }}</option>@endforeach</select>
            <select class="nx-input" name="lang" aria-label="{{ __('Language') }}" style="flex:0 1 150px"><option value="">{{ __('Any language') }}</option><option value="en" @selected($lang==='en')>English</option><option value="sw" @selected($lang==='sw')>Kiswahili</option></select>
            <button class="nx-btn" type="submit">{{ __('Search') }}</button>
        </form>
    </div>
</div>
<div class="nx-sec nx-sec--sm"><div class="nx-wrap">
@if($term === '')
    <p class="nx-empty">{{ __('Type at least two letters to search.') }}</p>
@else
    <p class="nx-count" data-nx-search-count="{{ $count }}" data-term="{{ $term }}">{{ $count }} {{ trans_choice('{1} result|[0,*] results', $count) }} {{ __('for') }} “{{ $term }}”</p>
    @if($count === 0)
        <p class="nx-empty">{{ __('No results found. Try a different word, or browse a section:') }}</p>
        <div class="nx-chips">@foreach(nsections() as $k=>$c)<a class="nx-chip" href="{{ nroute($k) }}">{{ nsection($k,'name') }}</a>@endforeach</div>
    @endif
    @if($stories->isNotEmpty())<h2 class="nx-h2">{{ __('Stories') }}</h2><div class="nx-grid nx-grid--3" style="margin-bottom:48px">@foreach($stories as $s)@include('nahau.partials.card')@endforeach</div>@endif
    @if($heroes->isNotEmpty())<h2 class="nx-h2">{{ __('Heroes') }}</h2><div class="nx-grid nx-grid--3" style="margin-bottom:48px">@foreach($heroes as [$h,$s])@include('nahau.partials.card')@endforeach</div>@endif
    @if($opps->isNotEmpty())<h2 class="nx-h2">{{ __('Opportunities') }}</h2>@foreach($opps as $o)<article class="nx-opp nx-s-jobs-careers"><div><span class="nx-badge">{{ __(config('nahau.opportunity_types')[$o->type] ?? '') }}</span><h3><a href="{{ nroute('opportunity',['slug'=>$o->slug]) }}">{{ $o->title }}</a></h3><p class="nx-meta">{{ $o->employer }} · {{ $o->location }} · {{ __('Closes') }} {{ ndate($o->closing_date) }}</p></div></article>@endforeach<div style="margin-bottom:40px"></div>@endif
    @if($authors->isNotEmpty())<h2 class="nx-h2">{{ __('Authors') }}</h2><div class="nx-grid nx-grid--3">@foreach($authors as $a)<div class="nx-person"><div class="nx-avatar">{{ mb_strtoupper(mb_substr($a->name,0,1)) }}</div><div><a class="nx-stretch" style="font-weight:600;font-size:18px" href="{{ nroute('author',['slug'=>$a->slug]) }}">{{ $a->name }}</a><div class="nx-meta">{{ $a->role }}</div></div></div>@endforeach</div>@endif
@endif
</div></div>
@endsection
