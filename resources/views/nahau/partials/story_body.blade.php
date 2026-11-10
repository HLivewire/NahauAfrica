@php
    use App\Nahau\Stories;
    $lead = nimage($story);
    $label = strtoupper(nsection($key,'name').($story->format ? ' · '.__($story->format) : '').' · '.Stories::minutes($story).' '.__('MIN READ'));
    $contentLabel = $story->label ?: nsection($key,'label');
    $isFiction = $contentLabel === 'Fiction';
    $url = Stories::url($story);
    $enc = rawurlencode($url);
    $titleEnc = rawurlencode($story->title);
@endphp
<article class="nx-s-{{ $key }}" data-nx-story data-section="{{ $key }}" data-lang="{{ $story->language }}">
<div class="nx-read" style="padding-top:44px">
    <nav class="nx-crumbs" aria-label="Breadcrumb"><a href="{{ nroute('home') }}">{{ __('Home') }}</a> / <a href="{{ nroute($key) }}">{{ nsection($key,'name') }}</a>@if($story->format) / {{ __($story->format) }}@endif</nav>
    <p class="nx-eyebrow">{{ $label }}</p>
    <p class="nx-meta" style="margin-top:6px"><strong style="color:var(--nx-ink)">{{ __($contentLabel) }}</strong></p>
    <h1 class="nx-title">{{ $story->title }}</h1>
    <p class="nx-dek">{{ $story->dek ?: ($story->summary ?: '') }}</p>
    <div class="nx-byline">
        <div>
            <div style="font-weight:600">{{ __('By') }} @if($author)<a href="{{ nroute('author',['slug'=>$author->slug]) }}" style="text-decoration:underline">{{ $author->name }}</a>@else{{ Stories::authorName($story) }}@endif</div>
            <div class="nx-meta">{{ __('Published') }} {{ ndate($story->date) }}@if($story->updated_at && \Illuminate\Support\Carbon::parse($story->updated_at)->gt(\Illuminate\Support\Carbon::parse($story->date)->addDay())) · {{ __('Updated') }} {{ ndate($story->updated_at) }}@endif · {{ $story->language === 'sw' ? 'Kiswahili' : 'English' }}</div>
        </div>
        <div style="display:flex;gap:12px;align-items:center;flex-wrap:wrap">
            @if($translation)
            <span class="nx-seg" aria-label="{{ __('Language') }}">
                <a class="{{ $story->language==='en'?'on':'' }}" lang="en" hreflang="en" data-nx-track="language_switch" href="{{ $story->language==='en' ? $url : Stories::url($translation,'en') }}">English</a>
                <a class="{{ $story->language==='sw'?'on':'' }}" lang="sw" hreflang="sw" data-nx-track="language_switch" href="{{ $story->language==='sw' ? $url : Stories::url($translation,'sw') }}">Kiswahili</a>
            </span>
            @endif
        </div>
    </div>
</div>

@if($lead)
<div class="nx-wrap" style="padding-top:34px"><figure style="margin:0"><div class="nx-media nx-leadmedia"><img src="{{ $lead }}" alt="{{ $story->image_alt }}" fetchpriority="high"></div>
    @if($story->image_caption || $story->image_credit)<figcaption class="nx-meta" style="margin-top:8px">{{ $story->image_caption }}@if($story->image_credit) · {{ $story->image_credit }}@endif</figcaption>@endif</figure></div>
@endif

<div class="nx-read" style="padding-top:34px">
    @if($story->sponsored_by)<div class="nx-box" role="note"><strong>{{ __('Sponsored by') }} {{ $story->sponsored_by }}.</strong> {{ __('Nahau Africa kept full editorial control.') }}</div>@endif
    @if(!empty($hero))
    <div class="nx-factbox"><dl>
        <dt>{{ __('Name') }}</dt><dd>{{ $hero->name }}</dd>
        <dt>{{ $hero->died ? __('Born / died') : __('Born') }}</dt><dd>{{ $hero->born }}{{ $hero->died ? ' – '.$hero->died : '' }}</dd>
        @if($hero->country)<dt>{{ __('Country') }}</dt><dd>{{ $hero->country }}</dd>@endif
        @if($hero->known_for)<dt>{{ __('Known for') }}</dt><dd>{{ $hero->known_for }}</dd>@endif
    </dl>
    @if($hero->portrait)<figure style="margin:16px 0 0"><img src="{{ media_url($hero->portrait) }}" alt="{{ __('Portrait of') }} {{ $hero->name }}" style="max-width:220px;border-radius:10px">@if($hero->portrait_credit)<figcaption class="nx-meta" style="margin-top:6px">{{ $hero->portrait_credit }}</figcaption>@endif</figure>@endif
    </div>
    @endif
    <div class="nx-body" data-nx-body>{!! nclean($story->description) !!}</div>
    @if(!empty($hero) && $hero->sources)
    <div class="nx-sources"><h2 style="font-family:'Jost',sans-serif;font-size:20px;margin-bottom:10px">{{ __('Sources') }}</h2><ul>
        @foreach(preg_split('/\R/', $hero->sources) as $line)@if(trim($line))@php [$st,$su] = array_pad(array_map('trim', explode('|', $line, 2)), 2, null); @endphp<li>@if($su)<a href="{{ $su }}" rel="noopener nofollow" target="_blank" style="text-decoration:underline">{{ $st }}</a>@else{{ $st }}@endif</li>@endif @endforeach
    </ul></div>
    @endif
    @if($isFiction)<p class="nx-box" style="margin-top:30px">{{ __('This is a work of fiction; any resemblance to real people is coincidental.') }}</p>@endif
    @yield('after_body')
    @if($corrections->isNotEmpty())
        <div class="nx-box" style="margin-top:20px"><strong>{{ __('Corrections') }}</strong><ul style="margin:6px 0 0 18px">@foreach($corrections as $c)<li>{{ ndate($c[0]) }}@if(isset($c[1])) — {{ $c[1] }}@endif</li>@endforeach</ul></div>
    @endif

    @if($nav)
    <nav class="nx-seriesnav" aria-label="{{ __('Series') }}">
        @if($nav['prev'])<a class="nx-link" href="{{ nroute('chapter',['slug'=>$nav['series']->slug,'n'=>$nav['prev']->chapter_no]) }}">← {{ __('Previous chapter') }}</a>@else<span></span>@endif
        <span><strong>{{ __('Chapter') }} {{ $story->chapter_no }} {{ __('of') }} {{ $nav['total'] }}</strong> · <a class="nx-link" href="{{ nroute('series',['slug'=>$nav['series']->slug]) }}">{{ $nav['series']->titleFor() }}</a></span>
        @if($nav['next'])<a class="nx-link" data-nx-track="series_chapter_next" href="{{ nroute('chapter',['slug'=>$nav['series']->slug,'n'=>$nav['next']->chapter_no]) }}">{{ __('Next chapter') }} →</a>@else<span></span>@endif
    </nav>
    @endif

    @include('nahau.partials.share')

    @if($author)
    <div class="nx-author">
        <div class="nx-avatar" style="width:60px;height:60px">@if($author->photo)<img src="{{ media_url($author->photo) }}" alt="">@else{{ mb_strtoupper(mb_substr($author->name,0,1)) }}@endif</div>
        <div><p class="nx-eyebrow" style="color:var(--nx-muted);font-size:12px;margin-bottom:6px">{{ __('About the author') }}</p>
            <div style="font-weight:600;font-size:20px;margin-bottom:6px">{{ $author->name }}</div>
            <p style="color:#4A4A4A;font-size:16px;margin-bottom:10px">{{ $author->bio }}</p>
            <a class="nx-link" href="{{ nroute('author',['slug'=>$author->slug]) }}">{{ __('See all stories by this author') }} →</a></div>
    </div>
    @endif
    <p class="nx-meta nx-center" style="margin-top:22px">{{ __('Spotted an error?') }} <a style="text-decoration:underline" href="{{ nroute('contact') }}?reason={{ urlencode('Correction request') }}&page_url={{ $enc }}">{{ __('Request a correction') }}</a> · {{ __('Read our') }} <a style="text-decoration:underline" href="{{ nroute('standards') }}">{{ __('editorial standards') }}</a>.</p>
</div>
</article>

@if($related->isNotEmpty())
<div class="nx-sec">
    <div class="nx-wrap">
        <h2 class="nx-h2">{{ $hero ?? false ? __('Related heroes') : __('Related stories') }}</h2>
        <div class="nx-grid nx-grid--3">@foreach($related as $s)@include('nahau.partials.card')@endforeach</div>
    </div>
</div>
@endif
