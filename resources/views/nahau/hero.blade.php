@extends('nahau.layout')
@section('nx_title'){{ $hero->name }}@endsection
@section('nx_desc'){{ \Illuminate\Support\Str::limit($hero->spotlight_summary ?: $story->dek, 200) }}@endsection
@section('nx_image'){{ ($hero->portrait ? media_url($hero->portrait) : null) ?: nimage($story) ?: media_url(settings()->logo) }}@endsection
@section('nx_class')nx-s-african-heroes @endsection
@section('nx_ld')
<script type="application/ld+json">{!! json_encode(array_filter(['@context'=>'https://schema.org','@type'=>'Person','name'=>$hero->name,'birthDate'=>$hero->born,'deathDate'=>$hero->died,'nationality'=>$hero->country,'description'=>$hero->known_for,'image'=>$hero->portrait?media_url($hero->portrait):null]), JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}</script>
@endsection
@section('nx')
@php $hero_ = true; @endphp
@include('nahau.partials.story_body', ['hero' => $hero])
@endsection
