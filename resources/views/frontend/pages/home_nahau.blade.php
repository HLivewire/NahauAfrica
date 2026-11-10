@extends('frontend.master')
@section('meta_content')
    @include('frontend.pages.meta')
@endsection
@section('main_content')
@php
    $hero = $nahau['hero'] ?? null;
    $latest = $nahau['latest'] ?? collect();
    $most = $nahau['most'] ?? collect();
    $doors = $nahau['doors'] ?? collect();
    $heroes = $nahau['heroes'] ?? collect();
    $storyUrl = function ($n) {
        try {
            return route(strtolower($n->news_categoryslug).'.details', ['id' => $n->id, 'slug' => \Illuminate\Support\Str::slug($n->title)]);
        } catch (\Throwable $e) {
            return route('home');
        }
    };
    $door = [
        'fiction' => 'Short stories, serialised novels and flash fiction.',
        'relationships' => 'Love, family, friendship and the ties that hold communities together.',
        'jobs-careers' => 'First jobs, trades, businesses, setbacks and fresh starts.',
        'african-heroes' => 'Researched profiles of people whose lives are worth remembering.',
    ];
    $tone = ['', 'g', 'd'];
    $mins = fn ($n) => max(1, (int) ceil(str_word_count(strip_tags((string) ($n->summary ?? ''))) / 40) + 3);
@endphp

{{-- HERO --}}
<section class="nh-hero">
    <div class="container nh-hero-grid">
        <div>
            <p class="nh-kicker">{{ __('Our stories. Our voices.') }}</p>
            <h1>{{ __('African stories. Told in our') }} <em>{{ __('voices.') }}</em></h1>
            <p class="nh-hero-sub">{{ __('Fiction, lived experiences, relationship stories, working lives and remarkable people from across Africa, in English and Kiswahili.') }}</p>
            <div class="nh-actions">
                <a class="nh-btn nh-btn--light" href="{{ $doors->first() ? route($doors->first()->slug, strtolower($doors->first()->name)) : route('home') }}">{{ __('Explore stories') }}</a>
                <a class="nh-btn nh-btn--line" href="{{ route('contactus') }}">{{ __('Write for Us') }}</a>
            </div>
            <div class="nh-pills">
                @foreach ($doors as $d)
                    <a href="{{ route($d->slug, strtolower($d->name)) }}">{{ $d->name }}@if ($d->published_count)<b>{{ $d->published_count }}</b>@endif</a>
                @endforeach
            </div>
        </div>
        @if ($hero)
        <a class="nh-feat" href="{{ $storyUrl($hero) }}">
            <div class="nh-ph">
                @if ($hero->image)<img src="{{ media_url($hero->image) }}" alt="{{ $hero->title }}" loading="eager" onerror="this.remove()">@endif
            </div>
            <div class="nh-feat-body">
                <p class="nh-tag">{{ __('Featured') }} · {{ $hero->news_category }} · {{ $mins($hero) }} {{ __('min') }}</p>
                <h2>{{ $hero->title }}</h2>
                <p>{{ \Illuminate\Support\Str::limit(strip_tags((string) $hero->summary), 150) }}</p>
            </div>
        </a>
        @endif
    </div>
</section>

{{-- DOORS --}}
@if ($doors->count())
<section class="nh-sec">
    <div class="container">
        <div class="nh-sec-h"><h2>{{ __('Choose your door') }}</h2></div>
        <div class="nh-doors">
            @foreach ($doors as $d)
            <a class="nh-door nh-d{{ ($loop->index % 4) + 1 }}" href="{{ route($d->slug, strtolower($d->name)) }}">
                <span class="nh-num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                <div>
                    <h3>{{ $d->name }}</h3>
                    <p>{{ $door[$d->slug] ?? '' }}</p>
                    <span class="nh-arrow" aria-hidden="true">&rarr;</span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- LATEST --}}
@if ($latest->count())
<section class="nh-sec nh-sec--tight">
    <div class="container">
        <div class="nh-sec-h"><h2>{{ __('Latest stories') }}</h2></div>
        <div class="nh-bento">
            @php $lead = $latest->first(); @endphp
            <article class="nh-lead">
                <div class="nh-ph">@if ($lead->image)<img src="{{ media_url($lead->image) }}" alt="{{ $lead->title }}" loading="lazy" onerror="this.remove()">@endif</div>
                <p class="nh-tag">{{ $lead->news_category }}</p>
                <h3><a href="{{ $storyUrl($lead) }}">{{ $lead->title }}</a></h3>
                <p class="nh-txt">{{ \Illuminate\Support\Str::limit(strip_tags((string) $lead->summary), 140) }}</p>
                <p class="nh-meta">{{ __('By') }} {{ trim($lead->reporter_name) ?: 'Nahau Africa' }} · {{ \Carbon\Carbon::parse($lead->date)->format('d M Y') }}</p>
            </article>
            @foreach ($latest->slice(1) as $n)
            <article class="nh-sm">
                <div class="nh-ph {{ $tone[$loop->index % 3] }}">@if ($n->image)<img src="{{ media_url($n->image) }}" alt="{{ $n->title }}" loading="lazy" onerror="this.remove()">@endif</div>
                <p class="nh-tag">{{ $n->news_category }}</p>
                <h3><a href="{{ $storyUrl($n) }}">{{ $n->title }}</a></h3>
                <p class="nh-meta">{{ __('By') }} {{ trim($n->reporter_name) ?: 'Nahau Africa' }} · {{ \Carbon\Carbon::parse($n->date)->format('d M Y') }}</p>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- HEROES + MOST READ --}}
<section class="nh-sec">
    <div class="container nh-two">
        <div>
            <div class="nh-sec-h"><h2>{{ __('Heroes in focus') }}</h2>
                @php $hc = $doors->firstWhere('slug','african-heroes'); @endphp
                @if ($hc)<a class="nh-link" href="{{ route($hc->slug, strtolower($hc->name)) }}">{{ __('See all African Heroes') }} &rarr;</a>@endif
            </div>
            <div class="nh-heroes">
                @forelse ($heroes as $h)
                <a class="nh-hcard" href="{{ $storyUrl($h) }}">
                    <div class="nh-ph {{ $tone[$loop->index % 3] }}">@if ($h->image)<img src="{{ media_url($h->image) }}" alt="{{ $h->title }}" loading="lazy" onerror="this.remove()">@endif</div>
                    <div class="nh-hin"><span class="nh-yr">{{ \Carbon\Carbon::parse($h->date)->format('Y') }}</span><h3>{{ $h->title }}</h3></div>
                </a>
                @empty
                <div class="nh-hempty">
                    <h3>{{ __('Know someone whose life deserves to be remembered?') }}</h3>
                    <p>{{ __('Nominate a community hero and our editors will research and tell their story.') }}</p>
                    <a class="nh-btn nh-btn--red" href="{{ route('contactus') }}">{{ __('Nominate a hero') }}</a>
                </div>
                @endforelse
            </div>
        </div>
        <aside>
            <div class="nh-sec-h"><h2 style="font-size:32px">{{ __('Most read') }}</h2></div>
            <div class="nh-most">
                @foreach ($most as $m)
                <a href="{{ $storyUrl($m) }}"><span class="nh-n">{{ $loop->iteration }}</span><b>{{ $m->title }}</b></a>
                @endforeach
            </div>
        </aside>
    </div>
</section>

{{-- NEWSLETTER --}}
<section class="nh-sec nh-sec--tight" style="padding-bottom:0">
    <div class="container">
        <div class="nh-news">
            <div>
                <h2>{{ __('A good story is worth making time for.') }}</h2>
                <p>{{ __('Selected stories, new chapters and fresh voices from Nahau Africa, in your inbox.') }}</p>
            </div>
            <form class="nh-news-form" id="nhNews" novalidate>
                <input type="email" name="email" aria-label="{{ __('Email address') }}" placeholder="you@example.com" required>
                <button class="nh-btn nh-btn--red" type="submit">{{ __('Subscribe') }}</button>
                <p class="nh-news-msg" id="nhNewsMsg" role="status"></p>
            </form>
        </div>
    </div>
</section>
<div style="height:84px"></div>

<script>
(function () {
  var f = document.getElementById('nhNews'); if (!f) return;
  var msg = document.getElementById('nhNewsMsg');
  f.addEventListener('submit', function (e) {
    e.preventDefault();
    var email = f.email.value.trim();
    if (!/^\S+@\S+\.\S+$/.test(email)) { msg.textContent = @json(__('Please enter a valid email address.')); return; }
    fetch(@json(route('subscribe')) + '?email=' + encodeURIComponent(email), { headers: { 'Accept': 'application/json' } })
      .then(function (r) { msg.textContent = r.ok ? @json(__('Thank you. You are subscribed.')) : @json(__('Please enter a valid email address.')); if (r.ok) f.reset(); })
      .catch(function () { msg.textContent = @json(__('Something went wrong. Please try again.')); });
  });
})();
</script>
@endsection
