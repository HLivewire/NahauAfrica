@extends('admin.master')

@section('main_content')
@php
    $max = max(1, max(array_column($series, 'count')));
    $W = 800; $H = 260; $padT = 16; $padB = 6; $n = count($series);
    $pts = [];
    foreach ($series as $i => $m) {
        $pts[] = [round($i * $W / max(1, $n - 1), 1), round($H - $padB - ($m['count'] / $max) * ($H - $padT - $padB), 1)];
    }
    $line = 'M'.$pts[0][0].','.$pts[0][1];
    for ($i = 1; $i < $n; $i++) {
        $cx = round(($pts[$i-1][0] + $pts[$i][0]) / 2, 1);
        $line .= ' C'.$cx.','.$pts[$i-1][1].' '.$cx.','.$pts[$i][1].' '.$pts[$i][0].','.$pts[$i][1];
    }
    $area = $line.' L'.$W.','.$H.' L0,'.$H.' Z';
    $monthTotal = array_sum(array_column($series, 'count'));
@endphp
<div class="content-wrapper wv">
    <section class="content">
        <div class="container-fluid wv-wrap">

            <header class="wv-head">
                <div>
                    <span class="wv-kicker">{{ __('Operational status') }}</span>
                    <h1>{{ __('Newsroom overview') }}</h1>
                    <p>{{ __('Real-time view of stories, readers and what needs your attention.') }}</p>
                </div>
                <div class="wv-head-actions">
                    <span class="wv-live"><i></i>{{ __('LIVE') }}</span>
                    <a class="wv-btn" href="{{ route('admin.news') }}"><i class="fas fa-bolt"></i> {{ __('Manage stories') }}</a>
                </div>
            </header>

            <div class="row wv-kpis">
                <div class="col-lg-4 col-md-6">
                    <a class="wv-card wv-kpi" href="{{ route('admin.news') }}">
                        <span class="wv-ico"><i class="fas fa-bolt"></i></span>
                        <span class="wv-lbl">{{ __('Published stories') }}</span>
                        <span class="wv-num">{{ number_format($publish_news) }}</span>
                        <span class="wv-sub"><b class="ok">{{ number_format($totalReads) }}</b> {{ __('total reads') }}</span>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a class="wv-card wv-kpi" href="{{ route('admin.news') }}">
                        <span class="wv-ico warn"><i class="fas fa-tachometer-alt"></i></span>
                        <span class="wv-lbl">{{ __('Drafts waiting') }}</span>
                        <span class="wv-num">{{ number_format($unpublish_news) }}</span>
                        <span class="wv-sub">{{ $unpublish_news ? __('Review and publish') : __('All caught up') }}</span>
                    </a>
                </div>
                <div class="col-lg-4 col-md-12">
                    <a class="wv-card wv-kpi" href="{{ route('admin.subscriber') }}">
                        <span class="wv-ico"><i class="fas fa-plug"></i></span>
                        <span class="wv-lbl">{{ __('Subscribers') }}</span>
                        <span class="wv-num">{{ number_format($subscribe) }}</span>
                        <span class="wv-sub"><b class="ok">{{ $admin }}</b> {{ __('active staff accounts') }}</span>
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <section class="wv-card wv-chart">
                        <div class="wv-card-head"><h2>{{ __('Stories created, last 12 months') }}</h2><span class="wv-legend"><i></i>{{ __('Stories') }} · {{ $monthTotal }}</span></div>
                        <div class="wv-svgbox">
                            <svg viewBox="0 0 {{ $W }} {{ $H }}" preserveAspectRatio="none" role="img" aria-label="{{ __('Stories created per month') }}">
                                <defs><linearGradient id="wvg" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#00E5FF" stop-opacity=".38"/><stop offset="1" stop-color="#30D158" stop-opacity="0"/></linearGradient></defs>
                                @foreach([0.25,0.5,0.75,1] as $g)<line x1="0" x2="{{ $W }}" y1="{{ round($H - $padB - $g * ($H - $padT - $padB),1) }}" y2="{{ round($H - $padB - $g * ($H - $padT - $padB),1) }}" stroke="#2C2C2E" stroke-width="1" vector-effect="non-scaling-stroke"/>@endforeach
                                <path d="{{ $area }}" fill="url(#wvg)"/>
                                <path d="{{ $line }}" fill="none" stroke="#00E5FF" stroke-width="2.5" stroke-linecap="round" vector-effect="non-scaling-stroke"/>
                            </svg>
                            <div class="wv-axis">@foreach($series as $m)<span>{{ $m['label'] }}</span>@endforeach</div>
                        </div>
                    </section>
                </div>
                <div class="col-lg-4">
                    <aside class="wv-card wv-alerts">
                        <div class="wv-card-head"><h2>{{ __('Alerts') }}</h2></div>
                        @if($unpublish_news)
                        <a class="wv-alert" href="{{ route('admin.news') }}"><i class="fas fa-bolt"></i><div><b>{{ $unpublish_news }} {{ __('drafts not published') }}</b><small>{{ __('Review before they go stale') }}</small></div></a>
                        @endif
                        @if($noCover)
                        <a class="wv-alert" href="{{ route('admin.news') }}"><i class="fas fa-exclamation-triangle"></i><div><b>{{ $noCover }} {{ __('stories without a cover') }}</b><small>{{ __('Add a cover so cards look complete') }}</small></div></a>
                        @endif
                        @if(!$unpublish_news && !$noCover)
                        <div class="wv-okbox"><i class="fas fa-check-circle"></i> {{ __('Everything looks good. No alerts.') }}</div>
                        @endif
                        <h3 class="wv-sec">{{ __('Latest activity') }}</h3>
                        @foreach($latest as $l)
                        <a class="wv-row" href="{{ route('admin.news') }}"><span class="dot {{ $l->status ? 'on' : '' }}"></span><span class="t">{{ \Illuminate\Support\Str::limit($l->title, 38) }}</span><span class="ago">{{ $l->created_at?->diffForHumans(null, true, true) }}</span></a>
                        @endforeach
                    </aside>
                </div>
            </div>

            <section class="wv-card wv-table">
                <div class="wv-card-head"><div><h2>{{ __('Most read stories') }}</h2><span class="wv-cap">{{ __('Content performance') }}</span></div></div>
                <div class="table-responsive">
                <table>
                    <thead><tr><th>{{ __('Story') }}</th><th>{{ __('Status') }}</th><th>{{ __('Created') }}</th><th class="r">{{ __('Reads') }}</th></tr></thead>
                    <tbody>
                    @forelse($topRead as $t)
                        <tr><td class="story">{{ \Illuminate\Support\Str::limit($t->title, 70) }}</td>
                            <td><span class="wv-pill {{ $t->status ? 'ok' : 'warn' }}">{{ $t->status ? __('Published') : __('Draft') }}</span></td>
                            <td class="mono">{{ $t->created_at?->format('d M Y') }}</td>
                            <td class="mono r">{{ number_format((int) $t->viewers) }}</td></tr>
                    @empty
                        <tr><td colspan="4" class="empty">{{ __('No stories yet.') }}</td></tr>
                    @endforelse
                    </tbody>
                </table>
                </div>
            </section>
        </div>
    </section>
</div>
@endsection
