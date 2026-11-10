@extends('nahau.layout')
@section('nx_title'){{ __('My favourites') }}@endsection
@section('nx')
<div class="nx-banner" style="background:var(--nx-grey);border-bottom-color:var(--nx-red)">
    <div class="nx-wrap">
        <h1 class="nx-h1" style="font-size:clamp(34px,5vw,52px)">{{ __('My favourites') }}</h1>
        <p class="nx-lead">{{ __('Stories you saved with the heart.') }}</p>
    </div>
</div>
<div class="nx-sec">
    <div class="nx-wrap">
        @if($stories->isEmpty())
            <p class="nx-empty">{{ __('You have not saved any stories yet. Tap the heart on a book cover to save it here.') }}</p>
        @else
            <div class="nx-grid nx-grid--3">@foreach($stories as $s)@include('nahau.partials.card', ['s' => $s])@endforeach</div>
        @endif
    </div>
</div>
@endsection
