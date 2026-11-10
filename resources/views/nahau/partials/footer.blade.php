<div class="nx nx-footer" role="contentinfo" lang="{{ nlocale() }}">
    <div class="nx-wrap">
        <div class="cols">
            <div>
                <a href="{{ nroute('home') }}"><img src="{{ asset('uploads/images/logo/nahau_logo_light.png') }}" alt="{{ __('Nahau Africa home') }}"></a>
                <p class="brand">Nahau Africa — {{ __('Our Stories. Our Voices.') }}</p>
                <p>{{ __('Fiction, lived experiences, and remarkable lives from African perspectives.') }}</p>
            </div>
            <div>
                <h4>{{ __('Sections') }}</h4>
                <ul>
                    @foreach(nsections() as $k => $s)<li><a href="{{ nroute($k) }}">{{ nsection($k,'name') }}</a></li>@endforeach
                </ul>
            </div>
            <div>
                <h4>{{ __('Nahau Africa') }}</h4>
                <ul>
                    <li><a href="{{ nroute('about') }}">{{ __('About Us') }}</a></li>
                    <li><a href="{{ nroute('write') }}">{{ __('Write for Us') }}</a></li>
                    <li><a href="{{ nroute('contact') }}">{{ __('Contact') }}</a></li>
                    <li><a href="{{ nroute('standards') }}">{{ __('Editorial standards') }}</a></li>
                </ul>
            </div>
        </div>
        <div class="bottom">
            <span>© {{ date('Y') }} Nahau Africa</span>
            <ul>
                <li><a href="{{ nroute('privacy') }}">{{ __('Privacy notice') }}</a></li>
                <li><a href="{{ nroute('terms') }}">{{ __('Terms of use') }}</a></li>
                <li><a href="{{ nroute('copyright') }}">{{ __('Copyright') }}</a></li>
                @foreach(($socials ?? []) as $social)<li><a href="{{ $social->url }}" rel="noopener" aria-label="{{ $social->name ?? 'Social' }}"><i class="{{ $social->icon_code }}"></i></a></li>@endforeach
            </ul>
        </div>
    </div>
</div>
