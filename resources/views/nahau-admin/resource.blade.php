@extends('nahau-admin.layout')
@section('title', $d['title'])
@section('content')
@php use App\Nahau\Icons; use Illuminate\Support\Str;
 $boolCols = ['featured','show_on_home','show_in_spotlight'];
 $tone = ['published'=>'ok','listed'=>'ok','accepted'=>'ok','answered'=>'ok','new'=>'in','under_review'=>'wr','verifying'=>'wr','revisions'=>'wr','draft'=>'','hidden'=>'','closed'=>'','declined'=>'er'];
@endphp
<div class="ph rise"><div><h2>{{ $d['title'] }}</h2><p>{{ $rows->total() }} {{ $rows->total() === 1 ? 'kipengee' : 'vipengee' }}</p></div><div class="sp"></div>
  <div class="tools"><input type="search" id="tf" placeholder="Chuja orodha…" aria-label="Chuja">@if($d['create'])<button class="btn" data-modal="{{ route('admin.nahau.create', $res) }}">{!! Icons::svg('plus') !!}Ongeza</button>@endif</div></div>
<div class="card rise">
@if($rows->isEmpty())
  <div class="empty"><b>Bado hakuna kitu hapa.</b><br>@if($d['create'])Bofya <b>Ongeza</b> kuanza.@else Vitu vitaonekana hapa vikifika kutoka kwenye site.@endif</div>
@else
<div class="tw"><table id="tt"><thead><tr>@if($res==='stories')<th>Hadithi</th>@endif @foreach($d['cols'] as $c)<th>{{ ucfirst(str_replace('_',' ',$c)) }}</th>@endforeach<th></th></tr></thead><tbody>
@foreach($rows as $r)
  <tr>@if($res==='stories')<td><div class="t">{{ Str::limit($r->news_title, 50) }}</div></td>@endif
  @foreach($d['cols'] as $c)
    @php $v = $r->$c; @endphp
    <td>@if(in_array($c,$boolCols,true))@if($v)<span class="bdg ok">Ndiyo</span>@else<span class="n" style="color:var(--mut2)">—</span>@endif
      @elseif($c==='language')<span class="bdg {{ $v==='sw'?'sw':'en' }}">{{ $v==='sw'?'Kiswahili':'English' }}</span>
      @elseif($c==='status')<span class="bdg {{ $tone[$v] ?? '' }}">{{ str_replace('_',' ',$v) }}</span>
      @elseif($v instanceof \Carbon\CarbonInterface){{ $v->format('d M Y') }}
      @else{{ Str::limit((string) $v, 60) }}@endif</td>
  @endforeach
  <td><div class="act">
    @if($d['edit'])<button class="btn sm {{ $d['create'] ? 'sec' : 'soft' }}" data-modal="{{ route('admin.nahau.edit', [$res, $r->id]) }}">{!! Icons::svg($d['create'] ? 'edit' : 'eye','sm') !!}{{ $d['create'] ? 'Hariri' : 'Fungua' }}</button>@endif
    @if($res!=='stories' && ($d['edit'] !== false || $res==='subscribers'))<button class="btn sm dng ico" aria-label="Futa" data-del="{{ route('admin.nahau.destroy', [$res, $r->id]) }}" data-name="{{ Str::limit((string) ($r->title ?? $r->name ?? $r->email ?? '#'.$r->id), 40) }}">{!! Icons::svg('trash','sm') !!}</button>@endif
  </div></td></tr>
@endforeach
</tbody></table></div>
@if($rows->hasPages())<div class="pgn">@foreach($rows->getUrlRange(1,$rows->lastPage()) as $p => $url)@if($p==$rows->currentPage())<span class="on">{{ $p }}</span>@else<a href="{{ $url }}">{{ $p }}</a>@endif @endforeach</div>@endif
@endif
</div>
@endsection
@push('scripts')
<script>(function(){var f=document.getElementById('tf'),t=document.getElementById('tt');if(!f||!t)return;f.addEventListener('input',function(){var q=f.value.toLowerCase();t.querySelectorAll('tbody tr').forEach(function(r){r.style.display=r.textContent.toLowerCase().indexOf(q)>-1?'':'none'})})})();</script>
@endpush
