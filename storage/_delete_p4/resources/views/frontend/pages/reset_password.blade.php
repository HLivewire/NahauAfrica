@extends('frontend.master')

@section('main_content')
<section class="maan-signup-section maan-section">
    <div class="container" style="max-width:480px">
        <h3 class="mb-3">{{ __('Reset your password') }}</h3>
        <form class="nahau-reset-form" method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="maan-input-group">
                <label for="rpEmail">{{ __('Email') }}</label>
                <input id="rpEmail" type="email" name="email" class="form-control" value="{{ old('email', $email) }}" required>
                @error('email')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
            <div class="maan-input-group">
                <label for="rpPass">{{ __('New password') }}</label>
                <input id="rpPass" type="password" name="password" class="form-control" minlength="6" required>
                @error('password')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
            <div class="maan-input-group">
                <label for="rpPass2">{{ __('Confirm password') }}</label>
                <input id="rpPass2" type="password" name="password_confirmation" class="form-control" minlength="6" required>
            </div>
            <div class="maan-input-group">
                <button class="maan-btn" type="submit">{{ __('Update password') }}</button>
            </div>
        </form>
    </div>
</section>
@endsection
