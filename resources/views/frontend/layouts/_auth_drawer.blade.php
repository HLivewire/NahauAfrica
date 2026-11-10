{{-- Right-side drawer: sign in / create account / forgot password (opened by "Get Started") --}}
@once
@php
    $nahauStart = session('nahau_panel') ?: (old('nahau_form') ?: null);
    $nahauMsgType = session('type');
    $nahauAlert = session()->has('message') && in_array($nahauMsgType, ['warning', 'danger'], true) ? session('message') : null;
    $nahauNotice = session('nahau_notice');
    $regErr = old('nahau_drawer') ? $errors : null;
    $fgErr = old('nahau_form') === 'forgot' ? $errors : null;
    $eye = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>';
@endphp
<div class="nahau-overlay" id="nahauOverlay" aria-hidden="true"></div>
<aside class="nahau-drawer" id="nahauDrawer" role="dialog" aria-modal="true" aria-label="{{ __('Account') }}" aria-hidden="true" @if($nahauStart) data-nahau-start="{{ $nahauStart }}" @elseif($nahauAlert || $nahauNotice) data-nahau-start="login" @endif>
    <button type="button" class="nahau-drawer-close" data-nahau-close="drawer" aria-label="{{ __('Close') }}">&times;</button>
    <div class="nahau-drawer-body">
        <a class="nahau-d-logo" href="{{ URL('/') }}"><img src="{{ media_url(settings()->logo) }}" alt="{{ config('app.name') }}"></a>

        {{-- LOGIN --}}
        <section class="nahau-panel is-active" data-panel="login">
            <h3 class="nahau-d-item" style="--i:1">{{ __('Welcome back') }}</h3>
            <p class="nahau-sub nahau-d-item" style="--i:2">{{ __('Sign in to continue') }}</p>
            @if ($nahauAlert)<div class="nahau-d-alert" role="alert">{{ $nahauAlert }}</div>@endif
            @if ($nahauNotice && in_array($nahauStart, ['login', null], true))<div class="nahau-d-ok" role="status">{{ $nahauNotice }}</div>@endif
            <form action="{{ route('signin') }}" method="POST" class="nahau-form">
                @csrf
                <label class="nahau-d-item" style="--i:3" for="nahauEmail">{{ __('Email') }}</label>
                <input class="nahau-d-item" style="--i:3" type="email" id="nahauEmail" name="email" placeholder="you@example.com" required autocomplete="username">
                <label class="nahau-d-item" style="--i:4" for="nahauPass">{{ __('Password') }}</label>
                <input class="nahau-d-item" style="--i:4" type="password" id="nahauPass" name="password" placeholder="{{ __('Your password') }}" required autocomplete="current-password">
                <button type="submit" class="nahau-login-btn nahau-d-item" style="--i:5">{{ __('Login') }}</button>
            </form>
            <div class="nahau-or nahau-d-item" style="--i:9"><span>{{ __('or') }}</span></div>
            <a class="nahau-google nahau-d-item" style="--i:9" href="{{ route('auth.google') }}"><svg viewBox="0 0 48 48" width="20" height="20" aria-hidden="true"><path fill="#EA4335" d="M24 9.5c3.5 0 6.6 1.2 9 3.6l6.7-6.7C35.6 2.4 30.2 0 24 0 14.6 0 6.5 5.4 2.6 13.2l7.8 6.1C12.3 13.6 17.7 9.5 24 9.5z"/><path fill="#4285F4" d="M46.5 24.5c0-1.6-.1-3.1-.4-4.5H24v9h12.7c-.6 3-2.3 5.5-4.8 7.2l7.5 5.8c4.4-4.1 7.1-10.1 7.1-17.5z"/><path fill="#FBBC05" d="M10.4 28.7A14.5 14.5 0 0 1 9.5 24c0-1.6.3-3.2.8-4.7l-7.8-6.1A24 24 0 0 0 0 24c0 3.9.9 7.5 2.6 10.8l7.8-6.1z"/><path fill="#34A853" d="M24 48c6.2 0 11.6-2 15.4-5.6l-7.5-5.8c-2 1.4-4.7 2.3-7.9 2.3-6.3 0-11.7-4.1-13.6-9.8l-7.8 6.1C6.5 42.6 14.6 48 24 48z"/></svg><span>{{ __('Continue with Google') }}</span></a>
            <div class="nahau-links nahau-d-item" style="--i:6">
                <a href="#" data-nahau-panel="forgot">{{ __('Forgot password?') }}</a>
                <a href="#" data-nahau-panel="register">{{ __('Create new account') }}</a>
            </div>
        </section>

        {{-- REGISTER --}}
        <section class="nahau-panel" data-panel="register">
            <h3 class="nahau-d-item" style="--i:1">{{ __('Create your Account') }}</h3>
            <p class="nahau-sub nahau-d-item" style="--i:2">{{ __('It only takes a minute') }}</p>
            <form action="{{ route('signup') }}" method="POST" class="nahau-form">
                @csrf
                <input type="hidden" name="nahau_drawer" value="1">
                <div class="nahau-row nahau-d-item" style="--i:3">
                    <div>
                        <label for="nrFirst">{{ __('First Name') }}</label>
                        <input type="text" id="nrFirst" name="first_name" value="{{ old('first_name') }}" required autocomplete="given-name">
                        @if($regErr && $regErr->has('first_name'))<small class="nahau-err">{{ $regErr->first('first_name') }}</small>@endif
                    </div>
                    <div>
                        <label for="nrLast">{{ __('Last Name') }}</label>
                        <input type="text" id="nrLast" name="last_name" value="{{ old('last_name') }}" required autocomplete="family-name">
                        @if($regErr && $regErr->has('last_name'))<small class="nahau-err">{{ $regErr->first('last_name') }}</small>@endif
                    </div>
                </div>
                <div class="nahau-d-item" style="--i:4">
                    <label for="nrPhone">{{ __('Phone') }}</label>
                    <input type="tel" inputmode="numeric" pattern="[0-9]*" id="nrPhone" name="phone" value="{{ old('phone') }}" required autocomplete="tel">
                    @if($regErr && $regErr->has('phone'))<small class="nahau-err">{{ $regErr->first('phone') }}</small>@endif
                </div>
                <div class="nahau-d-item" style="--i:5">
                    <label for="nrEmail">{{ __('Email') }}</label>
                    <input type="email" id="nrEmail" name="email" value="{{ old('email') }}" required autocomplete="email">
                    @if($regErr && $regErr->has('email'))<small class="nahau-err">{{ $regErr->first('email') }}</small>@endif
                </div>
                <div class="nahau-row nahau-d-item" style="--i:6">
                    <div>
                        <label for="nrPass">{{ __('Password') }}</label>
                        <input type="password" id="nrPass" name="password" minlength="6" required autocomplete="new-password">
                        @if($regErr && $regErr->has('password'))<small class="nahau-err">{{ $regErr->first('password') }}</small>@endif
                    </div>
                    <div>
                        <label for="nrPass2">{{ __('Confirm') }}</label>
                        <input type="password" id="nrPass2" name="password_confirmation" minlength="6" required autocomplete="new-password">
                        @if($regErr && $regErr->has('password_confirmation'))<small class="nahau-err">{{ $regErr->first('password_confirmation') }}</small>@endif
                    </div>
                </div>
                <button type="submit" class="nahau-login-btn nahau-d-item" style="--i:7">{{ __('Create account') }}</button>
            </form>
            <div class="nahau-or nahau-d-item" style="--i:9"><span>{{ __('or') }}</span></div>
            <a class="nahau-google nahau-d-item" style="--i:9" href="{{ route('auth.google') }}"><svg viewBox="0 0 48 48" width="20" height="20" aria-hidden="true"><path fill="#EA4335" d="M24 9.5c3.5 0 6.6 1.2 9 3.6l6.7-6.7C35.6 2.4 30.2 0 24 0 14.6 0 6.5 5.4 2.6 13.2l7.8 6.1C12.3 13.6 17.7 9.5 24 9.5z"/><path fill="#4285F4" d="M46.5 24.5c0-1.6-.1-3.1-.4-4.5H24v9h12.7c-.6 3-2.3 5.5-4.8 7.2l7.5 5.8c4.4-4.1 7.1-10.1 7.1-17.5z"/><path fill="#FBBC05" d="M10.4 28.7A14.5 14.5 0 0 1 9.5 24c0-1.6.3-3.2.8-4.7l-7.8-6.1A24 24 0 0 0 0 24c0 3.9.9 7.5 2.6 10.8l7.8-6.1z"/><path fill="#34A853" d="M24 48c6.2 0 11.6-2 15.4-5.6l-7.5-5.8c-2 1.4-4.7 2.3-7.9 2.3-6.3 0-11.7-4.1-13.6-9.8l-7.8 6.1C6.5 42.6 14.6 48 24 48z"/></svg><span>{{ __('Continue with Google') }}</span></a>
            <div class="nahau-links nahau-d-item" style="--i:8">
                <span class="nahau-muted">{{ __('Already member?') }}</span>
                <a href="#" data-nahau-panel="login">{{ __('Sign in here') }}</a>
            </div>
        </section>

        {{-- FORGOT PASSWORD --}}
        <section class="nahau-panel" data-panel="forgot">
            <h3 class="nahau-d-item" style="--i:1">{{ __('Forgot password?') }}</h3>
            <p class="nahau-sub nahau-d-item" style="--i:2">{{ __("Enter your email and we'll send you a reset link.") }}</p>
            @if ($nahauNotice && $nahauStart === 'forgot')<div class="nahau-d-ok" role="status">{{ $nahauNotice }}</div>@endif
            <form action="{{ route('password.email') }}" method="POST" class="nahau-form">
                @csrf
                <input type="hidden" name="nahau_form" value="forgot">
                <label class="nahau-d-item" style="--i:3" for="nfEmail">{{ __('Email') }}</label>
                <input class="nahau-d-item" style="--i:3" type="email" id="nfEmail" name="email" placeholder="you@example.com" value="{{ old('email') }}" required autocomplete="email">
                @if($fgErr && $fgErr->has('email'))<small class="nahau-err">{{ $fgErr->first('email') }}</small>@endif
                <button type="submit" class="nahau-login-btn nahau-d-item" style="--i:4">{{ __('Send reset link') }}</button>
            </form>
            <div class="nahau-links nahau-d-item" style="--i:5">
                <a href="#" data-nahau-panel="login">&larr; {{ __('Back to sign in') }}</a>
            </div>
        </section>
    </div>
</aside>
@endonce
