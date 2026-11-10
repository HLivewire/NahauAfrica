@php use App\Nahau\Stories; @endphp
@php
    $sec = $s->section;
    $img = nimage($s);
    $label = strtoupper(nsection($sec,'name').(Stories::format($s) ? ' · '.Stories::format($s) : ''));
@endphp
<article class="nx-card nx-s-{{ $sec }}">
    <div class="nx-media">
        @if($img)<img src="{{ $img }}" alt="{{ $s->image_alt ?: '' }}" loading="lazy" width="640" height="400">@else<span>{{ nsection($sec,'name') }}</span>@endif
    </div>
    <p class="nx-eyebrow">{{ $label }}</p>
    <h3><a class="nx-stretch" href="{{ Stories::url($s) }}" @if(($s->language ?? 'en') !== nlocale()) hreflang="{{ $s->language }}" @endif>{{ $s->title }}</a></h3>
    <p style="color:#4A4A4A;font-size:16px">{{ Stories::dek($s) }}</p>
    <p class="nx-meta">{{ __('By') }} {{ Stories::authorName($s) }} · {{ Stories::minutes($s) }} {{ __('min') }}@if(($s->language ?? 'en') !== nlocale()) <span class="nx-lang" lang="en">{{ $s->language === 'sw' ? 'Kiswahili' : 'English' }}</span>@endif</p>
</article>
