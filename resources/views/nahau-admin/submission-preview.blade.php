@php
  $hero = $s->section === 'african-heroes'; $isPdf = $s->file_path && strtolower(pathinfo($s->file_path, PATHINFO_EXTENSION)) === 'pdf';
  $done = in_array($s->status, ['accepted', 'declined'], true);
@endphp
<div class="mh"><h3>{{ $s->title }}</h3><a class="btn sm sec" href="{{ route('admin.nahau.index', 'submissions') }}">Rudi kwenye orodha</a></div>
<div class="mb" style="display:block">
  <p class="sub-t">{{ $s->reference }} · {{ $s->name }} &lt;{{ $s->email }}&gt; · {{ $s->section }} · {{ $s->language }} · {{ $s->created_at?->format('d M Y') }} · <b>{{ str_replace('_', ' ', $s->status) }}</b></p>
  @if($s->summary)<p><b>Muhtasari:</b> {{ $s->summary }}</p>@endif
  @if(trim((string) $s->body) !== '')<div style="white-space:normal;line-height:1.7;border:1px solid var(--bd);border-radius:8px;padding:16px;max-height:55vh;overflow:auto">{!! nl2br(e($s->body)) !!}</div>@endif
  @if($s->file_path)
    @if($isPdf)<object data="{{ route('admin.nahau.submission.file', $s->id) }}" type="application/pdf" style="width:100%;height:60vh;margin-top:12px"></object>@endif
    <p style="margin-top:8px"><a class="btn sm sec" target="_blank" href="{{ route('admin.nahau.submission.file', $s->id) }}">{{ $isPdf ? 'Fungua PDF' : 'Pakua faili (Word)' }}</a></p>
  @endif
  @if($s->hero_id)<p class="note">Imechapishwa kama hero: <a href="{{ route('admin.nahau.index', 'heroes') }}">Hero profiles</a></p>@endif
</div>
@if(!$done || $s->hero_id === null)
<form method="post" action="{{ route('admin.nahau.submission.decide', $s->id) }}" class="mf" style="flex-wrap:wrap;gap:10px">@csrf
  <div class="f" style="flex:1;min-width:240px"><label for="dn">Ujumbe kwa mwandishi (hiari)</label><input id="dn" name="note" maxlength="1000" value="{{ $s->notes }}" placeholder="Mfano: Asante, hadithi yako imepokelewa"></div>
  <button class="btn dng" name="action" value="reject" type="submit" data-busy>Kataa (Reject)</button>
  @if($hero && !$s->hero_id)<button class="btn" name="action" value="publish" type="submit" data-busy>Chapisha kama Hero (Publish)</button>@endif
</form>
@endif
