@extends('admin.master')

@section('main_content')
@php
    use App\Nahau\Charts;
    $fmt = fn ($n) => number_format((int) $n);
    $initials = function ($name) { $p = preg_split('/\s+/', trim((string) $name)); return strtoupper(mb_substr($p[0] ?? '', 0, 1).mb_substr($p[1] ?? '', 0, 1)); };

    // area chart: stories per month
    $W = 800; $H = 260;
    $vals = array_column($series, 'count');
    $max = Charts::niceMax(max($vals ?: [0]));
    $pts = Charts::points($vals, $max, $W, $H);
    $line = Charts::line($pts); $area = Charts::area($pts, $W, $H);
    $monthTotal = array_sum($vals);

    // bar chart: stories per category
    $catMax = Charts::niceMax((float) ($byCategory->max('total') ?: 0));

    // line chart: weekly stories vs subscribers
    $wMax = Charts::niceMax((float) max(array_merge(array_column($weekly, 'stories'), array_column($weekly, 'subs'), [0])));
    $pS = Charts::points(array_column($weekly, 'stories'), $wMax, $W, 220);
    $pU = Charts::points(array_column($weekly, 'subs'), $wMax, $W, 220);

    // most-read horizontal bars
    $readMax = max(1, (int) ($topRead->max('viewers') ?: 1));
    $feedIcon = ['story' => ['fa-newspaper', 'primary'], 'user' => ['fa-user-plus', 'success'], 'mail' => ['fa-envelope', 'warning']];
    $dash = [
        [__('Stories'), __('Write & publish'), 'fa-newspaper', 'c-indigo', route('admin.news')],
        [__('Categories'), __('Sections'), 'fa-layer-group', 'c-emerald', route('admin.news.category')],
        [__('Subscribers'), __('Readers'), 'fa-user-check', 'c-orange', route('admin.subscriber')],
        [__('Messages'), __('Contact inbox'), 'fa-envelope-open-text', 'c-purple', route('admin.contact')],
        [__('Reporters'), __('Writers'), 'fa-pen-nib', 'c-cyan', route('admin.reporter')],
        [__('Settings'), __('Site setup'), 'fa-cog', 'c-pink', route('admin.settings.index')],
    ];
@endphp
<div class="content-wrapper dx">
    <section class="content">
        <div class="container-fluid dx-wrap">

            <div class="dx-pagehead">
                <nav class="dx-crumb" aria-label="Breadcrumb"><a href="{{ URL('/admin') }}"><i class="fas fa-home"></i></a><span>/</span><b>{{ __('Dashboard') }}</b></nav>
                <div class="dx-pagehead-row">
                    <div>
                        <h1>{{ __('Dashboard') }}</h1>
                        <p>{{ __('Welcome back! Here is your complete newsroom overview.') }}</p>
                    </div>
                    <div class="dx-actions">
                        <a class="dx-btn dx-btn--ghost" href="{{ URL('/') }}" target="_blank" rel="noopener"><i class="fas fa-external-link-alt"></i> {{ __('View site') }}</a>
                        <a class="dx-btn" href="{{ route('admin.news') }}"><i class="fas fa-plus"></i> {{ __('Manage stories') }}</a>
                    </div>
                </div>
            </div>

            {{-- Overview stats --}}
            <div class="dx-stats dx-stagger">
                @foreach([
                    [__('Published stories'), $fmt($publish_news), $storyGrowth, 'primary', 'fa-newspaper'],
                    [__('Total reads'), $fmt($totalReads), null, 'success', 'fa-eye'],
                    [__('Subscribers'), $fmt($subscribe), $subGrowth, 'ocean', 'fa-users'],
                    [__('Drafts waiting'), $fmt($unpublish_news), null, 'sunset', 'fa-pen-square'],
                ] as [$t, $v, $ch, $variant, $ic])
                <div class="dx-gcard gradient-{{ $variant }}">
                    <i class="dx-bubble b1"></i><i class="dx-bubble b2"></i>
                    <div class="dx-gcard-top"><span>{{ $t }}</span><i class="fas {{ $ic }}"></i></div>
                    <p class="dx-gcard-val">{{ $v }}</p>
                    @if($ch !== null)<p class="dx-gcard-ch"><b>{{ $ch >= 0 ? '↑' : '↓' }} {{ abs($ch) }}%</b> {{ __('vs last month') }}</p>@else<p class="dx-gcard-ch">{{ $variant === 'success' ? __('across all stories') : __('not yet published') }}</p>@endif
                </div>
                @endforeach
            </div>

            {{-- Quick navigation --}}
            <div class="dx-quick">
                @foreach($dash as [$t, $d, $ic, $c, $href])
                <a class="dx-card dx-qcard" href="{{ $href }}"><i class="fas {{ $ic }} {{ $c }}"></i><b>{{ $t }}</b><small>{{ $d }}</small></a>
                @endforeach
            </div>

            {{-- Charts --}}
            <div class="dx-grid dx-grid-7">
                <section class="dx-card dx-span-4">
                    <div class="dx-card-h"><h2><i class="fas fa-chart-area c-indigo"></i> {{ __('Stories created') }}</h2><span class="dx-link">{{ __('Last 12 months') }} · {{ $monthTotal }}</span></div>
                    <div class="dx-card-b">
                        <div class="dx-chart">
                            <div class="dx-y">@foreach([1, .75, .5, .25, 0] as $g)<span>{{ (int) round($max * $g) }}</span>@endforeach</div>
                            <div class="dx-plot">
                                <svg viewBox="0 0 {{ $W }} {{ $H }}" preserveAspectRatio="none" role="img" aria-label="{{ __('Stories created per month') }}">
                                    <defs><linearGradient id="dxg1" x1="0" y1="0" x2="0" y2="1"><stop offset="5%" stop-color="var(--chart-1)" stop-opacity=".25"/><stop offset="95%" stop-color="var(--chart-1)" stop-opacity="0"/></linearGradient></defs>
                                    @foreach([0, .25, .5, .75, 1] as $g)@php($gy = round($H - 2 - $g * ($H - 10), 1))<line x1="0" x2="{{ $W }}" y1="{{ $gy }}" y2="{{ $gy }}" class="dx-grid-line"/>@endforeach
                                    <path d="{{ $area }}" fill="url(#dxg1)"/>
                                    <path d="{{ $line }}" fill="none" stroke="var(--chart-1)" stroke-width="2.2" stroke-linecap="round" vector-effect="non-scaling-stroke"/>
                                    @foreach($series as $i => $m)<rect class="dx-hit" x="{{ round($i * $W / count($series), 1) }}" y="0" width="{{ round($W / count($series), 1) }}" height="{{ $H }}" data-tip="{{ $m['label'] }} · {{ $m['count'] }} {{ __('stories') }}"/>@endforeach
                                </svg>
                                <div class="dx-x">@foreach($series as $m)<span>{{ $m['label'] }}</span>@endforeach</div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="dx-card dx-span-3">
                    <div class="dx-card-h"><h2><i class="fas fa-layer-group c-purple"></i> {{ __('Stories by category') }}</h2><a class="dx-link" href="{{ route('admin.news.category') }}">{{ __('Details') }} <i class="fas fa-arrow-up-right-from-square"></i></a></div>
                    <div class="dx-card-b">
                        <div class="dx-bars">
                            @forelse($byCategory as $c)
                            <div class="dx-bar-col" data-tip="{{ $c->name }} · {{ $c->total }} {{ __('stories') }}">
                                <div class="dx-bar-track"><i style="height:{{ max(3, round($c->total / $catMax * 100)) }}%"></i></div>
                                <span title="{{ $c->name }}">{{ \Illuminate\Support\Str::limit($c->name, 9, '…') }}</span>
                            </div>
                            @empty
                            <p class="dx-empty">{{ __('No categorised stories yet.') }}</p>
                            @endforelse
                        </div>
                    </div>
                </section>
            </div>

            <div class="dx-grid dx-grid-2">
                <section class="dx-card">
                    <div class="dx-card-h"><h2><i class="fas fa-fire c-emerald"></i> {{ __('Most read stories') }}</h2><a class="dx-link" href="{{ route('admin.news') }}">{{ __('View all') }} <i class="fas fa-arrow-up-right-from-square"></i></a></div>
                    <div class="dx-card-b">
                        @forelse($topRead as $t)
                        <div class="dx-hbar" data-tip="{{ $t->title }} · {{ $fmt($t->viewers) }} {{ __('reads') }}">
                            <div class="dx-hbar-top"><span>{{ \Illuminate\Support\Str::limit($t->title, 48) }}</span><b>{{ $fmt($t->viewers) }}</b></div>
                            <div class="dx-track"><i class="bg-success" style="width:{{ round(($t->viewers / $readMax) * 100) }}%"></i></div>
                        </div>
                        @empty<p class="dx-empty">{{ __('No stories yet.') }}</p>@endforelse
                    </div>
                </section>

                <section class="dx-card">
                    <div class="dx-card-h"><h2><i class="fas fa-chart-line c-pink"></i> {{ __('Weekly activity') }}</h2><span class="dx-legend"><i style="background:var(--chart-1)"></i>{{ __('Stories') }}<i style="background:var(--chart-3)"></i>{{ __('Subscribers') }}</span></div>
                    <div class="dx-card-b">
                        <div class="dx-chart dx-chart--sm">
                            <div class="dx-y">@foreach([1, .5, 0] as $g)<span>{{ (int) round($wMax * $g) }}</span>@endforeach</div>
                            <div class="dx-plot">
                                <svg viewBox="0 0 {{ $W }} 220" preserveAspectRatio="none" role="img" aria-label="{{ __('Weekly stories and subscribers') }}">
                                    @foreach([0, .5, 1] as $g)@php($gy = round(220 - 2 - $g * 210, 1))<line x1="0" x2="{{ $W }}" y1="{{ $gy }}" y2="{{ $gy }}" class="dx-grid-line"/>@endforeach
                                    <path d="{{ Charts::line($pS) }}" fill="none" stroke="var(--chart-1)" stroke-width="2.2" stroke-linecap="round" vector-effect="non-scaling-stroke"/>
                                    <path d="{{ Charts::line($pU) }}" fill="none" stroke="var(--chart-3)" stroke-width="2.2" stroke-linecap="round" vector-effect="non-scaling-stroke"/>
                                    @foreach($weekly as $i => $w)<rect class="dx-hit" x="{{ round($i * $W / count($weekly), 1) }}" y="0" width="{{ round($W / count($weekly), 1) }}" height="220" data-tip="{{ $w['label'] }} · {{ $w['stories'] }} {{ __('stories') }}, {{ $w['subs'] }} {{ __('subscribers') }}"/>@endforeach
                                </svg>
                                <div class="dx-x">@foreach($weekly as $w)<span>{{ $w['label'] }}</span>@endforeach</div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <div class="dx-grid dx-grid-2">
                <section class="dx-card">
                    <div class="dx-card-h"><h2><i class="fas fa-trophy c-purple"></i> {{ __('Top stories') }}</h2><a class="dx-link" href="{{ route('admin.news') }}">{{ __('Manage') }} <i class="fas fa-arrow-up-right-from-square"></i></a></div>
                    <div class="dx-card-b">
                        <div class="dx-table">
                            <div class="dx-tr dx-th"><span class="c2">{{ __('Story') }}</span><span class="ctr">{{ __('Reads') }}</span><span class="r">{{ __('Share') }}</span></div>
                            @forelse($topRead as $t)
                            <div class="dx-tr"><span class="c2 strong" title="{{ $t->title }}">{{ \Illuminate\Support\Str::limit($t->title, 44) }}</span><span class="ctr muted">{{ $fmt($t->viewers) }}</span><span class="r strong">{{ $totalReads ? round($t->viewers / $totalReads * 100, 1) : 0 }}%</span></div>
                            @empty<p class="dx-empty">{{ __('No stories yet.') }}</p>@endforelse
                        </div>
                    </div>
                </section>

                <section class="dx-card">
                    <div class="dx-card-h"><h2><i class="fas fa-tasks c-cyan"></i> {{ __('Content health') }}</h2><a class="dx-link" href="{{ route('admin.news') }}">{{ __('View all') }} <i class="fas fa-arrow-up-right-from-square"></i></a></div>
                    <div class="dx-card-b dx-prog-list">
                        @foreach($quality as $q)
                        <div class="dx-prog"><div class="dx-prog-top"><span>{{ $q['label'] }}</span><b>{{ $q['value'] }}%</b></div><div class="dx-track dx-track--md"><i class="bg-{{ $q['variant'] }}" style="--w:{{ $q['value'] }}%"></i></div></div>
                        @endforeach
                        @if($noCover)<p class="dx-note"><i class="fas fa-exclamation-triangle"></i> {{ $noCover }} {{ __('stories have no cover image yet.') }}</p>@endif
                    </div>
                </section>
            </div>

            <div class="dx-grid dx-grid-2">
                <section class="dx-card">
                    <div class="dx-card-h"><h2>{{ __('Recent stories') }}</h2><a class="dx-link" href="{{ route('admin.news') }}">{{ __('View all') }} <i class="fas fa-arrow-up-right-from-square"></i></a></div>
                    <div class="dx-card-b">
                        @forelse($recent as $r)
                        <div class="dx-person">
                            <span class="dx-avatar">{{ $initials($r->title) }}</span>
                            <div class="dx-person-m"><p>{{ \Illuminate\Support\Str::limit($r->title, 52) }}</p><small>#{{ $r->id }} · {{ $r->created_at?->diffForHumans() }}</small></div>
                            <span class="dx-badge {{ $r->status ? 'success' : 'warning' }}">{{ $r->status ? __('published') : __('draft') }}</span>
                        </div>
                        @empty<p class="dx-empty">{{ __('No stories yet.') }}</p>@endforelse
                    </div>
                </section>

                <section class="dx-card">
                    <div class="dx-card-h"><h2>{{ __('Live activity') }}</h2><span class="dx-live"><i></i> {{ __('Live') }}</span></div>
                    <div class="dx-card-b">
                        <div class="dx-feed">
                            @forelse($feed as $f)
                            @php([$fi, $fc] = $feedIcon[$f['type']])
                            <div class="dx-feed-i"><span class="dx-feed-ico {{ $fc }}"><i class="fas {{ $fi }}"></i></span><div><p>{{ $f['text'] }}</p><small>{{ $f['at']->diffForHumans() }}</small></div></div>
                            @empty<p class="dx-empty">{{ __('Nothing yet.') }}</p>@endforelse
                        </div>
                    </div>
                </section>
            </div>

            <div class="dx-metrics">
                @foreach([
                    [__('Avg reads per story'), $fmt($metrics['avgReads']), 'fa-eye', 'primary'],
                    [__('Staff accounts'), $fmt($admin), 'fa-user-shield', 'success'],
                    [__('Messages received'), $fmt($metrics['messages']), 'fa-envelope', 'warning'],
                    [__('Authors'), $fmt($metrics['authors']), 'fa-feather-alt', 'info'],
                ] as [$t, $v, $ic, $c])
                <div class="dx-card dx-metric"><span class="dx-mico {{ $c }}"><i class="fas {{ $ic }}"></i></span><div><small>{{ $t }}</small><b>{{ $v }}</b></div></div>
                @endforeach
            </div>
        </div>
    </section>
</div>
<div class="dx-tip" id="dxTip" role="tooltip" hidden></div>
<script>
(function(){var t=document.getElementById('dxTip');if(!t)return;
document.addEventListener('mousemove',function(e){var el=e.target.closest&&e.target.closest('[data-tip]');if(!el){t.hidden=true;return}
t.textContent=el.getAttribute('data-tip');t.hidden=false;var x=Math.min(e.clientX+14,window.innerWidth-t.offsetWidth-10);t.style.left=x+'px';t.style.top=(e.clientY+16)+'px'});
document.addEventListener('mouseleave',function(){t.hidden=true},true)})();
</script>
@endsection
