@php $nxLite = trim($__env->yieldContent('nx_lite')) === '1'; @endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @php
    $googleanalytics =  googleanalytics();
    $headers =  headers();
    $footer =  footer();
    @endphp
    <meta charset="{{ config('app.charset') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="nahau-auth" content="{{ auth('maanuser')->check() ? 1 : 0 }}">
    <meta name="viewport" content="{{ __('width=device-width, initial-scale=1') }}">
    <meta name="copyright" content="{{ __('Maan News') }}">
    <meta name="robots" content="{{ __('Maan News') }}">
    <meta http-equiv="X-UA-Compatible" content="{{ __('IE=edge') }}">

    @yield('meta_content')

    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />

    <title>@yield('title', $settings->title)</title>

    <!-- Apple Favicon -->
    <link rel="apple-touch-icon" href="{{ asset('adminassets/img/nahau/favicon-180.png') }}">
    <!-- All Device Favicon -->
    <link rel="icon" href="{{ asset('adminassets/img/nahau/favicon-180.png') }}">
@if($nxLite)
    {{-- ONE merged + purged theme stylesheet (rebuild: node tools/build-theme-css.cjs) instead of 10 separate files --}}
    <link rel="stylesheet" href="{{ asset('frontend/css/theme-core.min.css') . '?v=' . @filemtime(public_path('frontend/css/theme-core.min.css')) }}">
@else
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('frontend/fontawesome/all.css') }}">
    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('frontend/fonts/fonts.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend/fonts/front_clock.css') }}">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <!-- Normalize -->
    <link rel="stylesheet" href="{{ asset('frontend/css/normalize.css') }}">
    <!-- Default -->
    <link rel="stylesheet" href="{{ asset('frontend/css/default.css') }}">

    <!-- swiper slider css -->
@unless($nxLite)
    <link rel="stylesheet" href="{{ asset('frontend/css/swiper-bundle.min.css') }}">
@endunless
    <!-- Slick -->
@unless($nxLite)
    <link rel="stylesheet" href="{{ asset('frontend/css/slick.css') }}">
@endunless
    <!-- Venobox -->
@unless($nxLite)
    <link rel="stylesheet" href="{{ asset('frontend/css/venobox.min.css') }}">
@endunless
    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <!-- Responsive -->
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">
    <!-- toastr -->
@unless($nxLite)
    <link rel="stylesheet" href="{{ asset('adminassets/plugins/toastr/toastr.css') }}">
@endunless
    <!-- Style for maannews-->
    <link rel="stylesheet" href="{{ asset('frontend/css/maan_news_style.css') }}">
    <!-- color change for maannews-->
    <link rel="stylesheet" href="{{ asset('frontend/css/color-change.css') }}">
@endif
    <link rel="stylesheet" href="{{ asset('frontend/css/nahau-drawer.css') . '?v=' . @filemtime(public_path('frontend/css/nahau-drawer.css')) }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/nahau-home.css') . '?v=' . @filemtime(public_path('frontend/css/nahau-home.css')) }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/nahau-site.css') . '?v=' . @filemtime(public_path('frontend/css/nahau-site.css')) }}">
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Source+Serif+4:opsz,wght@8..60,500;8..60,700&display=swap" media="print" onload="this.media='all'"><noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Source+Serif+4:opsz,wght@8..60,500;8..60,700&display=swap"></noscript>

    @stack('styles')

    @if ($googleanalytics)
    <!-- Global site tag (gtag.js) - Google Analytics -->
        @foreach($googleanalytics as  $googleanalytic)
            {!! $googleanalytic->google_analytics !!}
        @endforeach
    @endif

</head>

<body class="{{$settings->theme_color??'theme-broadcast'}}">

<div id="main-wrapper">
    @empty($headers)
            <!-- Maan Top Bar Start -->
            @include('frontend.layouts._topheader')
            <!-- Maan Top Bar End -->
            <!-- Maan Mid Bar Start -->
            @include('frontend.layouts._header')
            <!-- Maan Mid Bar End -->
            <!-- Maan menu Start -->
            @include('frontend.layouts._menu')
            <!-- Maan menu End -->
            @else
                @switch($headers->name_slug)
                    @case($headers->name_slug!='header_1')
                        @include('frontend.layouts.headers.'.$headers->name_slug)
                        @break
                    @default
                        <!-- Maan Top Bar Start -->
                        @include('frontend.layouts._topheader')
                        <!-- Maan Top Bar End -->
                        <!-- Maan Mid Bar Start -->
                        @include('frontend.layouts._header')
                        <!-- Maan Mid Bar End -->
                        <!-- Maan menu Start -->
                        @include('frontend.layouts._menu')
                        <!-- Maan menu End -->
                @endswitch
    @endempty


    <!-- Maan Manu Bar Start -->
    @isset($headers->name_slug)
        @if( $headers->name_slug == 'header_2')
            @include('frontend.layouts._menu')
        @endif

    @endisset
    <!-- Maan Manu Bar End -->
    <main>
        <!-- Maan Breaking News Start -->
    @if(Route::currentRouteName() !='signup'&& Route::currentRouteName() !='signin' && !Route::is('n.*','home','search'))
        @if (!empty($headers)&& $headers->name_slug !='header_7' && $headers->name_slug !='header_2')
                <section class="maan-breaking-news-section">
                    @include('frontend.layouts._breakingnews')
                </section>
        @endif

    @endif
    <!-- Maan Breaking News End -->

        <!-- Main Content Start -->
    @yield('main_content')
    <!-- Main Content End -->
    </main>
        @include('nahau.partials.footer')

</div>

<!-- jQuery -->
<script src="{{ asset('frontend/js/vendor/jquery-3.6.0.min.js') }} "></script>
<!-- Popper -->
<script src="{{ asset('frontend/js/vendor/popper.min.js') }} "></script>
<!-- Bootstrap -->
<script src="{{ asset('frontend/js/vendor/bootstrap.min.js') }} "></script>

@if($nxLite)
<script>window.Swiper=function(){return{on:function(){},destroy:function(){},update:function(){}}};(function($){['slick','counterUp','venobox','lazy','lazyLoad','waypoint'].forEach(function(n){$.fn[n]=function(){return this}});window.toastr={success:function(){},error:function(){},info:function(){},warning:function(){},options:{}}})(window.jQuery);</script>
@endif
<!-- swiper slider -->

@unless($nxLite)
<script src="{{ asset('frontend/js/swiper-bundle.min.js') }} "></script>
@endunless
<!-- Slick -->
@unless($nxLite)
<script src="{{ asset('frontend/js/vendor/slick.min.js') }} "></script>
@endunless
<!-- Counter Up -->
@unless($nxLite)
<script src="{{ asset('frontend/js/vendor/counterup.min.js') }} "></script>
@endunless
<!-- Waypoints -->
@unless($nxLite)
<script src="{{ asset('frontend/js/vendor/waypoints.min.js') }} "></script>
@endunless
<!-- Venobox -->
@unless($nxLite)
<script src="{{ asset('frontend/js/vendor/venobox.min.js') }} "></script>
@endunless
<!-- Index -->

<script src="{{ asset('frontend/js/index.js') }} "></script>

<script src="{{ asset('frontend/js/theme.js') }} "></script>
<!-- toastr -->
@unless($nxLite)
<script src="{{ asset('adminassets/plugins/toastr/toastr.min.js') }} "></script>
@endunless
{{--lazyloaded--}}
@unless($nxLite)
<script src="{{ asset('maan/js/jquery.lazy.min.js') }} "></script>
@endunless
@stack('scripts')


<script>
    $("#loginMessage").show().delay(5000).fadeOut('slow');
</script>
{{-- images use native loading="lazy"; the old $('img').lazyLoad() plugin is not installed --}}

    <script src="{{ asset('frontend/js/nahau-drawer.js') . '?v=' . @filemtime(public_path('frontend/js/nahau-drawer.js')) }}"></script>
    <script src="{{ asset('frontend/js/nahau-site.js') . '?v=' . @filemtime(public_path('frontend/js/nahau-site.js')) }}" defer></script>
    @include('nahau.partials.assistant')
</body>

</html>

