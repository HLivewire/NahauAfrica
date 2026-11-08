@php
    $heroStory = isset($latestnews) && $latestnews instanceof \Illuminate\Support\Collection ? $latestnews->first() : null;
    $heroCat = collect(newscategories())->where('menu_publish', 1)->first();
    $heroExplore = $heroCat ? route($heroCat->slug, strtolower($heroCat->name)) : route('home');
    $heroUrl = null;
    if ($heroStory && !empty($heroStory->news_categoryslug)) {
        try { $heroUrl = route(strtolower($heroStory->news_categoryslug).'.details', ['id' => $heroStory->id, 'slug' => \Illuminate\Support\Str::slug($heroStory->title)]); } catch (\Throwable $e) { $heroUrl = null; }
    }
@endphp
<section class="nahau-hero">
    <div class="container">
        <p class="nahau-eyebrow">{{ __('Our stories. Our voices.') }}</p>
        <h1>{{ __('African stories. Told in our voices.') }}</h1>
        <p class="nahau-hero-sub">{{ __('Discover fiction, lived experiences, relationship stories, working lives, and remarkable people from across Africa.') }}</p>
        <div class="nahau-hero-actions">
            <a class="nahau-btn nahau-btn--primary" href="{{ $heroExplore }}">{{ __('Explore Stories') }}</a>
            <a class="nahau-btn nahau-btn--ghost" href="{{ route('contactus') }}">{{ __('Write for Us') }}</a>
        </div>
        <hr class="nahau-hero-rule">
        <div class="nahau-featured">
            <div class="nahau-featured-media">
                @if ($heroStory && $heroStory->image)
                    <img src="{{ media_url($heroStory->image) }}" alt="{{ $heroStory->title }}" loading="lazy" onerror="this.remove()">
                @endif
                <span>{{ __('Featured story') }}</span>
            </div>
            <div class="nahau-featured-body">
                <p class="nahau-eyebrow">{{ __('Featured story') }}</p>
                @if ($heroStory)
                    <h2>@if($heroUrl)<a href="{{ $heroUrl }}">{{ $heroStory->title }}</a>@else{{ $heroStory->title }}@endif</h2>
                    <p class="nahau-featured-meta">{{ __('By') }} {{ trim($heroStory->reporter_name ?? '') ?: 'Nahau Africa' }} &middot; {{ $heroStory->news_category ?? '' }} &middot; {{ \Carbon\Carbon::parse($heroStory->date)->format('d M Y') }}</p>
                @else
                    <h2>{{ __('The Last Bus to Morogoro') }}</h2>
                    <p>{{ __('A bus conductor, a stranger with no ticket, and one night on the road that changes what both of them believe about home.') }}</p>
                    <p class="nahau-featured-meta">{{ __('Fiction · 12 min read · English and Kiswahili') }}</p>
                @endif
            </div>
        </div>
    </div>
</section>
