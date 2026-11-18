@php use App\Nahau\Icons; $edit = $row->exists; $wide = ['textarea','image','checkbox','radio','swatch']; @endphp
<div class="mh" data-w="{{ count($d['fields']) > 6 ? '800px' : '600px' }}"><h3>{{ $d['title'] }} · {{ $edit ? ($d['create'] ? 'Hariri' : 'Fungua') : 'Mpya' }}</h3><button type="button" class="x" data-close aria-label="Funga">{!! Icons::svg('x','sm') !!}</button></div>
<form data-ajax style="display:contents" method="POST" enctype="multipart/form-data" action="{{ $edit ? route('admin.nahau.update', [$res, $row->id]) : route('admin.nahau.store', $res) }}">
@csrf @if($edit) @method('PUT') @endif
<div class="mb">
  @if(!empty($d['show']) && $edit)
    <dl class="dl">@foreach($d['show'] as $k)<dt>{{ ucfirst(str_replace('_',' ',$k)) }}</dt><dd>{{ is_bool($row->$k) || in_array($k,['original','consent','published_before']) ? ($row->$k ? 'Ndiyo' : 'Hapana') : $row->$k }}</dd>@endforeach
    @if($res==='submissions' && $row->file_path)<dt>File</dt><dd>{{ basename($row->file_path) }} (limehifadhiwa privately)</dd>@endif</dl>
    <hr style="border:0;border-top:1px solid var(--bd);width:100%">
  @endif
  @if($res==='opportunities')<div class="alert-soft">Fursa haichapishwi hadi <b>Verified by</b> na <b>Verified on</b> zijazwe. @if($edit)Ripoti za tangazo hili: {{ $row->reports()->count() }}.@endif</div>@endif
  @if($res==='carousel')<div class="alert-soft">Chagua Hero au Book; sehemu zinazohusika zitatokea. Muda ni siku 4 au zaidi; siku 2 kabla ya kuisha utapata arifa.</div>@endif
  @if($res==='stories')<p class="note">Hadithi: <b>{{ \App\Models\News::find($row->news_id)?->title }}</b></p>@endif
  @php
    $tabs = $d['tabs'] ?? null; $byName = collect($d['fields'])->keyBy(0);
    $groups = $tabs ?: ['_' => $byName->keys()->all()];
    $tall = ['body_en','body_sw','corrections','sources','about','responsibilities','qualifications','benefits','apply_notes','employer_about'];
  @endphp
  @if($tabs)<div class="tabs">@foreach(array_keys($tabs) as $i => $tn)<button type="button" data-tab="t{{ $i }}" aria-selected="{{ $i === 0 ? 'true' : 'false' }}">{{ $tn }}</button>@endforeach</div>@endif
  @foreach($groups as $gi => $names)
  <div class="pane" @if($tabs) data-pane="t{{ $loop->index }}" @if(!$loop->first) style="display:none" @endif @endif>
  <div class="fg">
  @foreach($names as $nm)
    @php $f = $byName[$nm]; [$name,$label,$type] = $f; $val = old($name, $row->$name); $hint = $f[5] ?? null; $dep = $f[6] ?? null; @endphp
    <div class="f {{ in_array($type,$wide,true) ? 'full' : '' }}" @if($dep) data-dep="{{ $dep }}" @endif>
      @if($type==='checkbox')
        <label class="ck"><input type="checkbox" name="{{ $name }}" value="1" @checked($val)> {{ $label }}</label>
      @elseif($type==='swatch')
        <label>{{ $label }}</label>
        <div class="swatches">@foreach(($f[4])() as $k=>$v)<label class="sw sw-{{ $k }}"><input type="radio" name="{{ $name }}" value="{{ $k }}" @checked(($val ?: 'dark') === $k)><i></i><span>{{ $v }}</span></label>@endforeach</div>
      @elseif($type==='radio')
        <label>{{ $label }}</label>
        <div class="seg2">@foreach(($f[4])() as $k=>$v)<label class="rd"><input type="radio" name="{{ $name }}" value="{{ $k }}" @checked((string)(int)$val === (string)$k)> {{ $v }}</label>@endforeach</div>
      @else
        <label for="f-{{ $name }}">{{ $label }}</label>
        @if($type==='textarea')<textarea id="f-{{ $name }}" name="{{ $name }}" rows="{{ in_array($name,$tall) ? 7 : 4 }}">{{ $val }}</textarea>
        @elseif($type==='select')<select id="f-{{ $name }}" name="{{ $name }}"><option value="">—</option>@foreach(($f[4])() as $k=>$v)<option value="{{ $k }}" @selected((string)$val === (string)$k)>{{ $v }}</option>@endforeach</select>
        @elseif($type==='image')<input type="file" id="f-{{ $name }}" name="{{ $name }}" accept="image/*" data-preview="pv-{{ $name }}"><img class="prev" id="pv-{{ $name }}" src="{{ $val ? media_url($val) : '' }}" alt="" style="{{ $val ? '' : 'display:none' }}">
        @else<input id="f-{{ $name }}" name="{{ $name }}" type="{{ $type==='number'?'number':($type==='date'?'date':'text') }}" value="{{ $type==='date' && $val ? \Illuminate\Support\Carbon::parse($val)->toDateString() : $val }}">
        @endif
      @endif
      @if($hint)<small>{{ $hint }}</small>@endif
      @if($name==='spotlight_summary')<small class="cnt" data-count-for="f-{{ $name }}" data-max="320"></small>@endif
      <span class="err" data-err="{{ $name }}"></span>
    </div>
  @endforeach
  </div>
  </div>
  @endforeach
</div>
<div class="mf">
  @if($res==='opportunity-submissions' && $edit)<button type="button" class="btn sec" data-modal="{{ route('admin.nahau.create','opportunities') }}?from={{ $row->id }}">Tengeneza fursa kutoka kwa hii</button>@endif
  <div class="sp"></div><button type="button" class="btn sec" data-close>Funga</button>
  @if(count($d['fields']))<button class="btn" type="submit">Hifadhi</button>@endif
</div>
</form>
