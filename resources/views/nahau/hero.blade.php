@extends('nahau.layout')
@section('nx_title'){{ $hero->name }}@endsection
@section('nx_desc'){{ \Illuminate\Support\Str::limit($hero->spotlight_summary ?: $story->dek, 200) }}@endsection
@section('nx_image'){{ ($hero->portrait ? media_url($hero->portrait) : null) ?: nimage($story) ?: media_url(settings()->logo) }}@endsection
@section('nx_class')nx-s-african-heroes @endsection
@section('nx_ld')
<script type="application/ld+json">{!! json_encode(array_filter(['@context'=>'https://schema.org','@type'=>'Person','name'=>$hero->name,'birthDate'=>$hero->born,'deathDate'=>$hero->died,'nationality'=>$hero->country,'description'=>$hero->known_for,'image'=>$hero->portrait?media_url($hero->portrait):null]), JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}</script>
@endsection
@section('nx')
@if(!empty($preview))
<div style="position:sticky;top:0;z-index:999;background:#B45309;color:#fff;padding:10px 16px;font:600 14px/1.4 Jost,sans-serif;display:flex;gap:14px;align-items:center;justify-content:center;flex-wrap:wrap">
  <span>Preview · {{ $hero->active ? 'hero huyu anaonekana kwa wasomaji' : 'hero huyu bado hajaonekana kwa wasomaji' }}</span>
  <a href="{{ route('admin.nahau.index', 'heroes') }}" style="color:#fff;text-decoration:underline">Rudi kwenye Hero profiles</a>
  <form method="post" action="{{ route('admin.nahau.hero.activate', $hero->id) }}" style="margin:0">@csrf<input type="hidden" name="on" value="{{ $hero->active ? 0 : 1 }}"><button type="submit" style="border:0;border-radius:999px;padding:6px 16px;font-weight:800;cursor:pointer;background:#fff;color:#7a3a05">{{ $hero->active ? 'Zima (Inactive)' : 'Washa (Active)' }}</button></form>
</div>
@endif
@php $hero_ = true; @endphp
@include('nahau.partials.story_body', ['hero' => $hero])
@endsection
