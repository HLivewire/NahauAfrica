@extends('nahau-admin.layout')
@section('title', 'Audit Activity')
@section('content')
@php use App\Nahau\Icons; use App\Models\ActivityLog as A; $f = request()->query(); @endphp
<div class="ph rise"><div><h2>Audit Activity</h2><p>Kila kinachofanyika kwenye mfumo: nani, nini, lini, na kutoka wapi. Rekodi hizi haziwezi kubadilishwa wala kufutwa.</p></div><div class="sp"></div>
  <a class="btn sec" data-no-spin href="{{ route('admin.audit.export', request()->query()) }}">{!! Icons::svg('download') !!}Pakua CSV</a></div>
<div class="cards4 rise" style="margin-bottom:14px">
  <div class="card stat"><div class="hd"><b>Matukio leo</b></div><div class="big">{{ number_format($stats['today']) }}</div></div>
  <div class="card stat"><div class="hd"><b>Walioingia (saa 24)</b></div><div class="big">{{ number_format($stats['logins']) }}</div></div>
  <div class="card stat"><div class="hd"><b>Kuingia kulikoshindwa (saa 24)</b></div><div class="big" @if($stats['failed']>4) style="color:var(--red,#E60000)" @endif>{{ number_format($stats['failed']) }}</div></div>
  <div class="card stat"><div class="hd"><b>Watumiaji hai (saa 24)</b></div><div class="big">{{ number_format($stats['users']) }}</div></div>
</div>
<form class="tools rise" method="GET" action="{{ route('admin.audit') }}">
  <input type="search" name="q" value="{{ $f['q'] ?? '' }}" placeholder="Tafuta maelezo, mtumiaji au IP…" aria-label="Tafuta">
  <select name="action" onchange="this.form.submit()"><option value="">Vitendo vyote</option>@foreach(A::ACTIONS as $k=>$v)<option value="{{ $k }}" @selected(($f['action'] ?? '')===$k)>{{ $v }}</option>@endforeach</select>
  <select name="type" onchange="this.form.submit()"><option value="">Aina zote</option>@foreach($types as $t)<option value="{{ $t }}" @selected(($f['type'] ?? '')===$t)>{{ $t }}</option>@endforeach</select>
  <select name="user" onchange="this.form.submit()"><option value="">Watumiaji wote</option>@foreach($people as $p)<option value="{{ $p->user_id }}" @selected(($f['user'] ?? '')==$p->user_id)>{{ $p->user_name }}</option>@endforeach</select>
  <input type="date" name="from" value="{{ $f['from'] ?? '' }}" aria-label="Kuanzia" onchange="this.form.submit()">
  <input type="date" name="to" value="{{ $f['to'] ?? '' }}" aria-label="Hadi" onchange="this.form.submit()">
  @if(array_filter(\Illuminate\Support\Arr::only($f, ['q','action','type','user','from','to'])))<a class="btn sec" href="{{ route('admin.audit') }}">Futa vichujio</a>@endif
</form>
<div class="card rise">
@if($rows->isEmpty())<div class="empty"><b>Hakuna matukio.</b><br>Shughuli zitaonekana hapa kadri watumiaji wanavyotumia mfumo.</div>
@else
<div class="tw"><table><thead><tr><th>Wakati</th><th>Mtumiaji</th><th>Kitendo</th><th>Maelezo</th><th>IP</th><th></th></tr></thead><tbody>
@foreach($rows as $l)
  <tr><td style="white-space:nowrap" title="{{ $l->created_at }}">{{ $l->created_at->format('d M Y') }}<div class="s">{{ $l->created_at->format('H:i:s') }}</div></td>
    <td><div class="cell"><span class="mini">{{ strtoupper(mb_substr($l->user_name ?: '?',0,1)) }}</span><div><div class="t">{{ $l->user_name ?: 'Mgeni' }}</div><div class="s">{{ $l->user_role ?: '—' }}</div></div></div></td>
    <td><span class="bdg {{ A::TONE[$l->action] ?? '' }}">{{ A::ACTIONS[$l->action] ?? $l->action }}</span></td>
    <td style="max-width:380px">{{ $l->description }}@if($l->subject_type)<div class="s">{{ $l->subject_type }}@if($l->subject_id) · #{{ $l->subject_id }}@endif</div>@endif</td>
    <td style="white-space:nowrap"><span class="s">{{ $l->ip ?: '—' }}</span></td>
    <td><div class="act"><button class="btn sm sec" data-modal="{{ route('admin.audit.show', $l->id) }}">{!! Icons::svg('eye','sm') !!}Angalia</button></div></td></tr>
@endforeach
</tbody></table></div>
@if($rows->hasPages())<div class="pgn">@foreach($rows->getUrlRange(max(1,$rows->currentPage()-3), min($rows->lastPage(),$rows->currentPage()+3)) as $p => $url)@if($p==$rows->currentPage())<span class="on">{{ $p }}</span>@else<a href="{{ $url }}">{{ $p }}</a>@endif @endforeach</div>@endif
@endif
</div>
@endsection
