@extends('nahau-admin.layout')
@section('title', 'Dashboard')
@section('content')
@php use App\Nahau\Icons; $u = auth()->user(); @endphp
<div class="ph rise"><div><h2>Habari, {{ $u->first_name ?: 'karibu' }}</h2><p>Hali ya NahauAfrica leo. Namba zote ni halisi kutoka kwenye site.</p></div><div class="sp"></div>
  @if(App\Nahau\Panel::canRes('story'))<button class="btn" data-modal="{{ route('admin.stories.create') }}">{!! Icons::svg('plus') !!}Hadithi mpya</button>@endif
  @if(App\Nahau\Panel::canRes('opportunities'))<button class="btn sec" data-modal="{{ route('admin.nahau.create','opportunities') }}">{!! Icons::svg('briefcase') !!}Fursa mpya</button>@endif</div>

@foreach($expiring as $sl)
@php $en = \App\Nahau\AdminLang::current() === 'en'; @endphp
<div class="alert-soft rise" style="display:flex;flex-wrap:wrap;align-items:center;gap:10px;margin-bottom:12px;border-color:var(--org)"><div style="flex:1;min-width:220px"><b>{{ $sl->kind === 'hero' ? 'Hero' : 'Book' }} slide: {{ $sl->title }}</b><br>
  @if($en){{ $sl->expired() ? 'Time is up and the slide was removed from Home.' : $sl->daysLeft().' day(s) left on Home.' }} Add days or remove it and put another.@else{{ $sl->expired() ? 'Muda umeisha na slide imeondolewa kwenye Home.' : 'Siku '.$sl->daysLeft().' zimebaki kwenye Home.' }} Ongeza siku au iondoe uweke nyingine.@endif</div>
  <form method="post" action="{{ route('admin.nahau.carousel.extend', $sl->id) }}" style="display:flex;gap:6px;align-items:center">@csrf<select name="days" style="height:34px"><option value="4">Siku 4</option><option value="7" selected>Siku 7</option><option value="14">Siku 14</option><option value="30">Siku 30</option></select><button class="btn sm" type="submit" data-busy>Ongeza siku</button></form>
  <form method="post" action="{{ route('admin.nahau.destroy', ['carousel', $sl->id]) }}" onsubmit="return confirm('{{ $en ? 'Remove this slide?' : 'Kuondoa slide hii?' }}')">@csrf @method('DELETE')<button class="btn sm dng" type="submit">Ondoa</button></form></div>
@endforeach
<form class="rangebar rise" method="get" action="{{ route('admin.dashboard') }}"><b style="font-size:13px">Kipindi</b>
  <select name="range" onchange="this.form.submit()">@foreach([7=>'Siku 7 zilizopita',30=>'Siku 30 zilizopita',90=>'Siku 90 zilizopita',365=>'Mwaka 1 uliopita'] as $k=>$v)<option value="{{ $k }}" @selected($range==$k)>{{ $v }}</option>@endforeach</select>
  <span class="sub-t" style="margin:0">{{ $rFrom->format('M j') }} - {{ $rTo->format('M j, Y') }}</span></form>

<div class="card rise" style="margin-bottom:20px"><div class="kpi"><div><h4>Wasomaji</h4><p class="sub-t">Kurasa zilizosomwa na wasomaji wa kipekee, kwa siku</p></div><b>{{ number_format($readsTotal) }}</b></div>
  <div class="cwrap" id="cReads" style="margin-top:10px"></div>
  @unless($hasReads && $readsTotal)<div class="empty">Takwimu za wasomaji zinaanza kuhesabiwa sasa; zitaonekana wasomaji wakifungua hadithi.</div>@endunless</div>

<div class="chips rise" style="margin:0">
  @foreach(array_filter([['file','pri-soft','pri',$published,'Hadithi zilizochapishwa'],['clock','org-bg','org',$drafts,'Draft'],$canInbox?['inbox','cy-bg','cy',$newSubs + $newMsgs + $newOpp,'Mpya kwenye Inbox']:null,$full?['briefcase','grn-bg','grn',$opps,'Fursa zilizo wazi']:null]) as [$ic,$bg,$fg,$n,$l])
  <div class="chip2"><div class="bl" style="background:var(--{{ $bg }});color:var(--{{ $fg }})">{!! Icons::svg($ic) !!}</div><div><b>{{ number_format($n) }}</b><span>{{ $l }}</span></div></div>
  @endforeach
</div>

<div class="top3 rise">
  <div class="card"><h4>Hadithi zilizochapishwa kwa mwezi</h4><p class="sub-t">Miezi 6 iliyopita (kwa tarehe ya hadithi)</p>
    <div class="cwrap" id="cLine" style="margin-top:14px"></div></div>
  <div class="cards4">
    <div class="card stat"><div class="hd"><b>Wasomaji (views)</b></div><div class="l2">Jumla ya hadithi zote</div><div class="big">{{ number_format($views) }}</div><span class="tag g">kutoka kwenye hesabu ya site</span></div>
    @if($full)<div class="card stat"><div class="hd"><b>Subscribers</b></div><div class="l2">Waliothibitisha barua pepe</div><div class="big">{{ number_format($subs) }}</div></div>@endif
    <div class="card stat"><div class="hd"><b>Authors</b></div><div class="l2">Waandishi waliosajiliwa</div><div class="big">{{ number_format($authors) }}</div></div>
    @if($full)<div class="card stat"><div class="hd"><b>Fursa zinazosubiri uhakiki</b></div><div class="l2">Hazijathibitishwa bado</div><div class="big">{{ number_format($oppsUnverified) }}</div>@if($oppsUnverified)<span class="tag o">zinahitaji kazi</span>@endif</div>@endif
  </div>
</div>

<div class="dgrid rise" style="margin-bottom:20px">
  <div class="card"><div class="kpi"><h4>Hadithi zilizochapishwa</h4>@if($pubDelta)<span class="dlt {{ $pubDelta>0?'up':'dn' }}">{{ $pubDelta>0?'+':'' }}{{ $pubDelta }}</span>@endif<b>{{ number_format($pubNow) }}</b></div><p class="sub-t">Kwenye kipindi ulichochagua</p><div id="sPub"></div>
    <div class="lg-row"><i style="background:var(--pri)"></i>Published<span>{{ $published + $drafts ? round($published/($published+$drafts)*100) : 0 }}%</span></div><div class="lg-row"><i style="background:#9DB6FF"></i>Draft<span>{{ $published + $drafts ? round($drafts/($published+$drafts)*100) : 0 }}%</span></div></div>
  <div class="card"><div class="kpi"><h4>Wasomaji wapya</h4>@if($uDelta!==null)<span class="dlt {{ $uDelta>=0?'up':'dn' }}">{{ $uDelta>=0?'+':'' }}{{ $uDelta }}%</span>@endif<b>{{ number_format($uNow) }}</b></div><p class="sub-t">Wasomaji wa kipekee kwenye kipindi</p><div id="sRead"></div></div>
  <div class="card"><h4>Hadithi kwa lugha</h4><p class="sub-t">Kiswahili dhidi ya English</p><div id="cLang2"></div></div>
  <div class="card"><h4>Maombi ya fursa</h4><p class="sub-t">Fursa zilizo wazi dhidi ya zilizofungwa</p><div id="cGauge"></div>
    <div class="lg-row"><i style="background:var(--pri)"></i>Zilizo wazi<span>{{ $oppOpen }}</span></div><div class="lg-row"><i style="background:var(--hov)"></i>Zilizofungwa<span>{{ $oppClosed }}</span></div></div>
</div>

<div class="card rise" style="margin-bottom:20px"><div class="sechd"><div><h4>Hadithi zote</h4><p class="sub-t">Zilizochapishwa na draft, mpya kwanza</p></div><div class="sp"></div><a class="btn sm sec" href="{{ route('admin.stories') }}">Dhibiti</a></div>
  <div class="tw"><table><thead><tr><th>Kichwa</th><th>Mwandishi</th><th>Lugha</th><th>Hali</th><th>Tarehe</th><th></th></tr></thead><tbody>
  @forelse($stories as $st)<tr><td><div class="t">{{ \Illuminate\Support\Str::limit($st->title, 46) }}</div></td><td>{{ $st->author ?: 'Nahau Africa' }}</td><td><span class="bdg {{ $st->language==='en'?'en':'sw' }}">{{ $st->language==='en'?'English':'Kiswahili' }}</span></td><td><span class="tag {{ $st->status?'g':'o' }}">{{ $st->status?'Imechapishwa':'Draft' }}</span></td><td>{{ \Illuminate\Support\Carbon::parse($st->date)->format('d M Y') }}</td><td><a class="btn sm soft" href="{{ route('admin.stories') }}">Fungua</a></td></tr>@empty<tr><td colspan="6"><div class="empty">Hakuna hadithi bado.</div></td></tr>@endforelse
  </tbody></table></div>
  @if($stories->total())<div class="pgn"><span style="margin-right:auto;color:var(--mut)">{{ $stories->firstItem() }} hadi {{ $stories->lastItem() }} kati ya {{ $stories->total() }}</span>
    @if($stories->currentPage()>1)<a href="{{ $stories->previousPageUrl() }}">&lsaquo;</a>@endif
    @foreach(range(max(1,$stories->currentPage()-2), min($stories->lastPage(),$stories->currentPage()+2)) as $pg)@if($pg==$stories->currentPage())<span class="on">{{ $pg }}</span>@else<a href="{{ $stories->url($pg) }}">{{ $pg }}</a>@endif @endforeach
    @if($stories->hasMorePages())<a href="{{ $stories->nextPageUrl() }}">&rsaquo;</a>@endif</div>@endif</div>

<div class="card rise" style="margin-bottom:20px"><h4>Wasomaji kwa nchi</h4><p class="sub-t">Wasomaji wa kipekee kwa nchi, kwenye kipindi</p>
  @if(!$cTotal)<div class="empty">Nchi zitaonekana baada ya wasomaji kufungua hadithi (zinatambuliwa na mtandao wa Cloudflare wa Laravel Cloud).</div>
  @else<div class="ctry"><div class="cl">@foreach($cList as $c)<div><small>{{ $c[0] }}</small><strong>{{ number_format($c[1]) }}</strong></div>@endforeach</div><div id="cCtry"></div></div>@endif</div>

<div class="dgrid rise" style="margin-bottom:20px">
  <div class="card"><h4>Hadithi zinazosomwa zaidi</h4><p class="sub-t">Kwenye kipindi ulichochagua</p>
   @forelse($mostRead as $mr)<div class="mr"><div class="t"><span>{{ $mr[0] }}</span><span class="bdg {{ $mr[1]==='EN'?'en':'sw' }}" style="margin-left:auto">{{ $mr[1] }}</span><span>{{ number_format($mr[2]) }}</span></div><div class="br"><i style="width:{{ round($mr[2]/max(1,$mostRead[0][2])*100) }}%"></i></div></div>@empty<div class="empty">Bado hakuna kusoma kulikorekodiwa.</div>@endforelse</div>
  <div class="card"><h4>Hadithi kwa mwezi</h4><p class="sub-t">Kiswahili na English zilizochapishwa</p><div id="cMonth"></div></div>
</div>
<div class="card rise" style="margin-bottom:20px"><h4>Wasomaji wanaorudi</h4><p class="sub-t">Asilimia ya wasomaji wa kila mwezi: waliorudi dhidi ya wapya</p><div id="cRet"></div></div>

@if($canInbox)
<div class="card rise"><div class="sechd"><div><h4>Submissions mpya</h4><p class="sub-t">Hadithi zilizotumwa na wasomaji zinazosubiri kupitiwa</p></div><div class="sp"></div><a class="btn sm sec" href="{{ route('admin.nahau.index','submissions') }}">Zote</a></div>
  @if($pending->isEmpty())<div class="empty">Hakuna submission mpya. Zikija, zitaonekana hapa.</div>
  @else<div class="tw"><table><thead><tr><th>Mwandishi</th><th>Kichwa</th><th>Lugha</th><th>Tarehe</th><th></th></tr></thead><tbody>
    @foreach($pending as $s)<tr><td><div class="t">{{ $s->name }}</div><div class="s">{{ $s->email }}</div></td><td>{{ \Illuminate\Support\Str::limit($s->title, 50) }}</td><td><span class="bdg {{ $s->language==='sw'?'sw':'en' }}">{{ $s->language==='sw'?'Kiswahili':'English' }}</span></td><td>{{ $s->created_at?->format('d M Y') }}</td><td><div class="act"><button class="btn sm soft" data-modal="{{ route('admin.nahau.edit',['submissions',$s->id]) }}">Fungua</button></div></td></tr>@endforeach
  </tbody></table></div>@endif
</div>
@endif
@endsection
@push('scripts')
<script>
(function(){var m=@json($months),t=@json($top),l=@json($languages);
NH.line(document.getElementById('cLine'),m.map(function(x){return x[0]}),m.map(function(x){return x[1]}));
NH.multi(document.getElementById('cReads'),@json($rLabels2),[{name:'Kurasa zilizosomwa',vals:@json($rReads)},{name:'Wasomaji wa kipekee',vals:@json($rUniq)}]);
NH.spark(document.getElementById('sPub'),@json($pubSpark));NH.spark(document.getElementById('sRead'),@json($subSpark));
NH.donut(document.getElementById('cLang2'),l);
NH.gauge(document.getElementById('cGauge'),{{ $oppOpen + $oppClosed ? round($oppOpen/($oppOpen+$oppClosed)*100) : 0 }});
var ct=document.getElementById('cCtry');if(ct)NH.donut(ct,@json($cList));
NH.gbars(document.getElementById('cMonth'),@json($mLabels),[{name:'Kiswahili',vals:@json($mSw)},{name:'English',vals:@json($mEn)}]);
NH.multi(document.getElementById('cRet'),@json($ret[0]),[{name:'Wanaorudi',vals:@json($ret[1])},{name:'Wapya',vals:@json($ret[2])}],{pct:true,dots:true});
})();
</script>
@endpush
