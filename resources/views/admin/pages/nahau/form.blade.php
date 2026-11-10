@extends('admin.master')
@section('main_content')
<div class="content-wrapper">
    @include('admin.layouts._message')
    <section class="content-header"><div class="container-fluid"><h1>{{ $d['title'] }} — {{ $row->exists ? 'Edit' : 'New' }}</h1></div></section>
    <section class="content"><div class="container-fluid"><div class="card"><div class="card-body">
        @if(!empty($d['show']) && $row->exists)
            <dl class="row">@foreach($d['show'] as $k)<dt class="col-sm-3">{{ ucfirst(str_replace('_',' ',$k)) }}</dt><dd class="col-sm-9" style="white-space:pre-wrap">{{ is_bool($row->$k) || in_array($k,['original','consent','published_before']) ? ($row->$k ? 'Yes' : 'No') : $row->$k }}</dd>@endforeach
            @if($res==='submissions' && $row->file_path)<dt class="col-sm-3">File</dt><dd class="col-sm-9">{{ basename($row->file_path) }} (stored privately in storage/app/private)</dd>@endif</dl>
            @if($res==='opportunity-submissions')<a class="btn btn-danger mb-3" href="{{ route('admin.nahau.create','opportunities') }}?from={{ $row->id }}">Create listing from this</a>@endif
            <hr>
        @endif
        @if($res==='opportunities')<div class="alert alert-warning">An opportunity cannot be published until <strong>Verified by</strong> and <strong>Verified on</strong> are filled in. @if($row->exists)Reports: {{ $row->reports()->count() }}. @endif</div>@endif
        @if($res==='stories')<p class="text-muted">News item: <strong>{{ \App\Models\News::find($row->news_id)?->title }}</strong></p>@endif
        <form method="POST" enctype="multipart/form-data" action="{{ $row->exists ? route('admin.nahau.update', [$res, $row->id]) : route('admin.nahau.store', $res) }}">
            @csrf @if($row->exists) @method('PUT') @endif
            @foreach($d['fields'] as $f)
                @php [$name,$label,$type] = $f; $val = old($name, $row->$name); @endphp
                <div class="form-group">
                    @if($type==='checkbox')
                        <div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" id="f-{{ $name }}" name="{{ $name }}" value="1" @checked($val)><label class="custom-control-label" for="f-{{ $name }}">{{ $label }}</label></div>
                    @else
                        <label for="f-{{ $name }}">{{ $label }}</label>
                        @if($type==='textarea')<textarea id="f-{{ $name }}" name="{{ $name }}" rows="{{ in_array($name,['body_en','body_sw','corrections','sources']) ? 10 : 4 }}" class="form-control">{{ $val }}</textarea>
                        @elseif($type==='select')<select id="f-{{ $name }}" name="{{ $name }}" class="form-control"><option value="">—</option>@foreach(($f[4])() as $k=>$v)<option value="{{ $k }}" @selected((string)$val === (string)$k)>{{ $v }}</option>@endforeach</select>
                        @elseif($type==='image')@if($val)<div class="mb-2"><img src="{{ media_url($val) }}" alt="" style="max-height:80px"></div>@endif<input type="file" id="f-{{ $name }}" name="{{ $name }}" accept="image/*" class="form-control-file">
                        @else<input id="f-{{ $name }}" name="{{ $name }}" type="{{ $type==='number'?'number':($type==='date'?'date':'text') }}" value="{{ $type==='date' && $val ? \Illuminate\Support\Carbon::parse($val)->toDateString() : $val }}" class="form-control">
                        @endif
                    @endif
                    @error($name)<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            @endforeach
            @if(count($d['fields']))<button class="btn btn-danger" type="submit">Save</button>@endif
            <a class="btn btn-default" href="{{ route('admin.nahau.index', $res) }}">Back</a>
        </form>
    </div></div></div></section>
</div>
@endsection
