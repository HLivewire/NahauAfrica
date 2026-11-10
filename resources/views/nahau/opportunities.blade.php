@extends('nahau.layout')
@section('nx_title'){{ __('Opportunities') }} — {{ nsection($section,'name') }}@endsection
@section('nx_desc'){{ __('Curated, editor-verified jobs, internships, training and grants.') }}@endsection
@section('nx_class')nx-s-jobs-careers @endsection
@section('nx_ld')
@foreach($list->where('type','job') as $o)
<script type="application/ld+json">{!! json_encode(['@context'=>'https://schema.org','@type'=>'JobPosting','title'=>$o->title,'description'=>$o->description,'datePosted'=>$o->verified_on?->toDateString(),'validThrough'=>$o->closing_date->toDateString(),'employmentType'=>$o->terms,'hiringOrganization'=>['@type'=>'Organization','name'=>$o->employer],'jobLocation'=>['@type'=>'Place','address'=>$o->location]], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}</script>
@endforeach
@endsection

@section('nx')
@include('nahau.partials.banner')
<div class="nx-wrap">
    <div class="nx-tabs" role="group" aria-label="{{ __('View') }}">
        <a class="nx-chip" href="{{ nroute('jobs-careers') }}" aria-pressed="false">{{ __('Stories') }}</a>
        <a class="nx-chip is-on" href="{{ nroute('opportunities') }}" aria-current="page" aria-pressed="true">{{ __('Opportunities') }}</a>
    </div>
    <div class="nx-sec nx-sec--sm" style="padding-top:28px" data-nx-opps data-url="{{ nroute('opportunities') }}">
        <div class="nx-warn" role="note">{{ __('Nahau Africa never charges to apply. Every listing is checked with the employer before it is published. If anyone asks you for money to secure a job,') }} <a href="{{ nroute('contact') }}?reason={{ urlencode('Report a suspicious advert') }}">{{ __('report it to us') }}</a>.</div>
        <div class="nx-chips" role="group" aria-label="{{ __('Filter by type') }}" style="margin-bottom:20px">
            <a class="nx-chip {{ !$type ? 'is-on' : '' }}" aria-pressed="{{ !$type ? 'true':'false' }}" href="{{ nroute('opportunities') }}">{{ __('All') }}</a>
            @foreach(config('nahau.opportunity_types') as $k => $label)
            <a class="nx-chip {{ $type===$k ? 'is-on' : '' }}" aria-pressed="{{ $type===$k ? 'true':'false' }}" href="{{ nroute('opportunities') }}?type={{ $k }}">{{ __($label) }}</a>
            @endforeach
        </div>
        <div id="nx-opp-results" aria-live="polite">@include('nahau.partials.opportunity_list')</div>
        <div class="nx-employer" id="employer">
            <div><h3 style="font-size:26px;margin-bottom:6px">{{ __('Hiring or offering training?') }}</h3><p style="color:#4A4A4A">{{ __('Share a genuine opportunity. We verify every advert before it goes live.') }}</p></div>
            <button class="nx-btn nx-btn--dark" type="button" data-nx-toggle="#nx-opp-form" aria-expanded="{{ $errors->any() || session('nahau_opp_ok') ? 'true':'false' }}">{{ __('Submit an opportunity') }}</button>
        </div>
        <div id="nx-opp-form" @unless($errors->any() || session('nahau_opp_ok')) hidden @endunless style="margin-top:30px">
            @include('nahau.partials.opportunity_form')
        </div>
        <p class="nx-meta" style="margin-top:22px">{{ __('Nahau Africa never collects CVs or applications on this site.') }}</p>
    </div>
</div>
@endsection
