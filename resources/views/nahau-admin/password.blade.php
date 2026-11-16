<div class="mh" data-w="480px"><h3>Badilisha nenosiri</h3>@unless($forced ?? false)<button type="button" class="x" data-close aria-label="Funga">{!! \App\Nahau\Icons::svg('x','sm') !!}</button>@endunless</div>
<form data-ajax style="display:contents" method="POST" action="{{ route('admin.panel.password.save') }}" data-ok="Nenosiri limebadilishwa">
@csrf
<div class="mb">
  @if($forced ?? false)<div class="forcepw">Kwa usalama, weka nenosiri jipya kabla ya kuendelea.</div>@endif
  <div class="f"><label for="p1">Nenosiri la sasa</label><input id="p1" name="current_password" type="password" autocomplete="current-password" required><span class="err" data-err="current_password"></span></div>
  <div class="f"><label for="p2">Nenosiri jipya</label><input id="p2" name="password" type="password" autocomplete="new-password" required><small>Angalau herufi 10, na namba moja</small><span class="err" data-err="password"></span></div>
  <div class="f"><label for="p3">Thibitisha nenosiri jipya</label><input id="p3" name="password_confirmation" type="password" autocomplete="new-password" required></div>
</div>
<div class="mf"><div class="sp"></div><button class="btn" type="submit">Hifadhi nenosiri</button></div>
</form>
