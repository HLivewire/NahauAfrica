@php use App\Nahau\Stories; @endphp
<p class="nx-count">{{ $stories->total() }} {{ trans_choice('{1} story|[0,*] stories', $stories->total()) }}{{ $format ? ' · '.__($format) : '' }}{{ $q !== '' ? ' · “'.$q.'”' : '' }}</p>
@if($stories->isEmpty())
    <p class="nx-empty">{{ __('No stories match yet. Try another format or search term.') }}</p>
@else
    <div class="nx-grid nx-grid--3">@foreach($stories as $s)@include('nahau.partials.card')@endforeach</div>
    <div class="maan-pagination" style="margin-top:36px">{{ $stories->links() }}</div>
@endif
