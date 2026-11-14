@extends('admin.master')
@section('main_content')
<div class="content-wrapper">
    @include('admin.layouts._message')
    <section class="content-header"><div class="container-fluid"><h1>{{ $d['title'] }}</h1></div></section>
    <section class="content"><div class="container-fluid"><div class="card">
        <div class="card-header">@if($d['create'])<a class="btn btn-danger" href="{{ route('admin.nahau.create', $res) }}">Add new</a>@endif</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead><tr><th>#</th>@if($res==='stories')<th>Story</th>@endif @foreach($d['cols'] as $c)<th>{{ ucfirst(str_replace('_',' ',$c)) }}</th>@endforeach<th></th></tr></thead>
                <tbody>
                @foreach($rows as $r)
                    <tr><td>{{ $r->id }}</td>@if($res==='stories')<td>{{ $r->news_title }}</td>@endif
                        @foreach($d['cols'] as $c)<td>{{ is_bool($r->$c) || in_array($c, ['featured','show_on_home','show_in_spotlight']) ? ($r->$c ? 'Yes' : '—') : \Illuminate\Support\Str::limit((string) $r->$c, 60) }}</td>@endforeach
                        <td style="white-space:nowrap">
                            @if($d['edit'])<a class="btn btn-sm btn-primary" href="{{ route('admin.nahau.edit', [$res, $res==='stories' ? $r->id : $r->id]) }}">{{ $d['create'] ? 'Edit' : 'Open' }}</a>@endif
                            @if($res!=='stories' && $d['edit'] !== false || $res==='subscribers')
                            <form method="POST" action="{{ route('admin.nahau.destroy', [$res, $r->id]) }}" style="display:inline" onsubmit="return confirm('Delete this item?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Delete</button></form>@endif
                        </td></tr>
                @endforeach
                </tbody>
            </table>
            {{ $rows->links() }}
        </div></div></div></section>
</div>
@endsection
