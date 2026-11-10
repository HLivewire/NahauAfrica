<div class="nx-sec nx-news" id="newsletter">
    <div class="nx-wrap">
        @if(session('nahau_subscribed'))
            <div role="status"><h2>{{ __("Asante! You're on the list — look out for our next story.") }}</h2><p>{{ __('Please check your inbox to confirm your email.') }}</p></div>
        @else
            <h2>{{ $title ?? __('A good story is worth making time for.') }}</h2>
            <p>{{ $text ?? __('Receive selected stories, new chapters, and fresh voices from Nahau Africa in your inbox.') }}</p>
            <form method="POST" action="{{ route('nahau.newsletter') }}" data-nx-newsletter novalidate>
                @csrf
                <input type="hidden" name="language" value="{{ nlocale() }}">
                <div class="nx-hp" aria-hidden="true"><label>Website<input type="text" name="nx_website" tabindex="-1" autocomplete="off"></label></div>
                <label for="nl-email-{{ $uid ?? 'a' }}">{{ __('Email address') }}</label>
                <input id="nl-email-{{ $uid ?? 'a' }}" class="nx-input" type="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" required aria-describedby="nl-err-{{ $uid ?? 'a' }}">
                <button class="nx-btn" type="submit">{{ __('Subscribe for New Stories') }}</button>
                <div style="flex-basis:100%"><p class="nx-err" id="nl-err-{{ $uid ?? 'a' }}" role="alert" style="margin:6px 0 0">@error('email'){{ $message }}@enderror</p></div>
            </form>
            <p style="margin:14px auto 0;font-size:14px">{{ __('We only use your email to send Nahau Africa stories.') }} <a href="{{ nroute('privacy') }}" style="text-decoration:underline;color:#fff">{{ __('Privacy notice') }}</a></p>
        @endif
    </div>
</div>
