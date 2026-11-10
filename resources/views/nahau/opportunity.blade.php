@extends('nahau.layout')
@section('nx_title'){{ $o->title }}@endsection
@section('nx_desc'){{ $o->description }}@endsection
@section('nx_class')nx-s-jobs-careers @endsection
@section('nx')
@php $isMail = filter_var($o->apply_link, FILTER_VALIDATE_EMAIL); @endphp
<div class="nx-read" style="padding-top:44px;padding-bottom:72px">
    <nav class="nx-crumbs" aria-label="Breadcrumb"><a href="{{ nroute('home') }}">{{ __('Home') }}</a> / <a href="{{ nroute('jobs-careers') }}">{{ nsection('jobs-careers','name') }}</a> / <a href="{{ nroute('opportunities') }}">{{ __('Opportunities') }}</a></nav>
    <span class="nx-badge">{{ __(config('nahau.opportunity_types')[$o->type] ?? ucfirst($o->type)) }}</span>
    <h1 class="nx-title" style="font-size:clamp(32px,4.4vw,46px)">{{ $o->title }}</h1>
    <p class="nx-meta" style="font-size:16px;margin-bottom:20px">{{ $o->employer }} · {{ $o->location }} · {{ $o->terms }}</p>
    <p class="nx-lead" style="margin-bottom:24px">{{ $o->description }}</p>
    <p style="margin-bottom:22px"><strong>{{ __('Closes') }} {{ ndate($o->closing_date) }}</strong></p>
    <a class="nx-btn" data-nx-track="opportunity_apply_click" data-id="{{ $o->id }}" href="{{ $isMail ? 'mailto:'.$o->apply_link : $o->apply_link }}" target="_blank" rel="noopener nofollow">{{ __("Apply on employer's site") }} ↗</a>
    <div class="nx-warn" style="margin-top:30px">{{ __('Nahau Africa never charges to apply.') }} <a href="{{ nroute('contact') }}?reason={{ urlencode('Report a suspicious advert') }}">{{ __('Report a suspicious advert') }}</a></div>
</div>
@endsection
