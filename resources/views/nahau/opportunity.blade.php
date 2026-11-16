@extends('nahau.layout')
@section('nx_title'){{ $o->title }}@endsection
@section('nx_desc'){{ $o->description }}@endsection
@section('nx_class')nx-s-jobs-careers @endsection
@section('nx')
@include('nahau.partials.opportunity_icons')
@php
    $isMail = filter_var($o->apply_link, FILTER_VALIDATE_EMAIL);
    $href = $isMail ? 'mailto:'.$o->apply_link : $o->apply_link;
    $left = $o->daysLeft();
    $mode = \App\Models\NahauOpportunity::WORK_MODES[$o->work_mode] ?? null;
    $secs = [
        ['About the position', nlines($o->about, 'para')], ['Key responsibilities', nlines($o->responsibilities)],
        ['Qualifications and requirements', nlines($o->qualifications)], ['Remuneration and benefits', nlines($o->benefits)],
        ['Application requirements', nlines($o->apply_notes)],
    ];
    $n = 0;
@endphp
<div class="nx-read nx-job" style="padding-top:36px;padding-bottom:72px;max-width:860px">
    <nav class="nx-crumbs" aria-label="Breadcrumb"><a href="{{ nroute('home') }}">{{ __('Home') }}</a> / <a href="{{ nroute('jobs-careers') }}">{{ nsection('jobs-careers','name') }}</a> / <a href="{{ nroute('opportunities') }}">{{ __('Opportunities') }}</a></nav>

    <header class="nx-jobhead">
        <div class="nx-opp-logo nx-opp-logo--lg">@if($o->employer_logo)<img src="{{ media_url($o->employer_logo) }}" alt="">@else<span>{{ mb_strtoupper(mb_substr($o->employer, 0, 1)) }}</span>@endif</div>
        <div>
            <h1 class="nx-title" style="font-size:clamp(26px,3.6vw,38px);line-height:1.15">{{ $o->title }}</h1>
            <p class="nx-opp-emp" style="margin:4px 0 10px">{{ $o->employer }}</p>
            <div class="nx-opp-chips">
                @if($o->isNew())<span class="nx-new">{!! nxi('spark') !!}{{ __('New') }}</span>@endif
                <span class="nx-badge">{{ __(config('nahau.opportunity_types')[$o->type] ?? ucfirst($o->type)) }}</span>
                <span class="nx-badge nx-badge--line">{{ __('Closes') }} {{ ndate($o->closing_date) }}</span>
                @if($left >= 0 && $left <= 7)<span class="nx-soon">{!! nxi('bolt') !!}{{ $left === 0 ? __('Closes today') : trans_choice('{1} Closes in 1 day|[2,*] Closes in :n days', $left, ['n' => $left]) }}</span>@endif
            </div>
        </div>
    </header>
    <ul class="nx-opp-meta nx-jobmeta">
        <li>{!! nxi('pin') !!}{{ $o->location }}</li>
        @if($mode)<li>{!! nxi('brief') !!}{{ __($mode) }}</li>@endif
        @if(!$mode || strcasecmp($o->terms, $mode))<li>{!! nxi('tag') !!}{{ $o->terms }}</li>@endif
        <li>{!! nxi('clock') !!}{{ __('Posted') }} {{ nposted($o->postedAt()) }}</li>
        <li>{!! nxi('cal') !!}{{ __('Deadline') }} {{ ndate($o->closing_date) }}</li>
    </ul>

    <p class="nx-lead" style="margin:6px 0 26px">{{ $o->description }}</p>

    @foreach($secs as [$t, $html])@if($html)
    <section class="nx-jobsec"><h2>{{ ++$n }}. {{ __($t) }}</h2><div class="nx-jobtxt">{!! $html !!}</div></section>
    @endif @endforeach

    <section class="nx-howto">
        <h2>{{ __('How to apply for this opportunity') }}</h2>
        <p>{{ __('Check the requirements above, then apply on the employer\'s official site using the button below. Have your documents ready and submit before the closing date.') }}</p>
        <p style="margin:10px 0 16px">{{ __('Application deadline') }}: <strong>{{ ndate($o->closing_date) }}</strong></p>
        <a class="nx-btn" data-nx-track="opportunity_apply_click" data-id="{{ $o->id }}" href="{{ $href }}" target="_blank" rel="noopener nofollow">{{ __("Apply on employer's site") }} ↗</a>
    </section>

    <section class="nx-aboutco">
        <div class="nx-opp-logo">@if($o->employer_logo)<img src="{{ media_url($o->employer_logo) }}" alt="">@else<span>{{ mb_strtoupper(mb_substr($o->employer, 0, 1)) }}</span>@endif</div>
        <div><span class="nx-eyebrow" style="font-size:11px">{{ __('About the employer') }}</span><div style="font:700 19px 'Source Serif 4',Georgia,serif">{{ $o->employer }}</div>@if($o->employer_about)<p style="margin-top:6px;color:var(--nx-body);font-size:16px">{{ $o->employer_about }}</p>@endif</div>
    </section>

    <div class="nx-warn" style="margin-top:30px">{{ __('Nahau Africa never charges to apply.') }} <a href="{{ nroute('contact') }}?reason={{ urlencode('Report a suspicious advert') }}">{{ __('Report a suspicious advert') }}</a></div>
</div>
@endsection
