@extends('frontend.master')

@section('title'){{ trim($__env->yieldContent('nx_title')) ? trim($__env->yieldContent('nx_title')).' — ' : '' }}Nahau Africa @endsection

@section('meta_content')
    @php
        $nxTitle = trim($__env->yieldContent('nx_title')) ?: 'Nahau Africa';
        $nxDesc = trim($__env->yieldContent('nx_desc')) ?: __('Fiction, lived experiences, and remarkable lives from African perspectives.');
        $nxImage = trim($__env->yieldContent('nx_image')) ?: media_url(settings()->logo);
        $nxIsStory = request()->routeIs('n.*.story');
        $hasAlt = ! $nxIsStory || request()->attributes->get('nahau.translation_url');
    @endphp
    <meta name="description" content="{{ $nxDesc }}">
    <meta name="robots" content="index,follow">
    <link rel="canonical" href="{{ url()->current() }}">
    @if((request()->routeIs('n.*') || request()->routeIs('home','search')) && $hasAlt)
        <link rel="alternate" hreflang="{{ nlocale() }}" href="{{ url()->current() }}">
        <link rel="alternate" hreflang="{{ nlocale()==='en' ? 'sw' : 'en' }}" href="{{ nswitch_url() }}">
        <link rel="alternate" hreflang="x-default" href="{{ nlocale()==='en' ? url()->current() : nswitch_url() }}">
    @endif
    <meta property="og:site_name" content="Nahau Africa">
    <meta property="og:type" content="{{ $nxIsStory ? 'article' : 'website' }}">
    <meta property="og:title" content="{{ $nxTitle }}">
    <meta property="og:description" content="{{ $nxDesc }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ $nxImage }}">
    <meta name="twitter:card" content="summary_large_image">
    @yield('nx_ld')
@endsection

@section('main_content')
<div class="nx @yield('nx_class')" lang="{{ nlocale() }}">
    <a class="nx-skip" href="#nx-main">{{ __('Skip to content') }}</a>
    @if(session('nahau_notice'))<div class="nx-notice" role="status">{{ session('nahau_notice') }}</div>@endif
    <div id="nx-main" tabindex="-1">
        @yield('nx')
    </div>
</div>
@endsection
