@extends('nahau-admin.layout')
@section('title', $title ?? 'Admin')
@section('content')
<div class="ph"><div><h2>{{ $title ?? 'Admin' }}</h2></div></div>
<div class="modal" style="position:static;transform:none;max-height:none;max-width:760px;width:100%">@include($partial, $data)</div>
@endsection
