@php use App\Nahau\Icons; use App\Models\ActivityLog as A; @endphp
<div class="mh" data-w="680px"><h3>Tukio #{{ $l->id }}</h3><button type="button" class="x" data-close aria-label="Funga">{!! Icons::svg('x','sm') !!}</button></div>
<div class="mb">
  <dl class="dl">
    <dt>Wakati</dt><dd>{{ $l->created_at->format('d M Y, H:i:s') }}</dd>
    <dt>Mtumiaji</dt><dd>{{ $l->user_name ?: 'Mgeni' }}@if($l->user_role) · {{ $l->user_role }}@endif</dd>
    <dt>Kitendo</dt><dd><span class="bdg {{ A::TONE[$l->action] ?? '' }}">{{ A::ACTIONS[$l->action] ?? $l->action }}</span></dd>
    <dt>Maelezo</dt><dd>{{ $l->description }}</dd>
    @if($l->subject_type)<dt>Kilichoguswa</dt><dd>{{ $l->subject_type }}@if($l->subject_label) · {{ $l->subject_label }}@endif @if($l->subject_id)(#{{ $l->subject_id }})@endif</dd>@endif
    <dt>IP</dt><dd>{{ $l->ip ?: '—' }}</dd>
    <dt>Ombi</dt><dd>{{ $l->method }} {{ $l->url }}</dd>
    <dt>Kifaa</dt><dd style="word-break:break-word">{{ $l->user_agent ?: '—' }}</dd>
  </dl>
  @if(!empty($l->changes))
  <h4 style="margin:14px 0 6px">Mabadiliko</h4>
  <div class="tw"><table><thead><tr><th>Sehemu</th><th>Kabla</th><th>Baada</th></tr></thead><tbody>
  @foreach($l->changes as $k => $v)
    <tr><td><b>{{ $k }}</b></td><td style="word-break:break-word;max-width:240px">{{ is_array($v) ? ($v[0] ?? '—') : '—' }}</td><td style="word-break:break-word;max-width:240px">{{ is_array($v) ? ($v[1] ?? '—') : $v }}</td></tr>
  @endforeach
  </tbody></table></div>
  @endif
</div>
<div class="mf"><button type="button" class="btn sec" data-close>Funga</button></div>
