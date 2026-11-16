@php use App\Nahau\Icons; $edit = $row->exists; $wide = ['textarea','image','checkbox']; @endphp
<div class="mh" data-w="{{ count($d['fields']) > 6 ? '760px' : '600px' }}"><h3>{{ $d['title'] }} · {{ $edit ? ($d['create'] ? 'Hariri' : 'Fungua') : 'Mpya' }}</h3><button type="button" class="x" data-close aria-label="Funga">{!! Icons::svg('x','sm') !!}</button></div>
<form data-ajax style="display:contents" method="POST" enctype="multipart/form-data" action="{{ $edit ? route('admin.nahau.update', [$res, $row->id]) : route('admin.nahau.store', $res) }}">
@csrf @if($edit) @method('PUT') @endif
<div class="mb">
  @if(!empty($d['show']) && $edit)
    <dl class="dl">@foreach($d['show'] as $k)<dt>{{ ucfirst(str_replace('_',' ',$k)) }}</dt><dd>{{ is_bool($row->$k) || in_array($k,['original','consent','published_before']) ? ($row->$k ? 'Ndiyo' : 'Hapana') : $row->$k }}</dd>@endforeach
    @if($res==='submissions' && $row->file_path)<dt>File</dt><dd>{{ basename($row->file_path) }} (limehifadhiwa privately)</dd>@endif</dl>
    <hr style="border:0;border-top:1px solid var(--bd);width:100%">
  @endif
  @if($res==='opportunities')<div class="alert-soft">Fursa haichapishwi hadi <b>Verified by</b> na <b>Verified on</b> zijazwe. @if($edit)Ripoti za tangazo hili: {{ $row->reports()->count() }}.@endif</div>@endif
  @if($res==='stories')<p class="note">Hadithi: <b>{{ \App\Models\News::find($row->news_id)?->title }}</b></p>@endif
  <div class="fg">
  @foreach($d['fields'] as $f)
    @php [$name,$label,$type] = $f; $val = old($name, $row->$name); @endphp
    <div class="f {{ in_array($type,$wide,true) ? 'full' : '' }}">
      @if($type==='checkbox')
        <label class="ck"><input type="checkbox" name="{{ $name }}" value="1" @checked($val)> {{ $label }}</label>
      @else
        <label for="f-{{ $name }}">{{ $label }}</label>
        @if($type==='textarea')<textarea id="f-{{ $name }}" name="{{ $name }}" rows="{{ in_array($name,['body_en','body_sw','corrections','sources']) ? 10 : 4 }}">{{ $val }}</textarea>
        @elseif($type==='select')<select id="f-{{ $name }}" name="{{ $name }}"><option value="">—</option>@foreach(($f[4])() as $k=>$v)<option value="{{ $k }}" @selected((string)$val === (string)$k)>{{ $v }}</option>@endforeach</select>
        @elseif($type==='image')@if($val)<img class="prev" src="{{ media_url($val) }}" alt="">@endif<input type="file" id="f-{{ $name }}" name="{{ $name }}" accept="image/*">
        @else<input id="f-{{ $name }}" name="{{ $name }}" type="{{ $type==='number'?'number':($type==='date'?'date':'text') }}" value="{{ $type==='date' && $val ? \Illuminate\Support\Carbon::parse($val)->toDateString() : $val }}">
        @endif
      @endif
      <span class="err" data-err="{{ $name }}"></span>
    </div>
  @endforeach
  </div>
</div>
<div class="mf">
  @if($res==='opportunity-submissions' && $edit)<button type="button" class="btn sec" data-modal="{{ route('admin.nahau.create','opportunities') }}?from={{ $row->id }}">Tengeneza fursa kutoka kwa hii</button>@endif
  <div class="sp"></div><button type="button" class="btn sec" data-close>Funga</button>
  @if(count($d['fields']))<button class="btn" type="submit">Hifadhi</button>@endif
</div>
</form>
