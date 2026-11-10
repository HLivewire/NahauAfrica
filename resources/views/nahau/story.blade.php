@extends('nahau.layout')
@section('nx_title'){{ $story->title }}@endsection
@section('nx_desc'){{ \Illuminate\Support\Str::limit($story->dek ?: strip_tags($story->summary ?: $story->description), 200) }}@endsection
@section('nx_image'){{ nimage($story) ?: media_url(settings()->logo) }}@endsection
@section('nx_class')nx-s-{{ $key }}@endsection
@section('nx_ld')
<script type="application/ld+json">{!! json_encode(array_filter(['@context'=>'https://schema.org','@type'=>$story->label==='Fiction'?'CreativeWork':'Article','headline'=>$story->title,'description'=>$story->dek,'inLanguage'=>$story->language,'datePublished'=>\Illuminate\Support\Carbon::parse($story->date)->toDateString(),'dateModified'=>optional($story->updated_at)->toDateString(),'author'=>['@type'=>'Person','name'=>\App\Nahau\Stories::authorName($story)],'image'=>nimage($story),'publisher'=>['@type'=>'Organization','name'=>'Nahau Africa']]), JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}</script>
<script type="application/ld+json">{!! json_encode(['@context'=>'https://schema.org','@type'=>'BreadcrumbList','itemListElement'=>[['@type'=>'ListItem','position'=>1,'name'=>'Home','item'=>nroute('home')],['@type'=>'ListItem','position'=>2,'name'=>nsection($key,'name'),'item'=>nroute($key)],['@type'=>'ListItem','position'=>3,'name'=>$story->title]]], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}</script>
@endsection
@section('nx')
@include('nahau.partials.story_body')
@endsection
