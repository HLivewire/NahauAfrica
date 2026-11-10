@extends('nahau.layout')
@section('nx_title'){{ __('Write for Us') }}@endsection
@section('nx_desc'){{ __('Your story could find its home here.') }}@endsection
@section('nx')
@php
    $kinds = [['fiction','Short stories, flash fiction and serialised chapters set in African places and lives.'],['relationships','Personal essays, interviews and stories about love, family, friendship and community.'],['jobs-careers','Working-life stories, career changes, business journeys and lessons from setbacks.'],['african-heroes','Researched profiles and community hero nominations, with sources for factual claims.']];
    $steps = [['Submit','Send your piece using the form below.'],['Editorial review','We check quality, relevance, originality and, where it applies, factual accuracy.'],['Develop together','If selected, an editor works with you on revisions.'],['Publish','You agree the publication terms and your story goes live with your byline.']];
    $pre = request('section');
    $ok = session('nahau_ok');
@endphp
<div class="nx-grey"><div class="nx-wrap" style="padding-top:72px;padding-bottom:72px">
    <p class="nx-eyebrow" style="color:var(--nx-red-text)">{{ __('Write for us') }}</p>
    <h1 class="nx-h1" style="margin:16px 0 26px;max-width:860px">{{ __('Your story could find its home here.') }}</h1>
    <p class="nx-lead" style="max-width:760px;margin-bottom:16px">{{ __('Do you have a short story, a personal experience, a working-life lesson, or the story of someone whose contribution deserves recognition? Nahau Africa welcomes original writing that brings African experiences and imagination to life.') }}</p>
    <p class="nx-lead" style="max-width:760px;margin-bottom:28px">{{ __('We look for a clear voice, thoughtful storytelling, and respect for the people represented. You do not need to be an established author. You need a story worth sharing and the willingness to develop it with care.') }}</p>
    <a class="nx-btn" href="#submit">{{ __('Send us your story') }}</a>
</div></div>

<div class="nx-sec nx-sec--sm"><div class="nx-wrap">
    <h2 class="nx-h2">{{ __('What we publish') }}</h2>
    <div class="nx-grid nx-grid--4">@foreach($kinds as [$k,$d])<div class="nx-tile"><h3>{{ nsection($k,'name') }}</h3><p>{{ __($d) }}</p><span class="nx-meta" style="margin-top:auto;padding-top:6px">{{ __('Length') }}: [{{ __('word count') }}]</span></div>@endforeach</div>
</div></div>

<div class="nx-sec nx-sec--sm" style="padding-top:0"><div class="nx-wrap">
    <h2 class="nx-h2">{{ __('How it works') }}</h2>
    <div class="nx-grid nx-grid--4">@foreach($steps as $i=>[$n,$d])<div class="nx-step"><span class="n">{{ $i+1 }}</span><h3>{{ __($n) }}</h3><p style="color:#4A4A4A">{{ __($d) }}</p></div>@endforeach</div>
</div></div>

<div class="nx-sec nx-sec--sm" style="padding-top:0"><div class="nx-wrap"><div class="nx-grid nx-grid--3">
    <div class="nx-note"><h3>{{ __('Your rights') }}</h3><p>{{ __('You keep ownership of your work unless a separate agreement says otherwise. Our publication agreement sets out exactly what permission you grant us to display, promote, translate or adapt your piece.') }}</p></div>
    <div class="nx-note"><h3>{{ __('Originality and previous publication') }}</h3><p>{{ __('Work must be your own, with sources credited. Previously published work: [policy to be confirmed].') }}</p></div>
    <div class="nx-note"><h3>{{ __('Payment and consent') }}</h3><p>{{ __('[Payment arrangements to be confirmed.] Personal accounts need consent from the people involved, and we can protect identities.') }}</p></div>
</div></div></div>

<div class="nx-sec" id="submit" style="padding-top:24px"><div class="nx-wrap">
<div class="nx-formbox">
@if($ok)
    <div class="nx-ok" role="status"><h3>{{ __('Asante') }}, {{ $ok['first'] ?? '' }} — {{ __("we've received your story.") }}</h3>
        <p style="margin-bottom:18px">{{ __('Our editors will review it for quality, relevance and originality, and get back to you by email.') }}@if(!empty($ok['ref'])) {{ __('Your reference is') }} <strong>{{ $ok['ref'] }}</strong>.@endif</p>
        <a class="nx-btn" href="{{ nroute('home') }}">{{ __('Keep reading Nahau Africa') }}</a></div>
@else
    <h2 class="nx-h2" style="margin-bottom:6px">{{ __('Send us your story') }}</h2>
    <p class="nx-meta" style="margin-bottom:30px">{{ __('Fields marked * are required.') }}</p>
    <form class="nx-form" method="POST" action="{{ route('nahau.write.store') }}" enctype="multipart/form-data" novalidate data-nx-submit="submission_sent">
        @csrf @include('nahau.partials.hp')
        <div class="nx-formgrid">
            <div class="nx-field"><label for="w-name">{{ __('Full name') }} *</label><input id="w-name" class="nx-input" name="name" value="{{ old('name') }}" autocomplete="name" aria-describedby="e-name">@include('nahau.partials.field_error',['f'=>'name'])</div>
            <div class="nx-field"><label for="w-email">{{ __('Email') }} *</label><input id="w-email" class="nx-input" type="email" name="email" value="{{ old('email') }}" autocomplete="email" aria-describedby="e-email">@include('nahau.partials.field_error',['f'=>'email'])</div>
            <div class="nx-field"><label for="w-section">{{ __('Section') }} *</label><select id="w-section" class="nx-input" name="section">@foreach(nsections() as $k=>$c)<option value="{{ $k }}" @selected(old('section',$pre)===$k)>{{ nsection($k,'name') }}</option>@endforeach</select></div>
            <div class="nx-field"><label for="w-lang">{{ __('Language') }} *</label><select id="w-lang" class="nx-input" name="language">@foreach(['English'=>'English','Kiswahili'=>'Kiswahili','Both'=>__('Both')] as $v=>$l)<option value="{{ $v }}" @selected(old('language')===$v)>{{ $l }}</option>@endforeach</select></div>
        </div>
        <div class="nx-field"><label for="w-title">{{ __('Working title') }} *</label><input id="w-title" class="nx-input" name="title" value="{{ old('title') }}" aria-describedby="e-title">@include('nahau.partials.field_error',['f'=>'title'])</div>
        <div class="nx-field"><label for="w-sum">{{ __('Short summary (2–3 sentences)') }}</label><textarea id="w-sum" class="nx-input" name="summary" rows="3">{{ old('summary') }}</textarea></div>
        <div class="nx-field"><label for="w-body">{{ __('Your story') }} *</label><textarea id="w-body" class="nx-input" name="body" rows="8" placeholder="{{ __('Paste your story here, or attach a file below') }}" aria-describedby="e-body">{{ old('body') }}</textarea>@include('nahau.partials.field_error',['f'=>'body'])</div>
        <div class="nx-field"><label for="w-file">{{ __('Attach a file (.doc, .docx or .pdf, max 10 MB)') }}</label><input id="w-file" class="nx-input" type="file" name="file" accept=".doc,.docx,.pdf" aria-describedby="e-file">@include('nahau.partials.field_error',['f'=>'file'])</div>
        <div style="display:flex;flex-direction:column;gap:14px">
            <div><label class="nx-check"><input type="checkbox" name="original" value="1" @checked(old('original'))><span>{{ __('This is my original work, and I have credited any sources.') }} *</span></label>@include('nahau.partials.field_error',['f'=>'original'])</div>
            <label class="nx-check"><input type="checkbox" name="consent" value="1" @checked(old('consent'))><span>{{ __('This piece describes real people, and I have their consent (or have changed identifying details).') }}</span></label>
            <label class="nx-check"><input type="checkbox" name="published_before" value="1" @checked(old('published_before'))><span>{{ __('This piece has been published before (please tell us where in the summary).') }}</span></label>
        </div>
        <p class="nx-meta"><a href="{{ nroute('privacy') }}" style="text-decoration:underline">{{ __('Privacy notice') }}</a></p>
        <div style="display:flex;align-items:center;gap:20px;flex-wrap:wrap"><button class="nx-btn" type="submit">{{ __('Submit for review') }}</button><span class="nx-meta" style="font-size:15px">{{ __('We aim to reply within') }} {{ config('nahau.reply_weeks') }} {{ __('weeks') }}.</span></div>
    </form>
@endif
</div></div></div>
@endsection
