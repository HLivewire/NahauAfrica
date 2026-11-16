@php use App\Nahau\Icons; $edit = (bool) $news; $img = $edit ? nimage($news) : null; @endphp
<div class="mh" data-w="800px"><h3>{{ $edit ? 'Hariri hadithi' : 'Hadithi mpya' }}</h3><button type="button" class="x" data-close aria-label="Funga">{!! Icons::svg('x','sm') !!}</button></div>
<form data-ajax style="display:contents" method="POST" enctype="multipart/form-data" action="{{ $edit ? route('admin.stories.update', $news->id) : route('admin.stories.store') }}">
@csrf @if($edit) @method('PUT') @endif
<div class="mb">
  <div class="tabs"><button type="button" data-tab="a" aria-selected="true">Maelezo</button><button type="button" data-tab="b" aria-selected="false">Maandishi</button><button type="button" data-tab="c" aria-selected="false">Zaidi</button></div>

  <div class="pane" data-pane="a">
    <div class="f"><label for="s1">Kichwa</label><input id="s1" name="title" value="{{ $news->title ?? '' }}" required><span class="err" data-err="title"></span></div>
    <div class="fg">
      <div class="f"><label for="s2">Lugha ya hadithi</label><select id="s2" name="language"><option value="sw" @selected(($meta->language ?? 'sw')==='sw')>Kiswahili</option><option value="en" @selected(($meta->language ?? '')==='en')>English</option></select><small>Lebo hii inaonekana kwa msomaji</small><span class="err" data-err="language"></span></div>
      <div class="f"><label for="s3">Sehemu</label><select id="s3" name="section">@foreach($sections as $k=>$v)<option value="{{ $k }}" @selected($section===$k)>{{ $v }}</option>@endforeach</select><span class="err" data-err="section"></span></div>
      <div class="f"><label for="s4">Aina ya maudhui</label><select id="s4" name="label">@foreach($labels as $k=>$v)<option value="{{ $k }}" @selected(($meta->label ?? '')===$k)>{{ $v }}</option>@endforeach</select><span class="err" data-err="label"></span></div>
      <div class="f"><label for="s5">Mwandishi</label><select id="s5" name="author_id"><option value="">—</option>@foreach($authors as $k=>$v)<option value="{{ $k }}" @selected((string)($meta->author_id ?? '')===(string)$k)>{{ $v }}</option>@endforeach</select></div>
      <div class="f"><label for="s6">Tarehe</label><input id="s6" type="date" name="date" value="{{ $edit ? \Illuminate\Support\Carbon::parse($news->date)->toDateString() : now()->toDateString() }}" required><span class="err" data-err="date"></span></div>
      <div class="f"><label for="s7">Hali</label><select id="s7" name="status" @disabled(!$canPublish)><option value="0" @selected(!($news->status ?? 0))>Draft</option><option value="1" @selected(($news->status ?? 0)==1)>Published</option></select>@unless($canPublish)<small>Draft tu. Mhariri ndiye anachapisha.</small>@endunless</div>
    </div>
    <div class="f"><label for="s8">Picha ya jalada</label>@if($img)<img class="prev" src="{{ $img }}" alt="">@endif<input id="s8" type="file" name="image" accept="image/*"><small>Ukubwa unaopendekezwa 1600×900, si zaidi ya 4MB</small><span class="err" data-err="image"></span></div>
  </div>

  <div class="pane" data-pane="b" style="display:none">
    <div class="f"><label for="b1">Muhtasari (mstari mmoja hadi miwili)</label><textarea id="b1" name="summary" rows="3" maxlength="255" required>{{ $news->summary ?? '' }}</textarea><span class="err" data-err="summary"></span></div>
    <div class="f"><label for="b2">Maandishi ya hadithi</label><textarea id="b2" name="description" rows="14" style="min-height:260px" required>{{ $news->description ?? '' }}</textarea><small>Muda wa kusoma: <b id="rt">0 dakika</b> (unahesabiwa kutoka maneno). Unaweza kutumia HTML rahisi kama &lt;p&gt; na &lt;h3&gt;.</small><span class="err" data-err="description"></span></div>
  </div>

  <div class="pane" data-pane="c" style="display:none">
    <div class="fg">
      <div class="f"><label for="c1">Tags</label><input id="c1" name="tags" value="{{ $news->tags ?? '' }}" maxlength="50"></div>
      <div class="f"><label for="c2">Format</label><input id="c2" name="format" value="{{ $meta->format ?? '' }}" placeholder="Short story, Interview…"></div>
      <div class="f"><label for="c3">Series</label><select id="c3" name="series_id"><option value="">—</option>@foreach($series as $k=>$v)<option value="{{ $k }}" @selected((string)($meta->series_id ?? '')===(string)$k)>{{ $v }}</option>@endforeach</select></div>
      <div class="f"><label for="c4">Sura namba</label><input id="c4" type="number" name="chapter_no" value="{{ $meta->chapter_no ?? '' }}"></div>
      <div class="f full"><label for="c5">Tafsiri ya hadithi nyingine (si lazima)</label><select id="c5" name="translation_of"><option value="">—</option>@foreach($others as $k=>$v)<option value="{{ $k }}" @selected((string)($meta->translation_of ?? '')===(string)$k)>{{ \Illuminate\Support\Str::limit($v, 70) }}</option>@endforeach</select></div>
      <div class="f full"><label for="c6">Maelezo ya Google (meta description)</label><textarea id="c6" name="meta_description" rows="2" maxlength="300">{{ $news->meta_description ?? '' }}</textarea></div>
      <div class="f"><label for="c7">Alt text ya picha</label><input id="c7" name="image_alt" value="{{ $meta->image_alt ?? '' }}"></div>
      <div class="f"><label for="c8">Maelezo ya picha</label><input id="c8" name="image_caption" value="{{ $meta->image_caption ?? '' }}"></div>
      <div class="f"><label for="c9">Mpiga picha / chanzo</label><input id="c9" name="image_credit" value="{{ $meta->image_credit ?? '' }}"></div>
      <div class="f"><label for="c10">Imedhaminiwa na</label><input id="c10" name="sponsored_by" value="{{ $meta->sponsored_by ?? '' }}"></div>
      <div class="f full"><label for="c11">Masahihisho (mstari mmoja: tarehe | maelezo)</label><textarea id="c11" name="corrections" rows="3">{{ $meta->corrections ?? '' }}</textarea></div>
      @if($canPublish)<label class="ck full"><input type="checkbox" name="featured" value="1" @checked($meta->featured ?? false)> Featured kwenye Home (hadithi moja tu)</label>@endif
      <label class="ck full"><input type="checkbox" name="consent_on_file" value="1" @checked($meta->consent_on_file ?? false)> Ridhaa ya mwandishi imehifadhiwa (siri)</label>
    </div>
  </div>
</div>
<div class="mf"><div class="sp"></div><button type="button" class="btn sec" data-close>Funga</button><button class="btn" type="submit">Hifadhi</button></div>
</form>
