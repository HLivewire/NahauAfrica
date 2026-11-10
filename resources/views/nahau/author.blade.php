@extends('nahau.layout')
@section('nx_title'){{ $author->name }}@endsection
@section('nx_desc'){{ \Illuminate\Support\Str::limit($author->bio, 180) }}@endsection
@section('nx_ld')<script type="application/ld+json">{!! json_encode(array_filter(['@context'=>'https://schema.org','@type'=>'Person','name'=>$author->name,'jobTitle'=>$author->role,'url'=>$author->website]), JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}</script>@endsection
@section('nx')
<div class="nx-banner" style="background:var(--nx-grey);border-bottom-color:var(--nx-red)">
    <div class="nx-wrap" style="display:flex;gap:28px;align-items:center;flex-wrap:wrap">
        <div class="nx-avatar" style="width:112px;height:112px;font-size:44px">@if($author->photo)<img src="{{ media_url($author->photo) }}" alt="">@else{{ mb_strtoupper(mb_substr($author->name,0,1)) }}@endif</div>
        <div style="flex:1 1 380px">
            <nav class="nx-crumbs" aria-label="Breadcrumb"><a href="{{ nroute('home') }}">{{ __('Home') }}</a> / {{ __('Authors') }}</nav>
            <h1 class="nx-h1" style="font-size:clamp(34px,5vw,52px)">{{ $author->name }}</h1>
            <p class="nx-meta" style="font-size:16px;margin:6px 0 12px">{{ trim($author->role.($author->city ? ' · '.$author->city : ''),' ·') }}</p>
            <p class="nx-lead" style="max-width:720px">{{ $author->bio }}</p>
            @if($author->website)<p style="margin-top:10px"><a class="nx-link" rel="noopener nofollow" href="{{ $author->website }}">{{ __('Website') }} ↗</a></p>@endif
        </div>
    </div>
</div>
<div class="nx-sec"><div class="nx-wrap">
    <h2 class="nx-h2">{{ __('Stories by') }} {{ $author->name }}</h2>
    @if($stories->isEmpty())<p class="nx-empty">{{ __('No stories match yet. Try another format or search term.') }}</p>
    @else<div class="nx-grid nx-grid--3">@foreach($stories as $s)@include('nahau.partials.card')@endforeach</div><div class="maan-pagination" style="margin-top:36px">{{ $stories->links() }}</div>@endif
</div></div>
@endsection
