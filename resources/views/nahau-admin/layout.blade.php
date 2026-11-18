@php
    use App\Nahau\Icons; use App\Nahau\Panel;
    $u = auth()->user();
    $nav = Panel::nav();
    $initials = strtoupper(mb_substr($u->first_name ?? 'A', 0, 1).mb_substr($u->last_name ?? '', 0, 1)) ?: 'A';
    $cur = url()->current();
    // active = longest nav url that matches the current url
    $best = null; $bestLen = 0; $flat = [];
    foreach ($nav as $it) {
        if (isset($it['url'])) { $flat[] = [$it['label'], $it['url'], 'k:'.$it['key']]; }
        foreach ($it['kids'] ?? [] as $c) { $flat[] = [$c[0], $c[1], 'k:'.$c[3]]; }
    }
    foreach ($flat as $f) {
        $m = $f[1] === route('admin.dashboard') ? ($cur === $f[1]) : ($cur === $f[1] || str_starts_with($cur, $f[1].'/'));
        if ($m && strlen($f[1]) > $bestLen) { $best = $f[2]; $bestLen = strlen($f[1]); }
    }
    $new = [
        ['submissions', \App\Models\NahauSubmission::where('status', 'new')->latest()->take(3)->get(), fn ($r) => [$r->name, 'Ametuma hadithi "'.$r->title.'"']],
        ['messages', \App\Models\NahauMessage::where('status', 'new')->latest()->take(3)->get(), fn ($r) => [$r->name, 'Ujumbe: '.\Illuminate\Support\Str::limit($r->message, 60)]],
        ['opportunity-submissions', \App\Models\NahauOpportunitySubmission::where('status', 'new')->latest()->take(3)->get(), fn ($r) => [$r->organisation, 'Fursa mpya: '.$r->title]],
    ];
    $notes = [];
    foreach ($new as [$res, $rows, $fmt]) { if (!Panel::canRes($res)) continue; foreach ($rows as $r) { [$a, $b] = $fmt($r); $notes[] = [$a, $b, $r->created_at?->diffForHumans(), route('admin.nahau.index', $res)]; } }
@endphp
<!doctype html>
<html lang="{{ \App\Nahau\AdminLang::current() }}" data-theme="light">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Admin') · NahauAfrica</title>
<link rel="icon" type="image/png" href="{{ asset('adminassets/img/nahau/favicon-180.png') }}"><link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('adminassets/css/nahau-admin.css') }}?v={{ @filemtime(public_path('adminassets/css/nahau-admin.css')) }}">
<script>try{var t=localStorage.getItem('nh_theme');if(t==='dark'||t==='light')document.documentElement.setAttribute('data-theme',t);else document.documentElement.removeAttribute('data-theme');}catch(e){}</script>
</head>
<body>
<script>try{if(localStorage.getItem('nh_col')==='1')document.body.classList.add('sb-c')}catch(e){}</script>
<header class="tb">
  <div class="tb-l">
    <button class="burger" id="burger" aria-label="Fungua menyu"><svg class="ic lg" viewBox="0 0 24 24"><path d="M3 12h18M3 6h18M3 18h18"/></svg></button>
    <a class="logo" href="{{ route('admin.dashboard') }}" aria-label="NahauAfrica">
      <img class="l" alt="NahauAfrica" src="{{ asset('adminassets/img/nahau/logo-light.png') }}">
      <img class="d" alt="" aria-hidden="true" src="{{ asset('adminassets/img/nahau/logo-dark.png') }}">
    </a>
  </div>
  <div class="search" id="searchBox">
    <svg class="ic" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
    <input id="gs" type="search" autocomplete="off" placeholder="Tafuta ukurasa au kazi…" aria-label="Tafuta">
    <kbd>/</kbd>
    <div class="sres" id="sres" role="listbox"></div>
  </div>
  <div class="tb-r">
    <button class="ib theme" id="themeBtn" aria-label="Badilisha mwonekano (giza au mwanga)"><svg class="ic s" viewBox="0 0 24 24"><circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg><svg class="ic m" viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg></button>
    @php $lg = \App\Nahau\AdminLang::current(); @endphp
    <a class="ib lang" href="{{ route('admin.lang', $lg === 'en' ? 'sw' : 'en') }}" aria-label="Badilisha lugha" title="{{ $lg === 'en' ? 'Kiswahili' : 'English' }}">{!! Icons::svg('globe') !!}<b>{{ strtoupper($lg) }}</b></a>
    <div class="dwrap"><button class="ib" data-dd="ddN" aria-label="Arifa" aria-haspopup="true">{!! Icons::svg('bell') !!}@if(count($notes))<span class="dot"></span>@endif</button>
      <div class="dd dd-n" id="ddN" role="menu">
        <div class="dd-h"><b>Arifa</b></div>
        <div class="nlist">@forelse($notes as $n)<a class="nrow un" href="{{ $n[3] }}"><span class="av">{{ strtoupper(mb_substr($n[0], 0, 1)) }}</span><div><b>{{ $n[0] }}</b><span>{{ $n[1] }}</span><small>{{ $n[2] }}</small></div></a>@empty<div class="empty">Hakuna arifa mpya</div>@endforelse</div>
        <div class="dd-f"><a href="{{ route('admin.nahau.index', 'submissions') }}">Fungua Inbox</a></div>
      </div></div>
    <div class="dwrap hide-m"><button class="ib hide-m" data-dd="ddA" aria-label="Njia za mkato" aria-haspopup="true"><svg class="ic" viewBox="0 0 24 24" style="fill:currentColor;stroke:none"><circle cx="5" cy="5" r="1.7"/><circle cx="12" cy="5" r="1.7"/><circle cx="19" cy="5" r="1.7"/><circle cx="5" cy="12" r="1.7"/><circle cx="12" cy="12" r="1.7"/><circle cx="19" cy="12" r="1.7"/><circle cx="5" cy="19" r="1.7"/><circle cx="12" cy="19" r="1.7"/><circle cx="19" cy="19" r="1.7"/></svg></button>
      <div class="dd dd-a" id="ddA" role="menu"><div class="agrid">
        @if(Panel::canRes('story'))<button data-modal="{{ route('admin.stories.create') }}"><i>{!! Icons::svg('file') !!}</i>Hadithi mpya</button>@endif
        @if(Panel::canRes('opportunities'))<button data-modal="{{ route('admin.nahau.create', 'opportunities') }}"><i>{!! Icons::svg('briefcase') !!}</i>Fursa mpya</button>@endif
        @if(Panel::canRes('authors'))<button data-modal="{{ route('admin.nahau.create', 'authors') }}"><i>{!! Icons::svg('user') !!}</i>Mwandishi</button>@endif
        @if(Panel::isAdmin())<button data-modal="{{ route('admin.panel.users.create') }}"><i>{!! Icons::svg('userplus') !!}</i>Alika mtumiaji</button>@endif
        <button data-modal="{{ route('admin.panel.password') }}"><i>{!! Icons::svg('lock') !!}</i>Nenosiri</button>
        <a class="qa" href="{{ url('/') }}" target="_blank" rel="noopener"><i>{!! Icons::svg('globe') !!}</i>Tazama site</a>
      </div></div></div>
    <div class="dwrap"><button class="ib" data-dd="ddP" aria-label="Akaunti yangu" aria-haspopup="true"><span class="av">{{ $initials }}</span></button>
      <div class="dd dd-p" id="ddP" role="menu">
        <div class="pcard"><span class="av lgv">{{ $initials }}</span><b>{{ trim(($u->first_name ?? '').' '.($u->last_name ?? '')) ?: $u->email }}</b><span class="chip">{{ Panel::roleName() }}</span></div>
        <div class="pm" style="margin-top:8px">
          <button data-modal="{{ route('admin.panel.profile') }}">{!! Icons::svg('user') !!}Wasifu wangu</button>
          <a class="pmx" href="{{ route('admin.dashboard') }}">{!! Icons::svg('home') !!}Dashboard</a>
          <button data-modal="{{ route('admin.panel.password') }}">{!! Icons::svg('shield') !!}Usalama na nenosiri</button>
          @if(Panel::isAdmin())<hr><button data-modal="{{ route('admin.panel.users.create') }}">{!! Icons::svg('userplus') !!}Alika Administrator mwingine</button>@endif
        </div>
        <a class="so" href="{{ route('logout') }}">{!! Icons::svg('logout', 'sm') !!}Toka</a>
        <div class="pf">NahauAfrica · Ubitech Solutions</div>
      </div></div>
  </div>
</header>

<aside class="side" id="side" aria-label="Menyu kuu">
  <nav class="sb" id="nav">
  @foreach($nav as $it)
    @if(isset($it['section']))<div class="sl">{{ $it['section'] }}</div>
    @elseif(isset($it['url']))
      <a class="ni{{ $best === 'k:'.$it['key'] ? ' on' : '' }}" href="{{ $it['url'] }}" title="{{ $it['label'] }}">{!! Icons::svg($it['icon']) !!}<span class="lb">{{ $it['label'] }}</span></a>
    @else
      @php $act = collect($it['kids'])->contains(fn ($c) => $best === 'k:'.$c[3]); @endphp
      <button class="ni{{ $act ? ' open' : '' }}" data-g="{{ $it['label'] }}" title="{{ $it['label'] }}" aria-expanded="{{ $act ? 'true' : 'false' }}">{!! Icons::svg('chev', 'car') !!}{!! Icons::svg($it['icon']) !!}<span class="lb">{{ $it['label'] }}</span>@if(isset($it['badge']))<span class="bd{{ (int) $it['badge'] === 0 ? ' z' : '' }}">{{ (int) $it['badge'] }}</span>@endif</button>
      <div class="gr{{ $act ? ' open' : '' }}"><div>@foreach($it['kids'] as $c)<a class="sub{{ $best === 'k:'.$c[3] ? ' on' : '' }}" href="{{ $c[1] }}">{{ $c[0] }}</a>@endforeach</div></div>
    @endif
  @endforeach
  </nav>
  <div class="sf"><button id="collapseBtn" aria-label="Punguza sidebar"><svg class="ic" viewBox="0 0 24 24"><path d="M11 17l-5-5 5-5M18 17l-5-5 5-5"/></svg><span>Collapsed View</span></button></div>
</aside>
<div class="scrim" id="scrim"></div>
<main class="main"><div class="content" id="content">
  @if($u->must_change_password)<div class="forcepw">Tafadhali badilisha nenosiri lako la mwanzo sasa hivi. <a href="#" data-modal="{{ route('admin.panel.password') }}">Badilisha nenosiri</a></div>@endif
  @yield('content')
</div></main>
<div class="ov" id="ov" role="dialog" aria-modal="true"><div class="modal" id="modal"></div></div>

<script>window.NH={dict:(function(){try{return JSON.parse(decodeURIComponent(escape(atob('{{ \App\Nahau\AdminLang::current() === 'en' ? base64_encode(json_encode(\App\Nahau\AdminLang::DICT, JSON_UNESCAPED_UNICODE)) : base64_encode('{}') }}'))))}catch(e){return {}}})(),csrf:document.querySelector('meta[name=csrf-token]').content,go:@json(collect($flat)->map(fn($f)=>[$f[0],$f[1]])->values()),flash:@json(session('success')),forcePw:@json((bool)$u->must_change_password),pwUrl:@json(route('admin.panel.password')),icons:@json(\App\Nahau\Icons::P)};</script>
<script src="{{ asset('adminassets/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('adminassets/js/nahau-admin.js') }}?v={{ @filemtime(public_path('adminassets/js/nahau-admin.js')) }}"></script>
@stack('scripts')
</body>
</html>
