@extends('nahau.layout')
@section('nx_title'){{ nlocale()==='sw' && $p->title_sw ? $p->title_sw : $p->title_en }}@endsection
@section('nx')
<div class="nx-read" style="padding-top:56px;padding-bottom:80px">
    <nav class="nx-crumbs" aria-label="Breadcrumb"><a href="{{ nroute('home') }}">{{ __('Home') }}</a> / {{ nlocale()==='sw' && $p->title_sw ? $p->title_sw : $p->title_en }}</nav>
    <h1 class="nx-title" style="font-size:clamp(34px,5vw,50px)">{{ nlocale()==='sw' && $p->title_sw ? $p->title_sw : $p->title_en }}</h1>
    <div class="nx-body">{!! nclean(nlocale()==='sw' && $p->body_sw ? $p->body_sw : $p->body_en) !!}</div>
</div>
@endsection
