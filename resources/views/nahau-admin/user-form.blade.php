@php $edit = (bool) $row; @endphp
<div class="mh" data-w="520px"><h3>{{ $edit ? 'Badilisha role: '.trim($row->first_name.' '.$row->last_name) : 'Alika mtumiaji' }}</h3><button type="button" class="x" data-close aria-label="Funga">{!! \App\Nahau\Icons::svg('x','sm') !!}</button></div>
<form data-ajax style="display:contents" method="POST" action="{{ $edit ? route('admin.panel.users.update', $row) : route('admin.panel.users.store') }}">
@csrf @if($edit) @method('PUT') @endif
<div class="mb">
  @unless($edit)
  <div class="row2">
    <div class="f"><label for="u1">Jina la kwanza</label><input id="u1" name="first_name" required><span class="err" data-err="first_name"></span></div>
    <div class="f"><label for="u2">Jina la mwisho</label><input id="u2" name="last_name"><span class="err" data-err="last_name"></span></div>
  </div>
  <div class="f"><label for="u3">Barua pepe</label><input id="u3" name="email" type="email" placeholder="jina@example.com" required><span class="err" data-err="email"></span></div>
  @endunless
  <div class="f"><label for="u4">Role</label>
    <select id="u4" name="role">@php $cur = $edit ? (\App\Nahau\Panel::letter($row) === 'A' ? 'admin' : ($row->roles->first()->slug ?? 'contributor')) : 'editor'; if ($cur === 'reporter') $cur = 'contributor'; @endphp
      @foreach($roles as $k => $v)<option value="{{ $k }}" @selected($cur === $k)>{{ $v }}</option>@endforeach</select>
    <span class="err" data-err="role"></span></div>
  @if($edit)<label class="ck"><input type="checkbox" name="is_active" value="1" @checked($row->is_active)> Akaunti iko hai (anaweza kuingia)</label>@endif
  <p class="note">Administrator ndiye pekee anayeweza kuongeza watumiaji na kuwapa role. Administrator wa mwisho hawezi kushushwa wala kufutwa.@unless($edit) Mtumiaji mpya atapewa nenosiri la muda atakalolazimika kulibadilisha.@endunless</p>
</div>
<div class="mf"><div class="sp"></div><button class="btn" type="submit">{{ $edit ? 'Hifadhi' : 'Tengeneza akaunti' }}</button></div>
</form>
