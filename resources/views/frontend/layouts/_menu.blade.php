<div class="maan-manu-bar">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-6 col-lg-2">
                <div class="maan-logo">
                    <a href="{{ nroute('home') }}"><img src="{{ media_url(settings()->logo) }}" alt="{{ __('Nahau Africa home') }}"></a>
                </div>
            </div>
            <div class="col-6 order-lg-3 col-lg-2">
                <ul class="maan-right-btns nahau-right">
                    <li class="nx-lang nx-lang--m d-lg-none" data-nx-lang>
                            <button type="button" class="nx-lang-btn" aria-haspopup="listbox" aria-expanded="false">@if(nlocale()==='en')<svg class="nx-flag" viewBox="0 0 60 40" width="22" height="22" preserveAspectRatio="xMidYMid slice" aria-hidden="true"><rect width="60" height="40" fill="#012169"/><path d="M0 0l60 40M60 0L0 40" stroke="#fff" stroke-width="8"/><path d="M0 0l60 40M60 0L0 40" stroke="#C8102E" stroke-width="3"/><path d="M30 0v40M0 20h60" stroke="#fff" stroke-width="13"/><path d="M30 0v40M0 20h60" stroke="#C8102E" stroke-width="8"/></svg><span>English</span>@else<svg class="nx-flag" viewBox="0 0 60 40" width="22" height="22" preserveAspectRatio="xMidYMid slice" aria-hidden="true"><rect width="60" height="40" fill="#1EB53A"/><polygon points="60,0 60,40 0,40" fill="#00A3DD"/><line x1="0" y1="40" x2="60" y2="0" stroke="#FCD116" stroke-width="14"/><line x1="0" y1="40" x2="60" y2="0" stroke="#000" stroke-width="8"/></svg><span>Kiswahili</span>@endif<svg class="nx-caret" viewBox="0 0 12 8" width="10" height="7" aria-hidden="true"><path d="M1 1l5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                            <ul class="nx-lang-list" role="listbox" aria-label="{{ __('Language') }}" hidden>
                                <li role="option" @if(nlocale()==='en') aria-selected="true" @endif><a href="{{ nswitch_url('en') }}" hreflang="en" lang="en"><svg class="nx-flag" viewBox="0 0 60 40" width="22" height="22" preserveAspectRatio="xMidYMid slice" aria-hidden="true"><rect width="60" height="40" fill="#012169"/><path d="M0 0l60 40M60 0L0 40" stroke="#fff" stroke-width="8"/><path d="M0 0l60 40M60 0L0 40" stroke="#C8102E" stroke-width="3"/><path d="M30 0v40M0 20h60" stroke="#fff" stroke-width="13"/><path d="M30 0v40M0 20h60" stroke="#C8102E" stroke-width="8"/></svg><span>English</span></a></li>
                                <li role="option" @if(nlocale()==='sw') aria-selected="true" @endif><a href="{{ nswitch_url('sw') }}" hreflang="sw" lang="sw"><svg class="nx-flag" viewBox="0 0 60 40" width="22" height="22" preserveAspectRatio="xMidYMid slice" aria-hidden="true"><rect width="60" height="40" fill="#1EB53A"/><polygon points="60,0 60,40 0,40" fill="#00A3DD"/><line x1="0" y1="40" x2="60" y2="0" stroke="#FCD116" stroke-width="14"/><line x1="0" y1="40" x2="60" y2="0" stroke="#000" stroke-width="8"/></svg><span>Kiswahili</span></a></li>
                            </ul>
                        </li>
                    <li>
                        <button type="button" class="nahau-getstarted nahau-getstarted--sm" data-nahau-open="drawer">{{ __('Get Started') }}</button>
                    </li>
                                        <li class="d-lg-none">
                        <button type="button" class="manu-btn">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                    </li>
                </ul>
            </div>
            <div class="col-12 order-lg-2 col-lg-8">
                <nav class="maan-main-manu">
                    <button class="close-btn d-lg-none">
                        <span></span>
                        <span></span>
                    </button>
                    <ul>
                        {{--start menu dynamic--}}
                        @include('frontend.layouts._menu_one')
                        {{--end menu dynamic--}}

                        <li><a href="{{ nroute('about') }}">{{ __('About') }}</a></li>
                        <li><a href="{{ nroute('write') }}">{{ __('Write for Us') }}</a></li>
                        <li class="nx-lang" data-nx-lang>
                            <button type="button" class="nx-lang-btn" aria-haspopup="listbox" aria-expanded="false">@if(nlocale()==='en')<svg class="nx-flag" viewBox="0 0 60 40" width="22" height="22" preserveAspectRatio="xMidYMid slice" aria-hidden="true"><rect width="60" height="40" fill="#012169"/><path d="M0 0l60 40M60 0L0 40" stroke="#fff" stroke-width="8"/><path d="M0 0l60 40M60 0L0 40" stroke="#C8102E" stroke-width="3"/><path d="M30 0v40M0 20h60" stroke="#fff" stroke-width="13"/><path d="M30 0v40M0 20h60" stroke="#C8102E" stroke-width="8"/></svg><span>English</span>@else<svg class="nx-flag" viewBox="0 0 60 40" width="22" height="22" preserveAspectRatio="xMidYMid slice" aria-hidden="true"><rect width="60" height="40" fill="#1EB53A"/><polygon points="60,0 60,40 0,40" fill="#00A3DD"/><line x1="0" y1="40" x2="60" y2="0" stroke="#FCD116" stroke-width="14"/><line x1="0" y1="40" x2="60" y2="0" stroke="#000" stroke-width="8"/></svg><span>Kiswahili</span>@endif<svg class="nx-caret" viewBox="0 0 12 8" width="10" height="7" aria-hidden="true"><path d="M1 1l5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                            <ul class="nx-lang-list" role="listbox" aria-label="{{ __('Language') }}" hidden>
                                <li role="option" @if(nlocale()==='en') aria-selected="true" @endif><a href="{{ nswitch_url('en') }}" hreflang="en" lang="en"><svg class="nx-flag" viewBox="0 0 60 40" width="22" height="22" preserveAspectRatio="xMidYMid slice" aria-hidden="true"><rect width="60" height="40" fill="#012169"/><path d="M0 0l60 40M60 0L0 40" stroke="#fff" stroke-width="8"/><path d="M0 0l60 40M60 0L0 40" stroke="#C8102E" stroke-width="3"/><path d="M30 0v40M0 20h60" stroke="#fff" stroke-width="13"/><path d="M30 0v40M0 20h60" stroke="#C8102E" stroke-width="8"/></svg><span>English</span></a></li>
                                <li role="option" @if(nlocale()==='sw') aria-selected="true" @endif><a href="{{ nswitch_url('sw') }}" hreflang="sw" lang="sw"><svg class="nx-flag" viewBox="0 0 60 40" width="22" height="22" preserveAspectRatio="xMidYMid slice" aria-hidden="true"><rect width="60" height="40" fill="#1EB53A"/><polygon points="60,0 60,40 0,40" fill="#00A3DD"/><line x1="0" y1="40" x2="60" y2="0" stroke="#FCD116" stroke-width="14"/><line x1="0" y1="40" x2="60" y2="0" stroke="#000" stroke-width="8"/></svg><span>Kiswahili</span></a></li>
                            </ul>
                        </li>

                    </ul>

                </nav>
            </div>
        </div>
    </div>



    {{--signup modal--}}
    <div class="modal fade" id="modal-signUp" >
        <div class="modal-dialog">
            <div class="modal-content p-0">
                <div class="maan-user-avatar">
                    <h3 class="maan-login-header">{{ __('Create your Account') }}</h3>
                    <form class="maan-user-avatar-form" action="{{ route('signup') }}" method="POST">
                        @csrf
                        <div class="maan-input-group">
                            <label for="firstName">{{ __('First Name') }}</label>
                            <input id="firstName" type="text" name="first_name" class="form-control" placeholder="First Name" value="{{old('first_name')}}" required>
                            @error('first_name')
                            <span class="text-danger">
                                            {{$message}}
                                        </span>
                            @enderror
                        </div>
                        <div class="maan-input-group">
                            <label for="lastName">{{ __('Last Name') }}</label>
                            <input id="lastName" type="text" name="last_name" class="form-control" placeholder="Last Name" value="{{old('last_name')}}" required>
                            @error('last_name')
                            <span class="text-danger">
                                            {{$message}}
                                        </span>
                            @enderror
                        </div>
                        <div class="maan-input-group">
                            <label for="phoneone">{{ __('Phone') }}</label>
                            <input id="phoneone" type="number" name="phone" class="form-control" placeholder="Phone"  value="{{old('phone')}}" required>
                            @error('phone')
                            <span class="text-danger">
                                            {{$message}}
                                        </span>
                            @enderror
                        </div>
                        <div class="maan-input-group">
                            <label for="email">{{ __('Email') }}</label>
                            <input id="email" type="text" name="email" class="form-control" placeholder="Email" value="{{old('email')}}" required>
                            @error('email')
                            <span class="text-danger">
                                            {{$message}}
                                        </span>
                            @enderror
                        </div>

                        <div class="maan-input-group">
                            <label for="ps">{{ __('Password') }}</label>
                            <div class="password-area">
                                <input id="ps" type="password" class="form-control" placeholder="Password" name="password" required>
                                <div toggle="#ps" class="field-icon toggle-password">
                                    <svg class="eye-show" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 511.992 511.992"><path d="M510.096,249.937c-4.032-5.867-100.928-143.275-254.101-143.275C124.56,106.662,7.44,243.281,2.512,249.105
                                                c-3.349,3.968-3.349,9.792,0,13.781C7.44,268.71,124.56,405.329,255.995,405.329S504.549,268.71,509.477,262.886
                                                C512.571,259.217,512.848,253.905,510.096,249.937z M255.995,383.996c-105.365,0-205.547-100.48-230.997-128
                                                c25.408-27.541,125.483-128,230.997-128c123.285,0,210.304,100.331,231.552,127.424
                                                C463.013,282.065,362.256,383.996,255.995,383.996z"/><path d="M255.995,170.662c-47.061,0-85.333,38.272-85.333,85.333s38.272,85.333,85.333,85.333s85.333-38.272,85.333-85.333
                                                S303.056,170.662,255.995,170.662z M255.995,319.996c-35.285,0-64-28.715-64-64s28.715-64,64-64s64,28.715,64,64
                                                S291.28,319.996,255.995,319.996z"/></svg>

                                    <svg class="eye-close" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512.001 512.001"><path d="M316.332,195.662c-4.16-4.16-10.923-4.16-15.083,0c-4.16,4.16-4.16,10.944,0,15.083
                                                c12.075,12.075,18.752,28.139,18.752,45.248c0,35.285-28.715,64-64,64c-17.109,0-33.173-6.656-45.248-18.752
                                                c-4.16-4.16-10.923-4.16-15.083,0c-4.16,4.139-4.16,10.923,0,15.083c16.085,16.128,37.525,25.003,60.331,25.003
                                                c47.061,0,85.333-38.272,85.333-85.333C341.334,233.187,332.46,211.747,316.332,195.662z"/><path d="M270.87,172.131c-4.843-0.853-9.792-1.472-14.869-1.472c-47.061,0-85.333,38.272-85.333,85.333
                                                c0,5.077,0.619,10.027,1.493,14.869c0.917,5.163,5.419,8.811,10.475,8.811c0.619,0,1.237-0.043,1.877-0.171
                                                c5.781-1.024,9.664-6.571,8.64-12.352c-0.661-3.627-1.152-7.317-1.152-11.157c0-35.285,28.715-64,64-64
                                                c3.84,0,7.531,0.491,11.157,1.131c5.675,1.152,11.328-2.859,12.352-8.64C280.534,178.702,276.652,173.155,270.87,172.131z"/><path d="M509.462,249.102c-2.411-2.859-60.117-70.208-139.712-111.445c-5.163-2.709-11.669-0.661-14.379,4.587
                                                c-2.709,5.227-0.661,11.669,4.587,14.379c61.312,31.744,110.293,81.28,127.04,99.371c-25.429,27.541-125.504,128-230.997,128
                                                c-35.797,0-71.872-8.64-107.264-25.707c-5.248-2.581-11.669-0.341-14.229,4.971c-2.581,5.291-0.341,11.669,4.971,14.229
                                                c38.293,18.496,77.504,27.84,116.523,27.84c131.435,0,248.555-136.619,253.483-142.443
                                                C512.854,258.915,512.833,253.091,509.462,249.102z"/><path d="M325.996,118.947c-24.277-8.171-47.829-12.288-69.995-12.288c-131.435,0-248.555,136.619-253.483,142.443
                                                c-3.115,3.669-3.371,9.003-0.597,12.992c1.472,2.112,36.736,52.181,97.856,92.779c1.813,1.216,3.84,1.792,5.888,1.792
                                                c3.435,0,6.827-1.664,8.875-4.8c3.264-4.885,1.92-11.52-2.987-14.763c-44.885-29.845-75.605-65.877-87.104-80.533
                                                c24.555-26.667,125.291-128.576,231.552-128.576c19.861,0,41.131,3.755,63.189,11.157c5.589,2.005,11.648-1.088,13.504-6.699
                                                C334.572,126.862,331.585,120.825,325.996,118.947z"/><path d="M444.865,67.128c-4.16-4.16-10.923-4.16-15.083,0L67.116,429.795c-4.16,4.16-4.16,10.923,0,15.083
                                                c2.091,2.069,4.821,3.115,7.552,3.115c2.731,0,5.461-1.045,7.531-3.115L444.865,82.211
                                                C449.025,78.051,449.025,71.288,444.865,67.128z"/></svg>
                                </div>
                            </div>
                            @error('password')
                            <span class="text-danger">
                                            {{$message}}
                                        </span>
                            @enderror
                        </div>
                        <div class="maan-input-group">
                            <label for="passs">{{ __('Confirmation Password') }}</label>
                            <div class="password-area">
                                <input id="passs" type="password" class="form-control" placeholder="Password" name="password_confirmation" required>
                                <div toggle="#passs" class="field-icon toggle-pas">
                                    <svg class="eye-show" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 511.992 511.992"><path d="M510.096,249.937c-4.032-5.867-100.928-143.275-254.101-143.275C124.56,106.662,7.44,243.281,2.512,249.105
                                                c-3.349,3.968-3.349,9.792,0,13.781C7.44,268.71,124.56,405.329,255.995,405.329S504.549,268.71,509.477,262.886
                                                C512.571,259.217,512.848,253.905,510.096,249.937z M255.995,383.996c-105.365,0-205.547-100.48-230.997-128
                                                c25.408-27.541,125.483-128,230.997-128c123.285,0,210.304,100.331,231.552,127.424
                                                C463.013,282.065,362.256,383.996,255.995,383.996z"/><path d="M255.995,170.662c-47.061,0-85.333,38.272-85.333,85.333s38.272,85.333,85.333,85.333s85.333-38.272,85.333-85.333
                                                S303.056,170.662,255.995,170.662z M255.995,319.996c-35.285,0-64-28.715-64-64s28.715-64,64-64s64,28.715,64,64
                                                S291.28,319.996,255.995,319.996z"/></svg>

                                    <svg class="eye-close" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512.001 512.001"><path d="M316.332,195.662c-4.16-4.16-10.923-4.16-15.083,0c-4.16,4.16-4.16,10.944,0,15.083
                                                c12.075,12.075,18.752,28.139,18.752,45.248c0,35.285-28.715,64-64,64c-17.109,0-33.173-6.656-45.248-18.752
                                                c-4.16-4.16-10.923-4.16-15.083,0c-4.16,4.139-4.16,10.923,0,15.083c16.085,16.128,37.525,25.003,60.331,25.003
                                                c47.061,0,85.333-38.272,85.333-85.333C341.334,233.187,332.46,211.747,316.332,195.662z"/><path d="M270.87,172.131c-4.843-0.853-9.792-1.472-14.869-1.472c-47.061,0-85.333,38.272-85.333,85.333
                                                c0,5.077,0.619,10.027,1.493,14.869c0.917,5.163,5.419,8.811,10.475,8.811c0.619,0,1.237-0.043,1.877-0.171
                                                c5.781-1.024,9.664-6.571,8.64-12.352c-0.661-3.627-1.152-7.317-1.152-11.157c0-35.285,28.715-64,64-64
                                                c3.84,0,7.531,0.491,11.157,1.131c5.675,1.152,11.328-2.859,12.352-8.64C280.534,178.702,276.652,173.155,270.87,172.131z"/><path d="M509.462,249.102c-2.411-2.859-60.117-70.208-139.712-111.445c-5.163-2.709-11.669-0.661-14.379,4.587
                                                c-2.709,5.227-0.661,11.669,4.587,14.379c61.312,31.744,110.293,81.28,127.04,99.371c-25.429,27.541-125.504,128-230.997,128
                                                c-35.797,0-71.872-8.64-107.264-25.707c-5.248-2.581-11.669-0.341-14.229,4.971c-2.581,5.291-0.341,11.669,4.971,14.229
                                                c38.293,18.496,77.504,27.84,116.523,27.84c131.435,0,248.555-136.619,253.483-142.443
                                                C512.854,258.915,512.833,253.091,509.462,249.102z"/><path d="M325.996,118.947c-24.277-8.171-47.829-12.288-69.995-12.288c-131.435,0-248.555,136.619-253.483,142.443
                                                c-3.115,3.669-3.371,9.003-0.597,12.992c1.472,2.112,36.736,52.181,97.856,92.779c1.813,1.216,3.84,1.792,5.888,1.792
                                                c3.435,0,6.827-1.664,8.875-4.8c3.264-4.885,1.92-11.52-2.987-14.763c-44.885-29.845-75.605-65.877-87.104-80.533
                                                c24.555-26.667,125.291-128.576,231.552-128.576c19.861,0,41.131,3.755,63.189,11.157c5.589,2.005,11.648-1.088,13.504-6.699
                                                C334.572,126.862,331.585,120.825,325.996,118.947z"/><path d="M444.865,67.128c-4.16-4.16-10.923-4.16-15.083,0L67.116,429.795c-4.16,4.16-4.16,10.923,0,15.083
                                                c2.091,2.069,4.821,3.115,7.552,3.115c2.731,0,5.461-1.045,7.531-3.115L444.865,82.211
                                                C449.025,78.051,449.025,71.288,444.865,67.128z"/></svg>
                                </div>
                            </div>
                            @error('password_confirmation')
                            <span class="text-danger">
                                            {{$message}}
                                        </span>
                            @enderror
                        </div>
                        <div class="maan-input-group">
                            <button class="maan-btn">{{ __('SIGN UP') }}</button>
                        </div>
                        <span>{{ __("Already member?") }} <a href="#signInModal" data-bs-toggle="modal" data-bs-dismiss="modal">{{ __('Sign in here') }}</a></span>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

@include('frontend.layouts._auth_drawer')
