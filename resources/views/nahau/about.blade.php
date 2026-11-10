@extends('nahau.layout')
@section('nx_title'){{ __('About Us') }}@endsection
@section('nx_desc'){{ __('Africa holds countless stories. Nahau Africa is a home for these stories.') }}@endsection
@section('nx')
@php
    $values = [['Authenticity','Present African experiences with honesty, depth, and cultural understanding.'],['Creativity','Encourage original voices, fresh ideas, and engaging storytelling.'],['Dignity','Treat the people and communities represented in our stories with respect.'],['Diversity','Welcome different cultures, languages, generations, and perspectives without presenting Africa as a single experience.'],['Integrity','Distinguish fiction from factual reporting, verify factual claims, and respect intellectual property.'],['Connection','Use stories to build understanding between people whose lives may appear different.']];
    $standards = ['Fiction, personal experience, opinion and researched biography are always clearly labelled.','Factual claims are verified, and historical accounts acknowledge uncertainty or differing interpretations.','Personal accounts and images are published only with permission; identities are protected where needed.','Extra care is taken with stories involving children or sensitive experiences.','Sponsored content and commercial relationships are always disclosed.','Errors are corrected openly through an accessible corrections process.'];
@endphp
<div class="nx-sec nx-wrap nx-split" style="padding-bottom:56px">
    <div><p class="nx-eyebrow" style="color:var(--nx-red-text)">{{ __('About Nahau Africa') }}</p>
        <h1 class="nx-h1" style="margin:16px 0 24px">{{ __('Africa holds countless stories.') }}</h1>
        <p class="nx-lead">{{ __('Some are remembered across generations. Others unfold quietly in homes, workplaces, villages, and cities every day. Nahau Africa is a home for these stories.') }}</p></div>
    <div class="nx-lead" style="display:flex;flex-direction:column;gap:18px;padding-top:30px;font-size:18px">
        <p>{{ __('We publish fiction, personal experiences, and researched features that reflect the diversity of African life. We welcome emerging and established voices, celebrate imagination, and give attention to experiences that deserve to be heard.') }}</p>
        <p>{{ __('Our stories explore the relationships we build, the work we do, the choices we make, and the people who shape our communities.') }}</p>
        <p>{{ __('Whether you are reading from the continent, the diaspora, or discovering these perspectives for the first time, there is a place for you here.') }}</p>
        <p style="font-weight:600;color:var(--nx-red-text)">{{ __('Our Stories. Our Voices.') }}</p></div>
</div>
<div class="nx-wrap" style="padding-bottom:72px"><div class="nx-grid" style="grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:24px">
    <div class="nx-vm" style="background:var(--nx-tint);border-color:var(--nx-tint2)"><p class="nx-eyebrow" style="color:var(--nx-red-text)">{{ __('Vision') }}</p><p class="q">{{ __('To become a trusted home for African stories, connecting people across generations, communities, and borders.') }}</p></div>
    <div class="nx-vm"><p class="nx-eyebrow" style="color:var(--nx-red-text)">{{ __('Mission') }}</p><p class="q">{{ __('To publish compelling stories that entertain, preserve lived experiences, celebrate African voices, and inspire meaningful conversation.') }}</p></div>
</div></div>
<div class="nx-wrap" style="padding-bottom:72px"><h2 class="nx-h2">{{ __('What we stand for') }}</h2>
    <div class="nx-grid nx-grid--3">@foreach($values as [$n,$d])<div class="nx-tile"><h3>{{ __($n) }}</h3><p>{{ __($d) }}</p></div>@endforeach</div></div>
<div class="nx-grey" id="standards"><div class="nx-wrap nx-split" style="padding-top:72px;padding-bottom:72px">
    <div><h2 class="nx-h2" style="margin-bottom:14px">{{ __('Editorial standards') }}</h2>
        <p class="nx-lead">{{ __('Reader trust is central to Nahau Africa. Every story is labelled as Fiction, Personal experience, Opinion or Researched biography, so you always know what you are reading.') }}</p>
        <p style="margin-top:16px"><a class="nx-link" href="{{ nroute('standards') }}">{{ __('Read the full editorial standards') }} →</a></p></div>
    <div style="display:flex;flex-direction:column;gap:16px">@foreach($standards as $t)<div class="nx-tick"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="#FF0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 10.5l4 4 8-9"/></svg><span>{{ __($t) }}</span></div>@endforeach</div>
</div></div>
<div class="nx-wrap" style="padding-top:72px;padding-bottom:24px"><h2 class="nx-h2">{{ __('Our team') }}</h2>
    <div class="nx-grid nx-grid--3">
    @forelse($team as $m)<div class="nx-person"><div class="nx-avatar">@if($m->photo)<img src="{{ media_url($m->photo) }}" alt="">@else{{ mb_strtoupper(mb_substr($m->name,0,1)) }}@endif</div><div><div style="font-weight:600;font-size:18px">{{ $m->name }}</div><div class="nx-meta" style="font-size:15px">{{ $m->role }}</div></div></div>
    @empty @foreach(['Founder & Editor-in-Chief','Fiction Editor','Features & Research Editor'] as $r)<div class="nx-person"><div class="nx-avatar"></div><div><div style="font-weight:600;font-size:18px">[{{ __('Name') }}]</div><div class="nx-meta" style="font-size:15px">{{ __($r) }}</div></div></div>@endforeach @endforelse
    </div></div>
<div class="nx-wrap nx-split" id="contact" style="padding-top:56px;padding-bottom:88px">
    <div><h2 class="nx-h2" style="margin-bottom:14px">{{ __('Contact us') }}</h2><p class="nx-lead" style="margin-bottom:16px">{{ __('Enquiries, corrections, partnership proposals and reader feedback. We read every message.') }}</p><p class="nx-meta" style="font-size:16px">{{ config('nahau.contact_email') }} · {{ config('nahau.city') }}, Tanzania</p></div>
    <div>@include('nahau.contact_form')</div>
</div>
@endsection
