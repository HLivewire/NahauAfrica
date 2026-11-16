@extends('nahau-admin.layout')
@section('title', 'Dashboard')
@section('content')
@php use App\Nahau\Icons; $u = auth()->user(); @endphp
<div class="ph rise"><div><h2>Habari, {{ $u->first_name ?: 'karibu' }}</h2><p>Hali ya NahauAfrica leo. Namba zote ni halisi kutoka kwenye site.</p></div><div class="sp"></div>
  @if(App\Nahau\Panel::canRes('stories'))<a class="btn" href="{{ route('admin.news.create') }}">{!! Icons::svg('plus') !!}Hadithi mpya</a>@endif
  @if(App\Nahau\Panel::canRes('opportunities'))<button class="btn sec" data-modal="{{ route('admin.nahau.create','opportunities') }}">{!! Icons::svg('briefcase') !!}Fursa mpya</button>@endif</div>

<div class="chips rise" style="margin:0">
  @foreach([['file','pri-soft','pri',$published,'Hadithi zilizochapishwa'],['clock','org-bg','org',$drafts,'Draft'],['inbox','cy-bg','cy',$newSubs + $newMsgs + $newOpp,'Mpya kwenye Inbox'],['briefcase','grn-bg','grn',$opps,'Fursa zilizo wazi']] as [$ic,$bg,$fg,$n,$l])
  <div class="chip2"><div class="bl" style="background:var(--{{ $bg }});color:var(--{{ $fg }})">{!! Icons::svg($ic) !!}</div><div><b>{{ number_format($n) }}</b><span>{{ $l }}</span></div></div>
  @endforeach
</div>

<div class="top3 rise">
  <div class="card"><h4>Hadithi zilizochapishwa kwa mwezi</h4><p class="sub-t">Miezi 6 iliyopita (kwa tarehe ya hadithi)</p>
    <div class="cwrap" id="cLine" style="margin-top:14px"></div></div>
  <div class="cards4">
    <div class="card stat"><div class="hd"><b>Wasomaji (views)</b></div><div class="l2">Jumla ya hadithi zote</div><div class="big">{{ number_format($views) }}</div><span class="tag g">kutoka kwenye hesabu ya site</span></div>
    <div class="card stat"><div class="hd"><b>Subscribers</b></div><div class="l2">Waliothibitisha barua pepe</div><div class="big">{{ number_format($subs) }}</div></div>
    <div class="card stat"><div class="hd"><b>Authors</b></div><div class="l2">Waandishi waliosajiliwa</div><div class="big">{{ number_format($authors) }}</div></div>
    <div class="card stat"><div class="hd"><b>Fursa zinazosubiri uhakiki</b></div><div class="l2">Hazijathibitishwa bado</div><div class="big">{{ number_format($oppsUnverified) }}</div>@if($oppsUnverified)<span class="tag o">zinahitaji kazi</span>@endif</div>
  </div>
</div>

<div class="two rise">
  <div class="card"><h4>Lugha za hadithi</h4><p class="sub-t">Kila hadithi ina lugha moja</p><div id="cLang" style="margin-top:14px"></div></div>
  <div class="card"><h4>Hadithi zinazosomwa zaidi</h4><p class="sub-t">Kwa idadi ya views</p><div id="cTop" style="margin-top:6px">@if(!count($top))<div class="empty">Bado hakuna views. Zitaonekana wasomaji wakianza kusoma.</div>@endif</div></div>
</div>

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
NH.donut(document.getElementById('cLang'),l);
if(t.length)NH.bars(document.getElementById('cTop'),t);})();
</script>
@endpush
