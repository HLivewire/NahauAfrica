@php $ini = strtoupper(mb_substr($u->first_name ?? 'A',0,1).mb_substr($u->last_name ?? '',0,1)); @endphp
<div class="mh" data-w="560px"><h3>Wasifu wangu</h3><button type="button" class="x" data-close aria-label="Funga">{!! \App\Nahau\Icons::svg('x','sm') !!}</button></div>
<form data-ajax style="display:contents" method="POST" action="{{ route('admin.panel.profile.save') }}" data-ok="Wasifu umehifadhiwa">
@csrf
<div class="mb">
  <div style="display:flex;gap:16px;align-items:center"><span class="av lgv">{{ $ini }}</span><div><b style="font-size:17px">{{ trim($u->first_name.' '.$u->last_name) }}</b><div class="note">{{ \App\Nahau\Panel::roleName($u) }}</div></div></div>
  <div class="row2">
    <div class="f"><label for="pf1">Jina la kwanza</label><input id="pf1" name="first_name" value="{{ $u->first_name }}" required><span class="err" data-err="first_name"></span></div>
    <div class="f"><label for="pf1b">Jina la mwisho</label><input id="pf1b" name="last_name" value="{{ $u->last_name }}"><span class="err" data-err="last_name"></span></div>
  </div>
  <div class="row2">
    <div class="f"><label for="pf2">Barua pepe</label><input id="pf2" name="email" type="email" value="{{ $u->email }}" required><span class="err" data-err="email"></span></div>
    <div class="f"><label for="pf3">Simu</label><input id="pf3" name="phone" value="{{ $u->phone }}"><span class="err" data-err="phone"></span></div>
  </div>
</div>
<div class="mf"><button type="button" class="btn sec" data-modal="{{ route('admin.panel.password') }}">Badilisha nenosiri</button><div class="sp"></div><button class="btn" type="submit">Hifadhi</button></div>
</form>
