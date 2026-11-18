@extends('nahau-account.layout')
@section('title', $s->title)
@section('content')
@php
  $tag = ['new' => 'Imetumwa', 'under_review' => 'Inapitiwa', 'revisions' => 'Marekebisho', 'accepted' => 'Imekubaliwa', 'declined' => 'Haijakubaliwa'];
  $isPdf = $s->file_path && strtolower(pathinfo($s->file_path, PATHINFO_EXTENSION)) === 'pdf';
@endphp
<div class="ph rise"><div><h2>{{ $s->title }}</h2><p>{{ $s->reference }} · {{ nsection($s->section, 'name') ?: $s->section }} · {{ $s->language }} · {{ $s->created_at?->format('d M Y') }}</p></div><div class="sp"></div>
  <a class="btn sec" href="{{ route('account.mine') }}">Rudi kwenye Hadithi zangu</a>@if($live)<a class="btn" href="{{ $live }}">Tazama kwenye site</a>@endif</div>
<div class="card rise" style="margin-bottom:14px">
  <span class="tag {{ $s->status === 'accepted' ? 'g' : 'o' }}">{{ $tag[$s->status] ?? $s->status }}</span>
  @if($s->status === 'accepted')<p style="margin:10px 0 0">Hongera! Hadithi yako imekubaliwa{{ $live ? ' na sasa inaonekana kwenye site.' : '.' }}</p>@endif
  @if($s->status === 'declined')<p style="margin:10px 0 0">Samahani, hadithi hii haijakubaliwa kwa sasa. Unaweza kutuma nyingine wakati wowote.</p>@endif
  @if($s->notes && in_array($s->status, ['revisions', 'declined', 'accepted'], true))<p class="sub-t" style="margin-top:8px"><b>Maelezo ya mhariri:</b> {{ $s->notes }}</p>@endif
</div>
<div class="card rise">
  <h4>Ulichotuma</h4>
  @if($s->summary)<p class="sub-t">{{ $s->summary }}</p>@endif
  @if(trim((string) $s->body) !== '')<div style="line-height:1.75;max-height:60vh;overflow:auto;border-top:1px solid var(--bd);padding-top:12px;margin-top:10px">{!! nl2br(e($s->body)) !!}</div>@endif
  @if($s->file_path)
    @if($isPdf)<object data="{{ route('account.submission.file', $s->id) }}" type="application/pdf" style="width:100%;height:60vh;margin-top:12px"></object>@endif
    <p style="margin-top:10px"><a class="btn sm sec" target="_blank" href="{{ route('account.submission.file', $s->id) }}">{{ $isPdf ? 'Fungua PDF' : 'Pakua faili ulilotuma' }}</a></p>
  @endif
</div>
@endsection
