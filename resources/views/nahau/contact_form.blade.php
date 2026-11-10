@php $ok = session('nahau_ok'); $reasonSel = old('reason', request('reason')); @endphp
@if($ok)
    <div class="nx-ok" role="status"><h3>{{ __('Thank you — we received your message.') }}</h3><p>{{ __('We read every message and will reply by email.') }}</p></div>
@else
<form class="nx-form" method="POST" action="{{ route('nahau.contact.store') }}" novalidate data-nx-submit="contact_sent" style="background:#fff;border:1px solid var(--nx-line);border-top:3px solid var(--nx-red);border-radius:16px;padding:34px;box-shadow:0 18px 40px rgba(0,0,0,.06)">
    @csrf @include('nahau.partials.hp')
    <div class="nx-formgrid">
        <div class="nx-field"><label for="c-name">{{ __('Name') }} *</label><input id="c-name" class="nx-input" name="name" value="{{ old('name') }}" autocomplete="name" aria-describedby="e-name">@include('nahau.partials.field_error',['f'=>'name'])</div>
        <div class="nx-field"><label for="c-email">{{ __('Email') }} *</label><input id="c-email" class="nx-input" type="email" name="email" value="{{ old('email') }}" autocomplete="email" aria-describedby="e-email">@include('nahau.partials.field_error',['f'=>'email'])</div>
    </div>
    <div class="nx-field"><label for="c-reason">{{ __('Reason for contacting us') }}</label><select id="c-reason" class="nx-input" name="reason">@foreach(config('nahau.contact_reasons') as $r)<option value="{{ $r }}" @selected($reasonSel===$r)>{{ __($r) }}</option>@endforeach</select></div>
    <div class="nx-field"><label for="c-url">{{ __('Page address (if about a story or advert)') }}</label><input id="c-url" class="nx-input" name="page_url" value="{{ old('page_url', request('page_url')) }}" aria-describedby="e-page_url">@include('nahau.partials.field_error',['f'=>'page_url'])</div>
    <div class="nx-field"><label for="c-msg">{{ __('Message') }} *</label><textarea id="c-msg" class="nx-input" name="message" rows="5" aria-describedby="e-message">{{ old('message') }}</textarea>@include('nahau.partials.field_error',['f'=>'message'])</div>
    <p class="nx-meta"><a href="{{ nroute('privacy') }}" style="text-decoration:underline">{{ __('Privacy notice') }}</a></p>
    <div><button class="nx-btn" type="submit">{{ __('Send message') }}</button></div>
</form>
@endif
