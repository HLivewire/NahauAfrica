@php
    use App\Nahau\Stories;
    $lead = nimage($story);
    $url = Stories::url($story);
    $enc = rawurlencode($url);
    $titleEnc = rawurlencode($story->title);
    $pages = npages($story->description);
    $previewN = (int) config('nahau.preview_pages', 3);
    $preview = array_slice($pages, 0, $previewN);
    $label = strtoupper(nsection($key,'name').($story->format ? ' · '.__($story->format) : '').' · '.Stories::minutes($story).' '.__('MIN READ'));
    $price = (int) ($story->price ?? 0);
    $inCart = in_array($story->id, array_map('intval', (array) session('nahau_cart', [])), true);
@endphp
<article class="nx-s-{{ $key }} nx-book" data-nx-story data-section="{{ $key }}" data-lang="{{ $story->language }}">
<div class="nx-wrap nx-book-head">
    <nav class="nx-crumbs" aria-label="Breadcrumb"><a href="{{ nroute('home') }}">{{ __('Home') }}</a> / <a href="{{ nroute($key) }}">{{ nsection($key,'name') }}</a>@if($story->format) / {{ __($story->format) }}@endif</nav>
    <p class="nx-eyebrow">{{ $label }}</p>
    <h1 class="nx-title">{{ $story->title }}</h1>
    <p class="nx-dek">{{ $story->dek ?: ($story->summary ?: '') }}</p>
    <div class="nx-byline">
        <div>
            <div style="font-weight:600">{{ __('By') }} @if($author)<a href="{{ nroute('author',['slug'=>$author->slug]) }}" style="text-decoration:underline">{{ $author->name }}</a>@else{{ Stories::authorName($story) }}@endif</div>
            <div class="nx-meta">{{ __('Published') }} {{ ndate($story->date) }} · {{ $story->language === 'sw' ? 'Kiswahili' : 'English' }}</div>
        </div>
        @if($translation)
        <span class="nx-seg" aria-label="{{ __('Language') }}">
            <a class="{{ $story->language==='en'?'on':'' }}" lang="en" hreflang="en" data-nx-track="language_switch" href="{{ $story->language==='en' ? $url : Stories::url($translation,'en') }}">English</a>
            <a class="{{ $story->language==='sw'?'on':'' }}" lang="sw" hreflang="sw" data-nx-track="language_switch" href="{{ $story->language==='sw' ? $url : Stories::url($translation,'sw') }}">Kiswahili</a>
        </span>
        @endif
    </div>
</div>

<div class="nx-wrap nx-book-grid">
    <div class="nx-book-left">
        <figure class="nx-book-cover">
            @if($lead)<img src="{{ $lead }}" alt="{{ $story->image_alt ?: __('Cover of').' '.$story->title }}" fetchpriority="high">@else<span>{{ $story->title }}</span>@endif
        </figure>
        @if($story->image_caption || $story->image_credit)<p class="nx-meta" style="margin:-6px 0 18px">{{ $story->image_caption }}@if($story->image_credit) · {{ $story->image_credit }}@endif</p>@endif

    </div>

    <div class="nx-book-right">
        @if($story->sponsored_by)<div class="nx-box" role="note"><strong>{{ __('Sponsored by') }} {{ $story->sponsored_by }}.</strong> {{ __('Nahau Africa kept full editorial control.') }}</div>@endif
        <h2 class="nx-h2" style="font-size:26px;margin-bottom:12px">{{ __('About this book') }}</h2>
        <p class="nx-book-about">{{ $story->summary ?: $story->dek }}</p>
        <p class="nx-box" style="margin-top:22px">{{ __('This is a work of fiction; any resemblance to real people is coincidental.') }}</p>

        @if($nav)
        <nav class="nx-seriesnav" aria-label="{{ __('Series') }}">
            @if($nav['prev'])<a class="nx-link" href="{{ nroute('chapter',['slug'=>$nav['series']->slug,'n'=>$nav['prev']->chapter_no]) }}">← {{ __('Previous chapter') }}</a>@else<span></span>@endif
            <span><strong>{{ __('Chapter') }} {{ $story->chapter_no }} {{ __('of') }} {{ $nav['total'] }}</strong> · <a class="nx-link" href="{{ nroute('series',['slug'=>$nav['series']->slug]) }}">{{ $nav['series']->titleFor() }}</a></span>
            @if($nav['next'])<a class="nx-link" data-nx-track="series_chapter_next" href="{{ nroute('chapter',['slug'=>$nav['series']->slug,'n'=>$nav['next']->chapter_no]) }}">{{ __('Next chapter') }} →</a>@else<span></span>@endif
        </nav>
        @endif

        @if($corrections->isNotEmpty())
        <div class="nx-box" style="margin-top:20px"><strong>{{ __('Corrections') }}</strong><ul style="margin:6px 0 0 18px">@foreach($corrections as $c)<li>{{ ndate($c[0]) }}@if(isset($c[1])) — {{ $c[1] }}@endif</li>@endforeach</ul></div>
        @endif

        <div class="nx-share" data-nx-share data-url="{{ $url }}"><span style="font-weight:600;margin-right:6px">{{ __('Share') }}</span>
            <a data-nx-track="share_click" data-channel="whatsapp" target="_blank" rel="noopener" href="https://wa.me/?text={{ $titleEnc }}%20{{ $enc }}">WhatsApp</a>
            <a data-nx-track="share_click" data-channel="facebook" target="_blank" rel="noopener" href="https://www.facebook.com/sharer/sharer.php?u={{ $enc }}">Facebook</a>
            <a data-nx-track="share_click" data-channel="x" target="_blank" rel="noopener" href="https://twitter.com/intent/tweet?text={{ $titleEnc }}&url={{ $enc }}">X</a>
            <a data-nx-track="share_click" data-channel="linkedin" target="_blank" rel="noopener" href="https://www.linkedin.com/sharing/share-offsite/?url={{ $enc }}">LinkedIn</a>
            <button type="button" data-nx-copy data-copied="{{ __('Link copied') }}">{{ __('Copy link') }}</button>
        </div>

        @if($author)
        <div class="nx-author">
            <div class="nx-avatar" style="width:60px;height:60px">@if($author->photo && ($av = nimage($author->photo)))<img src="{{ $av }}" alt="{{ $author->name }}">@else<svg viewBox="0 0 24 24" width="30" height="30" aria-hidden="true" fill="currentColor"><path d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10zm0 2c-4.4 0-8 2.2-8 5v2h16v-2c0-2.8-3.6-5-8-5z"/></svg>@endif</div>
            <div><p class="nx-eyebrow" style="color:var(--nx-muted);font-size:12px;margin-bottom:6px">{{ __('About the author') }}</p>
                <div style="font-weight:600;font-size:20px;margin-bottom:6px">{{ $author->name }}</div>
                <p style="color:#4A4A4A;font-size:16px;margin-bottom:10px">{{ $author->bio }}</p>
                <a class="nx-link" href="{{ nroute('author',['slug'=>$author->slug]) }}">{{ __('See all stories by this author') }} →</a></div>
        </div>
        @endif
        <p class="nx-meta" style="margin-top:22px">{{ __('Spotted an error?') }} <a style="text-decoration:underline" href="{{ nroute('contact') }}?reason={{ urlencode('Correction request') }}&page_url={{ $enc }}">{{ __('Request a correction') }}</a></p>
    </div>
</div>

<div class="nx-wrap nx-lookinside">
        <section class="nx-preview" aria-labelledby="pv-h">
            <div class="nx-preview-head"><h2 id="pv-h">{{ __('Look inside') }}</h2><span>{{ count($preview) }} {{ trans_choice('{1} page|[0,*] pages', count($preview)) }} · {{ __('scroll to read') }}</span></div>
            <div class="nx-pages" tabindex="0" role="region" aria-label="{{ __('Book preview pages') }}">
                @forelse($preview as $i => $pg)
                <div class="nx-page"><div class="nx-page-text">{!! $pg !!}</div><div class="nx-page-no">{{ __('Page') }} {{ $i + 1 }}</div></div>
                @empty
                <p class="nx-empty" style="padding:20px">{{ __('The preview is not available yet.') }}</p>
                @endforelse
                @if(count($pages) > $previewN)<div class="nx-page nx-page--more"><p>{{ __('Keep reading to find out what happens next.') }}</p></div>@endif
            </div>
        </section>

        <div class="nx-book-actions">
            <a class="nx-btn" data-nx-track="read_book_click" href="{{ nroute('read', ['slug' => $story->slug]) }}">{{ __('Read this book') }}</a>
            @if($price > 0)
            <button type="button" class="nx-btn nx-btn--dark" data-nx-cart data-url="{{ route('nahau.cart.add', $story->id) }}" data-cart="{{ route('nahau.cart') }}" data-added="{{ __('Added to cart') }}" data-view="{{ __('View cart') }}">{{ $inCart ? __('In your cart') : __('Add to cart') }} · {{ nmoney($price) }}</button>
            @endif
        </div>
</div>
</article>

@if($related->isNotEmpty())
<div class="nx-sec">
    <div class="nx-wrap">
        <h2 class="nx-h2">{{ __('Related stories') }}</h2>
        <div class="nx-grid nx-grid--3">@foreach($related as $s)@include('nahau.partials.card')@endforeach</div>
    </div>
</div>
@endif
