@php
    use App\Nahau\Icons; use App\Nahau\ReaderNotes;
    $lg = \App\Nahau\AdminLang::current();
    $u = auth('maanuser')->user();
    $initials = strtoupper(mb_substr($u->first_name ?? 'A', 0, 1).mb_substr($u->last_name ?? '', 0, 1)) ?: 'A';
    $fullName = trim(($u->first_name ?? '').' '.($u->last_name ?? '')) ?: $u->email;
    $allNotes = $notes ?? ReaderNotes::for($u, 12);
    $unreadN = ReaderNotes::unread($allNotes);
    $cnt = [
        'fav' => \App\Models\NahauFavorite::where('maanuser_id', $u->id)->count(),
        'later' => \App\Models\NahauReadingList::where('maanuser_id', $u->id)->count(),
        'follows' => \App\Models\NahauFollow::where('maanuser_id', $u->id)->count(),
        'mine' => \App\Models\NahauSubmission::where('email', $u->email)->count(),
    ];
    $nav = [
        ['s' => 'Nyumbani'],
        ['home', 'Dashboard', route('account.dashboard'), 'dashboard', null],
        ['s' => 'Maktaba yangu'],
        ['heart', 'Favourites', route('account.favourites'), 'favourites', $cnt['fav']],
        ['bookmark', 'Soma baadaye', route('account.later'), 'later', $cnt['later']],
        ['clock', 'Nilichosoma', route('account.history'), 'history', null],
        ['users', 'Wafuatwa', route('account.follows'), 'follows', $cnt['follows']],
        ['s' => 'Uandishi'],
        ['file', 'Hadithi zangu', route('account.mine'), 'mine', $cnt['mine']],
        ['s' => 'Akaunti'],
        ['bell', 'Taarifa', route('account.notifications'), 'notifications', $unreadN],
        ['user', 'Wasifu', route('account.profile'), 'profile', null],
    ];
    $cur = url()->current(); $best = null; $bl = 0;
    foreach ($nav as $it) { if (isset($it['s'])) continue; $m = $it[2] === route('account.dashboard') ? $cur === $it[2] : ($cur === $it[2] || str_starts_with($cur, $it[2].'/')); if ($m && strlen($it[2]) > $bl) { $best = $it[3]; $bl = strlen($it[2]); } }
    $go = collect($nav)->filter(fn ($i) => ! isset($i['s']))->map(fn ($i) => [$i[1], $i[2]])->values();
@endphp
<!doctype html>
<html lang="{{ $lg }}" data-theme="light">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Akaunti') · NahauAfrica</title>
<link rel="icon" type="image/png" href="{{ asset('adminassets/img/nahau/favicon-180.png') }}"><link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('adminassets/css/nahau-admin.css') }}?v={{ @filemtime(public_path('adminassets/css/nahau-admin.css')) }}">
<script>try{var t=localStorage.getItem('nh_theme');if(t==='dark'||t==='light')document.documentElement.setAttribute('data-theme',t);else document.documentElement.removeAttribute('data-theme');}catch(e){}</script>
</head>
<body>
<script>try{if(localStorage.getItem('nh_col')==='1')document.body.classList.add('sb-c')}catch(e){}</script>
<body>
<script>try{if(localStorage.getItem('nh_col')==='1')document.body.classList.add('sb-c')}catch(e){}</script>
<header class="tb">
  <div class="tb-l">
    <button class="burger" id="burger" aria-label="Fungua menyu"><svg class="ic lg" viewBox="0 0 24 24"><path d="M3 12h18M3 6h18M3 18h18"/></svg></button>
    <a class="logo" href="{{ route('account.dashboard') }}" aria-label="NahauAfrica">
      <img class="l" alt="NahauAfrica" src="{{ asset('adminassets/img/nahau/logo-light.png') }}">
      <img class="d" alt="" aria-hidden="true" src="{{ asset('adminassets/img/nahau/logo-dark.png') }}">
    </a>
  </div>
  <div class="search" id="searchBox">
    <svg class="ic" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
    <input id="gs" type="search" autocomplete="off" placeholder="Tafuta ukurasa..." aria-label="Tafuta">
    <kbd>/</kbd>
    <div class="sres" id="sres" role="listbox"></div>
  </div>
  <div class="tb-r">
    <button class="ib theme" id="themeBtn" aria-label="Badilisha mwonekano (giza au mwanga)"><svg class="ic s" viewBox="0 0 24 24"><circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg><svg class="ic m" viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg></button>
    <div class="lsw" role="group" aria-label="Lugha"><a href="{{ route('account.lang', 'sw') }}" class="{{ $lg === 'sw' ? 'on' : '' }}" aria-current="{{ $lg === 'sw' ? 'true' : 'false' }}">SWH</a><a href="{{ route('account.lang', 'en') }}" class="{{ $lg === 'en' ? 'on' : '' }}" aria-current="{{ $lg === 'en' ? 'true' : 'false' }}">ENG</a></div>
    <div class="dwrap"><button class="ib" data-dd="ddN" aria-label="Arifa" aria-haspopup="true">{!! Icons::svg('bell') !!}@if($unreadN)<span class="dot"></span>@endif</button>
      <div class="dd dd-n" id="ddN" role="menu">
        <div class="dd-h"><b>Arifa</b>@if($unreadN)<form method="post" action="{{ route('account.notifications.read') }}" style="margin-left:auto">@csrf<button type="submit" style="border:0;background:none;color:var(--pri);font-weight:700;font-size:12px">Weka zote zimesomwa</button></form>@endif</div>
        <div class="nlist">@forelse(array_slice($allNotes, 0, 8) as $n)<a class="nrow{{ $n['unread'] ? ' un' : '' }}" href="{{ $n['url'] }}"><span class="av" style="background:var(--pri-soft);color:var(--pri);display:grid;place-items:center">{!! Icons::svg($n['icon'], 'sm') !!}</span><div><b>{{ $n['title'] }}</b><span>{{ $n['body'] }}</span><small>{{ $n['label'] }} · {{ $n['at']->locale($lg)->diffForHumans() }}</small></div></a>@empty<div class="empty">Hakuna arifa mpya</div>@endforelse</div>
        <div class="dd-f"><a href="{{ route('account.notifications') }}">Arifa zote</a></div>
      </div></div>
    <div class="dwrap hide-m"><button class="ib hide-m" data-dd="ddA" aria-label="Njia za mkato" aria-haspopup="true"><svg class="ic" viewBox="0 0 24 24" style="fill:currentColor;stroke:none"><circle cx="5" cy="5" r="1.7"/><circle cx="12" cy="5" r="1.7"/><circle cx="19" cy="5" r="1.7"/><circle cx="5" cy="12" r="1.7"/><circle cx="12" cy="12" r="1.7"/><circle cx="19" cy="12" r="1.7"/><circle cx="5" cy="19" r="1.7"/><circle cx="12" cy="19" r="1.7"/><circle cx="19" cy="19" r="1.7"/></svg></button>
      <div class="dd dd-a" id="ddA" role="menu"><div class="agrid">
        <a class="qa" href="{{ nroute('write') }}"><i>{!! Icons::svg('send') !!}</i>Tuma hadithi</a>
        <a class="qa" href="{{ nroute('opportunities') }}"><i>{!! Icons::svg('briefcase') !!}</i>Kazi na fursa</a>
        <a class="qa" href="{{ nroute('fiction') }}"><i>{!! Icons::svg('book') !!}</i>Soma hadithi</a>
        <a class="qa" href="{{ url('/') }}"><i>{!! Icons::svg('globe') !!}</i>Tazama site</a>
      </div></div></div>
    <div class="dwrap"><button class="ib" data-dd="ddP" aria-label="Akaunti yangu" aria-haspopup="true"><span class="av">{{ $initials }}</span></button>
      <div class="dd dd-p" id="ddP" role="menu">
        <div class="pcard"><span class="av lgv">{{ $initials }}</span><b>{{ $fullName }}</b><span class="chip">Msomaji</span></div>
        <div class="pm" style="margin-top:8px">
          <a class="pmx" href="{{ route('account.profile') }}">{!! Icons::svg('user') !!}Wasifu wangu</a>
          <a class="pmx" href="{{ route('account.dashboard') }}">{!! Icons::svg('home') !!}Dashboard</a>
          <a class="pmx" href="{{ route('account.mine') }}">{!! Icons::svg('file') !!}Hadithi zangu</a>
        </div>
        <a class="so" href="{{ route('logout') }}" data-busy>{!! Icons::svg('logout', 'sm') !!}Toka</a>
        <div class="pf">NahauAfrica · Our Stories. Our Voices.</div>
      </div></div>
  </div>
</header>

<aside class="side" id="side" aria-label="Menyu kuu">
  <nav class="sb" id="nav">
  @foreach($nav as $it)
    @if(isset($it['s']))<div class="sl">{{ $it['s'] }}</div>
    @else
      <a class="ni{{ $best === $it[3] ? ' on' : '' }}" href="{{ $it[2] }}" title="{{ $it[1] }}">{!! Icons::svg($it[0]) !!}<span class="lb">{{ $it[1] }}</span>@if($it[4] !== null && ($it[4] > 0 || $it[3] === 'notifications'))<span class="bd{{ ((int) $it[4] === 0 || $it[3] !== 'notifications') ? ' z' : '' }}">{{ (int) $it[4] }}</span>@endif</a>
    @endif
  @endforeach
  </nav>
  <div class="sf"><button id="collapseBtn" aria-label="Punguza sidebar"><svg class="ic" viewBox="0 0 24 24"><path d="M11 17l-5-5 5-5M18 17l-5-5 5-5"/></svg><span>Collapsed View</span></button></div>
</aside>
<div class="scrim" id="scrim"></div>
<main class="main"><div class="content" id="content">
  @if(session('ok'))<div class="flash2">{{ session('ok') }}</div>@endif
  @yield('content')
</div></main>
<div class="ov" id="ov" role="dialog" aria-modal="true"><div class="modal" id="modal"></div></div>

<script>window.NH={dict:(function(){try{return JSON.parse(decodeURIComponent(escape(atob('{{ $lg === 'en' ? base64_encode(json_encode(\App\Nahau\AdminLang::DICT, JSON_UNESCAPED_UNICODE)) : base64_encode('{}') }}'))))}catch(e){return {}}})(),csrf:document.querySelector('meta[name=csrf-token]').content,go:@json($go),flash:null,forcePw:false,pwUrl:'',icons:@json(\App\Nahau\Icons::P)};</script>
<script src="{{ asset('adminassets/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('adminassets/js/nahau-admin.js') }}?v={{ @filemtime(public_path('adminassets/js/nahau-admin.js')) }}"></script>
@stack('scripts')
</body>
</html>
