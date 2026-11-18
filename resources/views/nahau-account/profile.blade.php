@extends('nahau-account.layout')
@section('title', 'Wasifu')
@section('content')
<div class="ph rise"><div><h2>Wasifu</h2><p>Maelezo yako, lengo la kusoma na nenosiri.</p></div></div>
<form class="card rise" method="post" action="{{ route('account.profile.save') }}" style="margin-bottom:20px">@csrf
  <div class="rform">
    <div><label for="fn">Jina la kwanza</label><input id="fn" name="first_name" value="{{ old('first_name', $u->first_name) }}" required>@error('first_name')<div class="err">{{ $message }}</div>@enderror</div>
    <div><label for="ln">Jina la mwisho</label><input id="ln" name="last_name" value="{{ old('last_name', $u->last_name) }}"></div>
    <div><label for="em">Barua pepe</label><input id="em" value="{{ $u->email }}" disabled></div>
    <div><label for="ph">Simu</label><input id="ph" name="phone" value="{{ old('phone', $u->phone) }}"></div>
    <div><label for="lg">Lugha ya kusoma</label><select id="lg" name="lang"><option value="sw" @selected(($u->lang ?? 'sw') === 'sw')>Kiswahili</option><option value="en" @selected(($u->lang ?? 'sw') === 'en')>English</option></select></div>
    <div><label for="gl">Lengo: hadithi kwa mwezi</label><input id="gl" type="number" min="1" max="60" name="reading_goal" value="{{ old('reading_goal', $u->reading_goal ?: 6) }}" required></div>
  </div>
  <div style="margin-top:16px"><button class="btn" type="submit">Hifadhi</button></div>
</form>
<form class="card rise" method="post" action="{{ route('account.password') }}">@csrf
  <h4 style="margin-bottom:12px">Badilisha nenosiri</h4>
  <div class="rform">
    <div class="full"><label for="cp">Nenosiri la sasa</label><input id="cp" type="password" name="current" required autocomplete="current-password">@error('current')<div class="err">{{ $message }}</div>@enderror</div>
    <div><label for="np">Nenosiri jipya</label><input id="np" type="password" name="password" minlength="8" required autocomplete="new-password">@error('password')<div class="err">{{ $message }}</div>@enderror</div>
    <div><label for="np2">Rudia nenosiri jipya</label><input id="np2" type="password" name="password_confirmation" required autocomplete="new-password"></div>
  </div>
  <div style="margin-top:16px"><button class="btn" type="submit">Badilisha nenosiri</button></div>
</form>
@endsection
