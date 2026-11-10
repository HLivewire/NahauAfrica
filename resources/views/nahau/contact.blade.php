@extends('nahau.layout')
@section('nx_title'){{ __('Contact') }}@endsection
@section('nx_desc'){{ __('Enquiries, corrections, partnership proposals and reader feedback. We read every message.') }}@endsection
@section('nx')
<div class="nx-sec"><div class="nx-wrap nx-split" id="contact">
    <div><nav class="nx-crumbs" aria-label="Breadcrumb"><a href="{{ nroute('home') }}">{{ __('Home') }}</a> / {{ __('Contact') }}</nav>
        <h1 class="nx-h1" style="font-size:clamp(34px,5vw,52px);margin-bottom:16px">{{ __('Contact us') }}</h1>
        <p class="nx-lead" style="margin-bottom:16px">{{ __('Enquiries, corrections, partnership proposals and reader feedback. We read every message.') }}</p>
        <p class="nx-meta" style="font-size:16px">{{ config('nahau.contact_email') }} · {{ config('nahau.city') }}, Tanzania</p></div>
    <div>@include('nahau.contact_form')</div>
</div></div>
@endsection
