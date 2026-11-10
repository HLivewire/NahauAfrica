@extends('nahau.layout')
@php use App\Nahau\Stories; @endphp
@section('nx_title'){{ __('African stories. Told in our voices.') }}@endsection
@section('nx_desc'){{ __('Discover fiction, lived experiences, relationship stories, working lives, and remarkable people from across Africa.') }}@endsection
@section('nx_ld')
<script type="application/ld+json">{!! json_encode(['@context'=>'https://schema.org','@graph'=>[['@type'=>'Organization','name'=>'Nahau Africa','url'=>url('/'),'logo'=>media_url(settings()->logo)],['@type'=>'WebSite','name'=>'Nahau Africa','url'=>url('/'),'potentialAction'=>['@type'=>'SearchAction','target'=>nroute('search').'?q={search_term_string}','query-input'=>'required name=search_term_string']]]], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}</script>
@endsection

@section('nx')
<div class="nx-hero">
    <div class="nx-wrap">
        <p class="nx-eyebrow" style="color:var(--nx-red-text)">{{ __('Our Stories. Our Voices.') }}</p>
        <h1 class="nx-h1">{{ __('African stories. Told in our voices.') }}</h1>
        <p class="nx-lead">{{ __('Discover fiction, lived experiences, relationship stories, working lives, and remarkable people from across Africa.') }}</p>
        <div class="nx-actions">
            <a class="nx-btn" href="{{ nroute('fiction') }}">{{ __('Explore Stories') }}</a>
            <a class="nx-btn nx-btn--ghost" href="{{ nroute('write') }}">{{ __('Write for Us') }}</a>
        </div>
    </div>
</div>

@if($featured)
@php $fi = nimage($featured); @endphp
<div class="nx-sec nx-sec--sm" style="padding-top:8px">
    <div class="nx-wrap">
        <article class="nx-featured nx-s-{{ $featured->section }}">
            <div class="nx-media">@if($fi)<img src="{{ $fi }}" alt="{{ $featured->image_alt ?: '' }}" width="900" height="620">@else<span>{{ nsection($featured->section,'name') }}</span>@endif</div>
            <div>
                <p class="nx-eyebrow">{{ __('Featured story') }}</p>
                <h2><a class="nx-stretch" href="{{ Stories::url($featured) }}">{{ $featured->title }}</a></h2>
                <p class="nx-lead" style="margin-bottom:14px">{{ Stories::dek($featured) }}</p>
                <p class="nx-meta">{{ Stories::authorName($featured) }} · {{ nsection($featured->section,'name') }} · {{ Stories::minutes($featured) }} {{ __('min') }} · {{ $featured->language === 'sw' ? 'Kiswahili' : 'English' }}</p>
            </div>
        </article>
    </div>
</div>
@endif

<div class="nx-sec nx-grey">
    <div class="nx-wrap">
        <h2 class="nx-h2">{{ __('Explore our sections') }}</h2>
        <div class="nx-grid nx-grid--4">
            @foreach(nsections() as $k => $c)
            <div class="nx-seccard nx-s-{{ $k }}">
                <h3><a class="nx-stretch" href="{{ nroute($k) }}">{{ nsection($k,'name') }}</a></h3>
                <p class="nx-tag">{{ nsection($k,'tagline') }}</p>
                <p>{{ nsection($k,'intro') }}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="nx-sec">
    <div class="nx-wrap">
        <div style="display:flex;justify-content:space-between;align-items:baseline;gap:16px;flex-wrap:wrap">
            <h2 class="nx-h2">{{ __('Latest stories') }}</h2>
            <a class="nx-link" href="{{ nroute('fiction') }}">{{ __('See all stories') }} →</a>
        </div>
        @if($latest->isEmpty())
            <p class="nx-empty">{{ __('No stories match yet. Try another format or search term.') }}</p>
        @else
            <div class="nx-grid nx-grid--3">@foreach($latest as $s)@include('nahau.partials.card')@endforeach</div>
        @endif
    </div>
</div>

@if($series)
@php
    $pub = $chapters->count();
    $last = $chapters->last();
    $first = $chapters->first();
    $recent = fn($c) => \Illuminate\Support\Carbon::parse($c->date)->gt(now()->subDays(14));
@endphp
<div class="nx-sec nx-grey">
    <div class="nx-wrap nx-split">
        <div>
            <p class="nx-eyebrow">{{ __('Follow a series') }}</p>
            <h2 class="nx-h2" style="margin:10px 0 14px">{{ $series->titleFor() }}@if($series->title_sw && $series->title) <span class="nx-meta" style="display:block;font-family:Jost,sans-serif;font-weight:400;font-size:16px;margin-top:6px" lang="{{ nlocale()==='en'?'sw':'en' }}">{{ nlocale()==='en' ? $series->title_sw : $series->title }}</span>@endif</h2>
            <p class="nx-lead" style="margin-bottom:14px">{{ $series->description }}</p>
            @if($series->rhythm)<p class="nx-meta" style="margin-bottom:22px">{{ $series->rhythm }}</p>@endif
            <div style="display:flex;gap:12px;flex-wrap:wrap">
                @if($first)<a class="nx-btn" href="{{ nroute('chapter',['slug'=>$series->slug,'n'=>$first->chapter_no]) }}">{{ __('Start at Chapter 1') }}</a>@endif
                @if($last && $pub>1)<a class="nx-btn nx-btn--ghost" href="{{ nroute('chapter',['slug'=>$series->slug,'n'=>$last->chapter_no]) }}">{{ __('Latest') }}: {{ __('Chapter') }} {{ $last->chapter_no }}</a>@endif
            </div>
        </div>
        <ul class="nx-chapters">
            @foreach($chapters as $c)
            <li><a href="{{ nroute('chapter',['slug'=>$series->slug,'n'=>$c->chapter_no]) }}"><strong>{{ __('Chapter') }} {{ $c->chapter_no }}</strong> · {{ $c->title }}</a>
                @if($recent($c))<span class="nx-status nx-status--new">{{ __('New') }}</span>@else<span class="nx-status">{{ __('Published') }}</span>@endif</li>
            @endforeach
            @if($series->next_chapter_date && $series->next_chapter_date->isFuture())
            <li><span><strong>{{ __('Chapter') }} {{ ($last->chapter_no ?? 0) + 1 }}</strong></span><span class="nx-status nx-status--soon">{{ __('Coming soon') }} · {{ ndate($series->next_chapter_date) }}</span></li>
            @endif
        </ul>
    </div>
</div>
@endif

@if($voices->isNotEmpty())
<div class="nx-sec">
    <div class="nx-wrap">
        <div class="nx-car-head"><h2 class="nx-h2" style="margin:0">{{ __('Meet the voices') }}</h2></div>
        <div class="nx-carousel" data-nx-carousel data-interval="3600" role="region" aria-roledescription="carousel" aria-label="{{ __('Meet the voices') }}">
            <button type="button" class="nx-car-arrow nx-car-arrow--prev" data-car="prev" aria-label="{{ __('Previous') }}"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 6l-6 6 6 6"/></svg></button>
            <button type="button" class="nx-car-arrow nx-car-arrow--next" data-car="next" aria-label="{{ __('Next') }}"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 6l6 6-6 6"/></svg></button>
            <div class="nx-car-track" tabindex="0">
            @foreach($voices as $a)
            <div class="nx-car-item" role="group" aria-roledescription="slide"><div class="nx-person">
                <div class="nx-avatar">@if($a->photo && ($av = nimage($a->photo)))<img src="{{ $av }}" alt="{{ $a->name }}" width="64" height="64" loading="lazy">@else<svg viewBox="0 0 24 24" width="30" height="30" aria-hidden="true" fill="currentColor"><path d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10zm0 2c-4.4 0-8 2.2-8 5v2h16v-2c0-2.8-3.6-5-8-5z"/></svg>@endif</div>
                <div><a class="nx-stretch" href="{{ nroute('author',['slug'=>$a->slug]) }}" style="font-weight:600;font-size:18px">{{ $a->name }}</a>
                    <div class="nx-meta">{{ trim($a->role.($a->city ? ' · '.$a->city : ''),' ·') }}</div>
                    <div class="nx-link" style="font-size:15px">{{ $a->story_count }} {{ trans_choice('{1} story|[2,*] stories', $a->story_count) }} →</div></div>
            </div></div>
            @endforeach
            </div>
        </div>
    </div>
</div>
@endif

@include('nahau.partials.newsletter', ['uid' => 'home'])

@endsection
