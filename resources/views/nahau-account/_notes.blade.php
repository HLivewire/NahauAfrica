@php use App\Nahau\Icons; @endphp
@forelse($list as $n)
<a class="nrow2{{ $n['unread'] ? ' un' : '' }}" href="{{ $n['url'] }}"><span class="ni2 t-{{ $n['type'] }}">{!! Icons::svg($n['icon'], 'sm') !!}</span><div style="min-width:0;flex:1"><b>{{ $n['title'] }}</b><span>{{ $n['body'] }}</span><small>{{ $n['label'] }} · {{ $n['at']->locale('sw')->diffForHumans() }}</small></div></a>
@empty
<div class="empty">Hakuna arifa bado. Hadithi mpya, kazi na fursa zitaonekana hapa.</div>
@endforelse
