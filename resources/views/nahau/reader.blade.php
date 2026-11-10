<!doctype html>
<html lang="{{ $story->language === 'sw' ? 'sw' : 'en' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $story->title }} — {{ __('Reading') }} — Nahau Africa</title>
    <meta name="robots" content="noindex">
    <link rel="icon" href="{{ media_url(settings()->favicon ?? settings()->logo) }}">
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600&family=Source+Serif+4:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/css/nahau-reader.css') . '?v=' . @filemtime(public_path('frontend/css/nahau-reader.css')) }}">
</head>
<body class="rd" data-theme="light">
<div class="rd-bg" aria-hidden="true"></div>
<div class="rd-progress" aria-hidden="true"><span></span></div>

<header class="rd-bar">
    <a class="rd-back" href="{{ \App\Nahau\Stories::url($story) }}"><svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><path d="M15 5l-7 7 7 7" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg><span>{{ __('Back to book') }}</span></a>
    <div class="rd-bar-title">{{ $story->title }}</div>
    <button type="button" class="rd-gear" data-rd-open aria-haspopup="dialog" aria-controls="rd-drawer" aria-expanded="false" aria-label="{{ __('Reading settings') }}"><span class="rd-aa" aria-hidden="true">Aa</span></button>
</header>

<main class="rd-main">
    <article class="rd-paper" id="rd-paper">
        <p class="rd-eyebrow">{{ strtoupper(nsection('fiction','name')) }}@if($story->format) · {{ strtoupper(__($story->format)) }}@endif</p>
        <h1 class="rd-title">{{ $story->title }}</h1>
        <p class="rd-by">{{ __('By') }} {{ $author?->name ?? \App\Nahau\Stories::authorName($story) }}</p>
        <div class="rd-body" data-rd-body>{!! nclean($story->description) !!}</div>
        <div class="rd-end">
            <p>{{ __('The end of this part.') }}</p>
            @if($next)<a class="rd-btn" href="{{ nroute('read', ['slug' => $next->slug]) }}">{{ __('Next chapter') }} →</a>@endif
            <a class="rd-btn rd-btn--ghost" href="{{ \App\Nahau\Stories::url($story) }}">{{ __('Back to book') }}</a>
        </div>
    </article>
</main>

<div class="rd-scrim" data-rd-close hidden></div>
<aside class="rd-drawer" id="rd-drawer" role="dialog" aria-modal="true" aria-labelledby="rd-set-h" aria-hidden="true" inert>
    <div class="rd-drawer-head rd-i" style="--i:0">
        <h2 id="rd-set-h">{{ __('Reading settings') }}</h2>
        <button type="button" class="rd-x" data-rd-close aria-label="{{ __('Close') }}"><svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg></button>
    </div>

    <div class="rd-set rd-i" style="--i:1">
        <div class="rd-label"><span>{{ __('Text size') }}</span><output id="rd-size-out">20</output></div>
        <div class="rd-size">
            <button type="button" data-rd-size="-1" aria-label="{{ __('Smaller text') }}"><span style="font-size:14px">A</span></button>
            <input type="range" id="rd-size" min="15" max="44" step="1" value="20" aria-label="{{ __('Text size') }}">
            <button type="button" data-rd-size="1" aria-label="{{ __('Larger text') }}"><span style="font-size:24px">A</span></button>
        </div>
    </div>

    <div class="rd-set rd-i" style="--i:2">
        <div class="rd-label"><span>{{ __('Theme') }}</span></div>
        <div class="rd-themes" role="radiogroup" aria-label="{{ __('Theme') }}">
            <button type="button" role="radio" data-rd-theme="light" class="t-light"><i></i><span>{{ __('Light') }}</span></button>
            <button type="button" role="radio" data-rd-theme="sepia" class="t-sepia"><i></i><span>{{ __('Sepia') }}</span></button>
            <button type="button" role="radio" data-rd-theme="dark" class="t-dark"><i></i><span>{{ __('Dark') }}</span></button>
            <button type="button" role="radio" data-rd-theme="moon" class="t-moon" style="--img:url('{{ asset('uploads/images/nahau/theme_moon.jpg') }}')"><i></i><span>{{ __('Moon') }}</span></button>
            <button type="button" role="radio" data-rd-theme="stars" class="t-stars" style="--img:url('{{ asset('uploads/images/nahau/theme_stars.jpg') }}')"><i></i><span>{{ __('Stars') }}</span></button>
            <button type="button" role="radio" data-rd-theme="cliff" class="t-cliff" style="--img:url('{{ asset('uploads/images/nahau/theme_cliff.jpg') }}')"><i></i><span>{{ __('Cliff') }}</span></button>
        </div>
    </div>

    <div class="rd-set rd-i" style="--i:3">
        <div class="rd-label"><span>{{ __('Font') }}</span></div>
        <div class="rd-seg" role="radiogroup" aria-label="{{ __('Font') }}">
            <button type="button" role="radio" data-rd-font="serif">{{ __('Serif') }}</button>
            <button type="button" role="radio" data-rd-font="sans">{{ __('Sans') }}</button>
        </div>
    </div>

    <div class="rd-set rd-i" style="--i:4">
        <div class="rd-label"><span>{{ __('Line spacing') }}</span></div>
        <div class="rd-seg" role="radiogroup" aria-label="{{ __('Line spacing') }}">
            <button type="button" role="radio" data-rd-lh="1.55">{{ __('Tight') }}</button>
            <button type="button" role="radio" data-rd-lh="1.8">{{ __('Normal') }}</button>
            <button type="button" role="radio" data-rd-lh="2.05">{{ __('Loose') }}</button>
        </div>
    </div>

    <div class="rd-set rd-i" style="--i:5">
        <div class="rd-label"><span>{{ __('Page width') }}</span></div>
        <div class="rd-seg" role="radiogroup" aria-label="{{ __('Page width') }}">
            <button type="button" role="radio" data-rd-width="narrow">{{ __('Narrow') }}</button>
            <button type="button" role="radio" data-rd-width="medium">{{ __('Medium') }}</button>
            <button type="button" role="radio" data-rd-width="wide">{{ __('Wide') }}</button>
        </div>
    </div>

    <div class="rd-set rd-i" style="--i:6"><button type="button" class="rd-reset" data-rd-reset>{{ __('Reset to default') }}</button></div>
</aside>
<script src="{{ asset('frontend/js/nahau-reader.js') . '?v=' . @filemtime(public_path('frontend/js/nahau-reader.js')) }}" defer></script>
</body>
</html>
