@extends('admin.master')
@section('main_content')
<div class="content-wrapper">
    @include('admin.layouts._message')
    <section class="content-header"><div class="container-fluid"><h1>NahauAfrica — Editor dashboard</h1></div></section>
    <section class="content"><div class="container-fluid"><div class="row">
        @foreach($c as $label => [$n, $res])
        <div class="col-md-3 col-sm-6"><a href="{{ route('admin.nahau.index', $res) }}" class="small-box bg-white" style="display:block;padding:18px;border-left:4px solid #FF0000;color:#111">
            <h3 style="margin:0">{{ $n }}</h3><p style="margin:4px 0 0">{{ $label }}</p></a></div>
        @endforeach
    </div>
    <p class="mt-3"><a class="btn btn-danger" href="{{ route('admin.news') }}">Add or edit stories (All News)</a>
        <span class="text-muted ml-2">Put a story in Fiction, Relationships, Jobs or African Heroes, then use “Story details” to set format, label, author, language and more.</span></p>
    </div></section>
</div>
@endsection
