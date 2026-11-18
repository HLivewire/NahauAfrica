@extends('nahau-account.layout')
@section('title', 'Dashboard')
@section('content')
@php use App\Nahau\Icons; $lg = \App\Nahau\AdminLang::current(); @endphp
<div class="ph rise"><div><h2>Habari, {{ $u->first_name ?: 'karibu' }}</h2><p>Hapa ndipo unapoona ulichosoma, ulichohifadhi na hali ya hadithi ulizotuma.</p></div><div class="sp"></div>
  <a class="btn" href="{{ nroute('write') }}">{!! Icons::svg('send') !!}Tuma hadithi</a>
  <a class="btn sec" href="{{ nroute('home') }}">{!! Icons::svg('book') !!}Soma kitu kipya</a></div>

<div class="chips rise" style="margin:0">
  @foreach([['file','pri-soft','pri',$newStories,'Hadithi mpya wiki hii',route('account.history')],['bookmark','org-bg','org',$later,'Za kusoma baadaye',route('account.later')],['bell','cy-bg','cy',$unread,'Arifa mpya',route('account.notifications')],['send','grn-bg','grn',$subsOpen,'Hadithi zangu zinazopitiwa',route('account.mine')]] as [$ic,$bg,$fg,$n,$l,$href])
  <a class="chip2" href="{{ $href }}" style="color:inherit;text-decoration:none"><div class="bl" style="background:var(--{{ $bg }});color:var(--{{ $fg }})">{!! Icons::svg($ic) !!}</div><div><b>{{ number_format($n) }}</b><span>{{ $l }}</span></div></a>
  @endforeach
</div>

<div class="card rise" style="margin-bottom:20px"><div class="sechd"><div><h4>Shughuli yangu ya kusoma</h4><p class="sub-t">Hadithi ulizofungua ukiwa umeingia, kwa siku</p></div><div class="sp"></div>
  <form method="get" action="{{ route('account.dashboard') }}"><select class="rangesel" name="range" onchange="this.form.submit()">@foreach([7=>'Siku 7',30=>'Siku 30',90=>'Siku 90'] as $k=>$v)<option value="{{ $k }}" @selected($range==$k)>{{ $v }}</option>@endforeach</select></form></div>
  <div class="cwrap" id="cAct" style="margin-top:10px"></div>
  @if(!array_sum($a))<div class="empty">Bado hujasoma chochote kwenye kipindi hiki. Fungua hadithi ukiwa umeingia, nazo zitaonekana hapa.</div>@endif</div>

<div class="dgrid rise" style="margin-bottom:20px">
  <div class="card"><div class="kpi"><h4>Hadithi nilizosoma</h4><b>{{ number_format($readTotal) }}</b></div><p class="sub-t">Jumla, siku 7 zilizopita kwa chati</p><div id="sWeek"></div>
    <div class="lg-row"><i style="background:var(--pri)"></i>Mwezi huu<span>{{ $monthReads }}</span></div></div>
  <div class="card"><h4>Lengo la mwezi</h4><p class="sub-t">Lengo lako: {{ $goal }} hadithi kwa mwezi. Badilisha kwenye Wasifu.</p><div id="cGoal"></div>
    <div class="lg-row"><i style="background:var(--pri)"></i>Umesoma<span>{{ $monthReads }}</span></div><div class="lg-row"><i style="background:var(--hov)"></i>Zilizobaki<span>{{ max(0, $goal - $monthReads) }}</span></div></div>
  <div class="card"><h4>Maktaba yangu</h4><p class="sub-t">Ulichohifadhi</p><div id="cLib"></div></div>
  <div class="card"><h4>Hadithi nilizotuma</h4><p class="sub-t">Zilizokubaliwa dhidi ya jumla</p><div id="cSub"></div>
    <div class="lg-row"><i style="background:var(--pri)"></i>Zilizokubaliwa<span>{{ $subsOk }}</span></div><div class="lg-row"><i style="background:var(--hov)"></i>Jumla<span>{{ $subsTotal }}</span></div></div>
</div>

<div class="card rise" style="margin-bottom:20px"><div class="sechd"><div><h4>Nilichosoma hivi karibuni</h4><p class="sub-t">Hadithi 5 za mwisho</p></div><div class="sp"></div><a class="btn sm sec" href="{{ route('account.history') }}">Zote</a></div>
  @if($recent->isEmpty())<div class="empty">Historia yako itaonekana ukianza kusoma ukiwa umeingia.</div>
  @else<div class="tw"><table class="tbl2"><thead><tr><th>Kichwa cha hadithi</th><th>Mwandishi</th><th>Lugha</th><th>Lini</th><th></th></tr></thead><tbody>
  @foreach($recent as $r)@php $m = $meta[$r->id] ?? null; $st = \App\Nahau\Stories::query()->where('news.id', $r->id)->first(); @endphp
    <tr><td><div class="t">{{ \Illuminate\Support\Str::limit($r->title, 56) }}</div></td><td>{{ $m->author ?? 'Nahau Africa' }}</td><td><span class="bdg {{ ($m->language ?? 'sw') === 'en' ? 'en' : 'sw' }}">{{ ($m->language ?? 'sw') === 'en' ? 'English' : 'Kiswahili' }}</span></td><td>{{ \Illuminate\Support\Carbon::parse($r->at)->locale($lg)->diffForHumans() }}</td><td>@if($st)<a class="btn sm soft" href="{{ \App\Nahau\Stories::url($st) }}">Soma tena</a>@endif</td></tr>
  @endforeach</tbody></table></div>@endif</div>

<div class="card rise"><div class="sechd"><div><h4>Arifa za hivi karibuni</h4><p class="sub-t">Hadithi mpya, African Heroes, hali ya hadithi yako, kazi na fursa</p></div><div class="sp"></div><a class="btn sm sec" href="{{ route('account.notifications') }}">Zote</a></div>
  @include('nahau-account._notes', ['list' => array_slice($notes, 0, 5)])</div>
@endsection
@push('scripts')
<script>
(function(){
NH.multi(document.getElementById('cAct'),@json($labels),[{name:'Kurasa zilizofunguliwa',vals:@json($a)},{name:'Hadithi tofauti',vals:@json($b)}]);
NH.spark(document.getElementById('sWeek'),@json($week));
NH.gauge(document.getElementById('cGoal'),{{ $goalPct }});
NH.donut(document.getElementById('cLib'),[['Favourites',{{ $favs }}],['Soma baadaye',{{ $later }}],['Wafuatwa',{{ $follows }}]]);
NH.gauge(document.getElementById('cSub'),{{ $subsTotal ? (int) round($subsOk / $subsTotal * 100) : 0 }});
})();
</script>
@endpush
