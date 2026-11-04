<div class="maan-mid-bar">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-sm-3 col-lg-2">
                <div class="maan-logo">
                    <a href="{{ URL('/') }}"><img loading="lazy" src="{{ media_url($settings->logo) }} " alt="logo"></a>
                </div>
            </div>
            <div class="col-sm-6 col-lg-7 offset-sm-1 offset-lg-1">
                <div class="maan-header-adds">
                    @if ($advertisement)
                        {!! $advertisement->header_ads !!}
                    @else
                        <a href="  https://www.google.com/ " target="_blank">
                            <img loading="lazy" src=" {{ asset('frontend/img/header-adds/adds.jpg') }} " alt="{{ asset('frontend/img/header-adds/adds.jpg') }}">
                        </a>
                    @endif


                </div>
            </div>
            <div class="col-lg-2 d-none d-lg-flex justify-content-end">
                <button type="button" class="nahau-getstarted" data-nahau-open="drawer">{{ __('Get Started') }}</button>
            </div>
        </div>
    </div>
</div>


<script>
    var optionsWeekday = { weekday: 'long' };
    var options = { year: 'numeric', month: 'long', day: 'numeric' };
    var date = new Date();
    document.getElementById("maan-current-week-day").innerHTML =date.toLocaleDateString("en-US", optionsWeekday);
    document.getElementById("maan-current-date").innerHTML =date.toLocaleDateString("en-US", options);

</script>
