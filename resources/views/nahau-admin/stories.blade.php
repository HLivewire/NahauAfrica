@extends('nahau-admin.layout')
@section('title', 'Hadithi zote')
@section('content')
@php use App\Nahau\Icons; use Illuminate\Support\Str; $L = \App\Nahau\Panel::letter(); $pub = in_array($L, ['A','E'], true); @endphp
<div class="ph rise"><div><h2>Hadithi zote</h2><p>{{ $rows->total() }} {{ $rows->total() === 1 ? 'hadithi' : 'hadithi' }}</p></div><div class="sp"></div>
  <button class="btn" data-modal="{{ route('admin.stories.create') }}">{!! Icons::svg('plus') !!}Hadithi mpya</button></div>
<form class="tools rise" method="GET" action="{{ route('admin.stories') }}">
  <input type="search" name="q" value="{{ $f['q'] ?? '' }}" placeholder="Tafuta kichwa…" aria-label="Tafuta">
  <select name="section" onchange="this.form.submit()"><option value="">Sehemu zote</option>@foreach($sections as $k=>$v)<option value="{{ $k }}" @selected(($f['section'] ?? '')===$k)>{{ $v }}</option>@endforeach</select>
  <select name="lang" onchange="this.form.submit()"><option value="">Lugha zote</option><option value="sw" @selected(($f['lang'] ?? '')==='sw')>Kiswahili</option><option value="en" @selected(($f['lang'] ?? '')==='en')>English</option></select>
  <select name="status" onchange="this.form.submit()"><option value="">Hali zote</option><option value="1" @selected(($f['status'] ?? '')==='1')>Published</option><option value="0" @selected(($f['status'] ?? '')==='0')>Draft</option></select>
</form>
<div class="card rise">
@if($rows->isEmpty())<div class="empty"><b>Hakuna hadithi bado.</b><br>Bofya <b>Hadithi mpya</b> kuanza.</div>
@else
<div class="tw"><table><thead><tr><th>Hadithi</th><th>Sehemu</th><th>Lugha</th><th>Mwandishi</th><th>Hali</th><th>Tarehe</th><th>Views</th><th></th></tr></thead><tbody>
@foreach($rows as $r)
  @php $img = nimage($r); @endphp
  <tr><td><div class="cell">@if($img)<img src="{{ $img }}" alt="" style="width:40px;height:40px;border-radius:6px;object-fit:cover;flex:none">@else<span class="thumb">{{ strtoupper(mb_substr($r->title,0,1)) }}</span>@endif<div><div class="t">{{ Str::limit($r->title, 54) }}</div>@if($r->featured)<span class="bdg ok">Featured</span>@endif</div></div></td>
    <td>{{ $r->section }}</td>
    <td>@if($r->language)<span class="bdg {{ $r->language==='sw'?'sw':'en' }}">{{ $r->language==='sw'?'Kiswahili':'English' }}</span>@else<span style="color:var(--mut2)">—</span>@endif</td>
    <td>{{ $r->author_name ?: '—' }}</td>
    <td><span class="bdg {{ $r->status ? 'ok' : '' }}">{{ $r->status ? 'Published' : 'Draft' }}</span></td>
    <td>{{ \Illuminate\Support\Carbon::parse($r->date)->format('d M Y') }}</td><td>{{ number_format($r->viewers) }}</td>
    <td><div class="act"><button class="btn sm sec" data-modal="{{ route('admin.stories.edit', $r->id) }}">{!! Icons::svg('edit','sm') !!}Hariri</button>
      @if($pub)<button class="btn sm dng ico" aria-label="Futa" data-del="{{ route('admin.stories.destroy', $r->id) }}" data-name="{{ Str::limit($r->title, 40) }}">{!! Icons::svg('trash','sm') !!}</button>@endif</div></td></tr>
@endforeach
</tbody></table></div>
@if($rows->hasPages())<div class="pgn">@foreach($rows->getUrlRange(1,$rows->lastPage()) as $p => $url)@if($p==$rows->currentPage())<span class="on">{{ $p }}</span>@else<a href="{{ $url }}">{{ $p }}</a>@endif @endforeach</div>@endif
@endif
</div>
@endsection
