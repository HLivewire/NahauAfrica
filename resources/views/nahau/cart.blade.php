@extends('nahau.layout')
@section('nx_title'){{ __('Your cart') }}@endsection
@section('nx')
<div class="nx-banner" style="background:var(--nx-grey);border-bottom-color:var(--nx-red)">
    <div class="nx-wrap">
        <h1 class="nx-h1" style="font-size:clamp(34px,5vw,52px)">{{ __('Your cart') }}</h1>
    </div>
</div>
<div class="nx-sec">
    <div class="nx-wrap">
        @if($items->isEmpty())
            <p class="nx-empty">{{ __('Your cart is empty.') }} <a class="nx-link" href="{{ nroute('fiction') }}">{{ __('Browse books') }} →</a></p>
        @else
            <ul class="nx-cart">
                @foreach($items as $b)
                @php $img = nimage($b); @endphp
                <li>
                    <div class="nx-cart-cover">@if($img)<img src="{{ $img }}" alt="" loading="lazy">@endif</div>
                    <div class="nx-cart-info"><a class="nx-link" href="{{ \App\Nahau\Stories::url($b) }}">{{ $b->title }}</a><div class="nx-meta">{{ \App\Nahau\Stories::authorName($b) }}</div></div>
                    <div class="nx-cart-price">{{ nmoney($b->price) }}</div>
                    <form method="POST" action="{{ route('nahau.cart.remove', $b->id) }}">@csrf<button class="nx-textbtn" type="submit">{{ __('Remove') }}</button></form>
                </li>
                @endforeach
            </ul>
            <div class="nx-cart-total"><span>{{ __('Total') }}</span><strong>{{ nmoney($total) }}</strong></div>
            <div class="nx-box" role="note" style="margin-top:22px">{{ __('Online payment is not open yet. Send us your cart and we will confirm how to pay and deliver your books.') }}</div>
            <p style="margin-top:18px"><a class="nx-btn" href="{{ nroute('contact') }}?reason={{ urlencode('Buying books') }}">{{ __('Contact us to complete your order') }}</a></p>
        @endif
    </div>
</div>
@endsection
