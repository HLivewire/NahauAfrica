@extends('nahau.layout')
@section('nx_title'){{ $series->titleFor() }}@endsection
@section('nx_desc'){{ \Illuminate\Support\Str::limit($series->description, 180) }}@endsection
@section('nx_class')nx-s-fiction @endsection
@section('nx')
@php $first = $chapters->first(); $last = $chapters->last(); @endphp
<div class="nx-banner">
    <div class="nx-wrap nx-split">
        <div>
            <nav class="nx-crumbs" aria-label="Breadcrumb"><a href="{{ nroute('home') }}">{{ __('Home') }}</a> / <a href="{{ nroute('fiction') }}">{{ nsection('fiction','name') }}</a> / {{ __('Series') }}</nav>
            <p class="nx-eyebrow">{{ __('Series') }}</p>
            <h1 class="nx-h1" style="font-size:clamp(34px,5vw,54px);margin:10px 0 14px">{{ $series->titleFor() }}</h1>
            @if($series->title_sw && $series->title)<p class="nx-meta" lang="{{ nlocale()==='en'?'sw':'en' }}" style="margin-bottom:12px">{{ nlocale()==='en' ? $series->title_sw : $series->title }}</p>@endif
            <p class="nx-lead" style="margin-bottom:12px">{{ $series->description }}</p>
            @if($series->author)<p class="nx-meta">{{ __('By') }} <a style="text-decoration:underline" href="{{ nroute('author',['slug'=>$series->author->slug]) }}">{{ $series->author->name }}</a></p>@endif
            @if($series->rhythm)<p class="nx-meta" style="margin:4px 0 20px">{{ $series->rhythm }}</p>@endif
            <div style="display:flex;gap:12px;flex-wrap:wrap">
                @if($first)<a class="nx-btn" href="{{ nroute('chapter',['slug'=>$series->slug,'n'=>$first->chapter_no]) }}">{{ __('Start at Chapter 1') }}</a>@endif
                @if($last && $chapters->count()>1)<a class="nx-btn nx-btn--ghost" href="{{ nroute('chapter',['slug'=>$series->slug,'n'=>$last->chapter_no]) }}">{{ __('Latest') }}: {{ __('Chapter') }} {{ $last->chapter_no }}</a>@endif
            </div>
        </div>
        @if($series->cover)<div class="nx-media" style="aspect-ratio:4/3"><img src="{{ media_url($series->cover) }}" alt=""></div>@endif
    </div>
</div>
<div class="nx-sec nx-sec--sm"><div class="nx-wrap" style="max-width:860px">
    <h2 class="nx-h2">{{ __('Chapters') }}</h2>
    <ul class="nx-chapters">
        @forelse($chapters as $c)
        <li><a href="{{ nroute('chapter',['slug'=>$series->slug,'n'=>$c->chapter_no]) }}"><strong>{{ __('Chapter') }} {{ $c->chapter_no }}</strong> · {{ $c->title }}</a><span class="nx-meta">{{ ndate($c->date) }}</span></li>
        @empty<li>{{ __('Chapters are coming soon.') }}</li>@endforelse
        @if($series->next_chapter_date && $series->next_chapter_date->isFuture())<li><span><strong>{{ __('Chapter') }} {{ ($last->chapter_no ?? 0)+1 }}</strong></span><span class="nx-status nx-status--soon">{{ __('Coming soon') }} · {{ ndate($series->next_chapter_date) }}</span></li>@endif
    </ul>
</div></div>
@include('nahau.partials.newsletter', ['uid'=>'series','title'=>__('Get each new chapter by email')])
@endsection
