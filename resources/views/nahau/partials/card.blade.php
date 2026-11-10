@php use App\Nahau\Stories; @endphp
@php
    $sec = $s->section;
    $img = nimage($s);
    $label = strtoupper(nsection($sec,'name').(Stories::format($s) ? ' · '.Stories::format($s) : ''));
@endphp
<article class="nx-card nx-s-{{ $sec }}">
    @if($sec === 'fiction')
    @php $fav = in_array($s->id, nfav_ids(), true); @endphp
    <button type="button" class="nx-heart {{ $fav ? 'is-on' : '' }}" data-nx-fav="{{ $s->id }}" data-url="{{ route('nahau.favorite', $s->id) }}" aria-pressed="{{ $fav ? 'true' : 'false' }}" aria-label="{{ __('Save to favourites') }}" title="{{ __('Save to favourites') }}"><svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><path d="M12 21s-7.5-4.6-9.6-9.2C.9 8.4 2.7 4.5 6.4 4.5c2.1 0 3.7 1.1 5.6 3.2 1.9-2.1 3.5-3.2 5.6-3.2 3.7 0 5.5 3.9 4 7.3C19.5 16.4 12 21 12 21z"/></svg></button>
    @endif
    <div class="nx-media">
        @if($img)<img src="{{ $img }}" alt="{{ $s->image_alt ?: '' }}" loading="lazy" width="640" height="400">@else<span>{{ nsection($sec,'name') }}</span>@endif
    </div>
    <p class="nx-eyebrow">{{ $label }}</p>
    <h3><a class="nx-stretch" href="{{ Stories::url($s) }}" @if(($s->language ?? 'en') !== nlocale()) hreflang="{{ $s->language }}" @endif>{{ $s->title }}</a></h3>
    <p style="color:#4A4A4A;font-size:16px">{{ Stories::dek($s) }}</p>
    <p class="nx-meta">{{ __('By') }} {{ Stories::authorName($s) }} · {{ Stories::minutes($s) }} {{ __('min') }}@if(($s->language ?? 'en') !== nlocale()) <span class="nx-lang" lang="en">{{ $s->language === 'sw' ? 'Kiswahili' : 'English' }}</span>@endif</p>
</article>
