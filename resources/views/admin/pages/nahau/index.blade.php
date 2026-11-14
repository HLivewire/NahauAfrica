@extends('admin.master')
@section('main_content')
<div class="content-wrapper">
    @include('admin.layouts._message')
    <section class="content-header">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div>
                <h1 style="margin:0;font-weight:700">{{ $d['title'] }}</h1>
                <small class="text-muted">{{ __('Manage, edit, update and publish front-end features') }}</small>
            </div>
            @if($d['create'])
                <a class="btn btn-danger" href="{{ route('admin.nahau.create', $res) }}">
                    <i class="fas fa-plus mr-1"></i> {{ __('Add new') }}
                </a>
            @endif
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card shadow-sm border-0">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-striped align-middle mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th style="width:60px">#</th>
                                @if($res==='stories')<th>Story</th>@endif
                                @foreach($d['cols'] as $c)
                                    <th>
                                        @if($c === 'spotlight_summary')
                                            {{ __('Sweet small word (Summary)') }}
                                        @elseif($c === 'show_in_spotlight')
                                            {{ __('Home Carousel (Publish)') }}
                                        @elseif($c === 'show_on_home')
                                            {{ __('Meet the voices (Publish)') }}
                                        @else
                                            {{ ucfirst(str_replace('_',' ',$c)) }}
                                        @endif
                                    </th>
                                @endforeach
                                <th style="text-align:right;width:180px">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($rows as $r)
                            <tr>
                                <td><span class="text-muted font-weight-bold">{{ $r->id }}</span></td>
                                @if($res==='stories')
                                    <td><strong>{{ $r->news_title }}</strong></td>
                                @endif
                                @foreach($d['cols'] as $c)
                                    <td>
                                        @if(in_array($c, ['portrait', 'photo', 'cover']))
                                            @if($r->$c)
                                                <img src="{{ media_url($r->$c) }}" alt="" style="width:44px;height:44px;object-fit:cover;border-radius:8px;border:1px solid #ddd;box-shadow:0 1px 4px rgba(0,0,0,0.08)">
                                            @else
                                                <span class="badge badge-light border text-muted">—</span>
                                            @endif
                                        @elseif($c === 'show_in_spotlight')
                                            <form method="POST" action="{{ route('admin.nahau.toggle-publish', [$res, $r->id]) }}" style="display:inline">
                                                @csrf
                                                @if($r->show_in_spotlight)
                                                    <button type="submit" class="btn btn-sm btn-success" title="{{ __('Click to hide from home carousel') }}" style="border-radius:20px;font-weight:600">
                                                        <i class="fas fa-check-circle mr-1"></i> {{ __('In Carousel') }}
                                                    </button>
                                                @else
                                                    <button type="submit" class="btn btn-sm btn-secondary" title="{{ __('Click to publish to home carousel') }}" style="border-radius:20px;font-weight:500">
                                                        <i class="fas fa-eye-slash mr-1"></i> {{ __('Hidden') }}
                                                    </button>
                                                @endif
                                            </form>
                                        @elseif($c === 'show_on_home')
                                            <form method="POST" action="{{ route('admin.nahau.toggle-publish', [$res, $r->id]) }}" style="display:inline">
                                                @csrf
                                                @if($r->show_on_home)
                                                    <button type="submit" class="btn btn-sm btn-success" title="{{ __('Click to hide from Meet the Voices') }}" style="border-radius:20px;font-weight:600">
                                                        <i class="fas fa-check-circle mr-1"></i> {{ __('Visible') }}
                                                    </button>
                                                @else
                                                    <button type="submit" class="btn btn-sm btn-secondary" title="{{ __('Click to show on Meet the Voices') }}" style="border-radius:20px;font-weight:500">
                                                        <i class="fas fa-eye-slash mr-1"></i> {{ __('Hidden') }}
                                                    </button>
                                                @endif
                                            </form>
                                        @elseif($c === 'featured')
                                            <form method="POST" action="{{ route('admin.nahau.toggle-publish', [$res, $r->id]) }}" style="display:inline">
                                                @csrf
                                                @if($r->featured)
                                                    <button type="submit" class="btn btn-sm btn-warning font-weight-bold" title="{{ __('Click to unfeature') }}" style="border-radius:20px">
                                                        <i class="fas fa-star mr-1"></i> {{ __('Featured') }}
                                                    </button>
                                                @else
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary" title="{{ __('Click to feature on home') }}" style="border-radius:20px">
                                                        <i class="far fa-star mr-1"></i> {{ __('Standard') }}
                                                    </button>
                                                @endif
                                            </form>
                                        @elseif(is_bool($r->$c))
                                            <span class="badge {{ $r->$c ? 'badge-success' : 'badge-light border' }}">{{ $r->$c ? __('Yes') : '—' }}</span>
                                        @else
                                            <span style="font-size:14px">{{ \Illuminate\Support\Str::limit((string) $r->$c, 65) }}</span>
                                        @endif
                                    </td>
                                @endforeach
                                <td style="white-space:nowrap;text-align:right">
                                    @if($res === 'heroes')
                                        @php
                                            $heroStory = $r->news_id ? \App\Nahau\Stories::query()->where('news.id', $r->news_id)->first() : null;
                                        @endphp
                                        @if($heroStory)
                                            <a class="btn btn-sm btn-outline-info" href="{{ \App\Nahau\Stories::url($heroStory) }}" target="_blank" title="{{ __('View on front end') }}">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        @endif
                                    @endif

                                    @if($d['edit'])
                                        <a class="btn btn-sm btn-primary" href="{{ route('admin.nahau.edit', [$res, $r->id]) }}">
                                            <i class="fas fa-edit"></i> {{ $d['create'] ? __('Edit') : __('Open') }}
                                        </a>
                                    @endif

                                    @if($res !== 'stories' && ($d['edit'] !== false || $res === 'subscribers'))
                                        <form method="POST" action="{{ route('admin.nahau.destroy', [$res, $r->id]) }}" style="display:inline" onsubmit="return confirm('{{ __('Delete this item?') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" title="{{ __('Delete') }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($d['cols']) + 3 }}" class="text-center py-4 text-muted">
                                    {{ __('No entries found.') }}
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                @if($rows->hasPages())
                    <div class="card-footer bg-white border-0 py-3">
                        {{ $rows->links() }}
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection
