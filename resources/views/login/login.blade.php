<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @php
    $settings = settings();
    @endphp
    <meta charset="{{ config('app.charset') }}">
    <meta name="viewport" content="{{ __('width=device-width, initial-scale=1') }}">
    <!-- favicon -->
    <link rel="icon" href="{{ media_url($settings->favicon) }}">

    <title>{{ $settings->title }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="{{ asset('adminassets/fonts/google-font-sans.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminassets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('adminassets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminassets/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminassets/css/login.css') }}">
    <style>
        .forgetsec a{
            color: black;
            font-size: 13px;
            padding: 4px;
        }
        .forgetpass{
            padding-right: 20px;
        }
    </style>


</head>
<body>
    
<!-- /.login-box -->

<div class="new-login-section">
    <div class="row">
        <div class="col-md-6">
            <div class="login-bg"><img src="{{ asset('adminassets/img/login/login-bgjpg.jpg') }}" alt=""></div>
        </div>
    </div>
    <div class="login-form-section">
        <div class="row">
            <div class="col-md-6">
                <div class="login-left-img">
                    <img src="{{ asset('adminassets/img/login/login-left.png') }}" alt="">
                </div>
            </div>
            <div class="col-md-6">

                <div id="loginMessage">
                    @if (session()->has('message'))
                        <div class="alert alert-{{session('type')}}">
                            {{session('message')}}
                        </div>

                    @endif
                </div>
                <div class="new-login-form">
                    <form action="{{ route('login') }}" method="post">
                        @csrf
                        <h2>{{ __('Welcome to') }} <span>{{ __('Maan News') }}</span></h2>
                        <p> {{ __('Welcome back, Please login in to your account') }}</p>
                        <div class="login-input-item">
                            <div class="input-group">
                                <span class="left-img"><img src="{{ asset('adminassets/img/login/user.svg') }}" alt="icon"></span>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
                            </div>
                        </div>
                        <div class="login-input-item">
                            <div class="input-group">
                                <span class="left-img"><img src="{{ asset('adminassets/img/login/lock.svg') }}" alt="icon"></span>
                                <div class="input-wrp">
                                    <input type="password"  name="password" id="password"  class="form-control passwordhide" placeholder="Password">
                                    <span class="hide-pass"><img src="{{ asset('adminassets/img/login/eye-slash.svg') }}" alt="icon"></span>
                                    <span class="hideicon"><img src="{{ asset('adminassets/img/login/eye-slash.svg') }}" alt="icon"></span>
                                </div>
                            </div>
                        </div>
                        <div class="remember-check">
                            <label>
                                <input type="checkbox">
                                <span>{{ __('Remember me') }}</span>
                            </label>
                            <a href="#" class="forget-pass">{{ __('Forgot Password?') }}</a>
                        </div>
                        <button type="submit" class="login-btn" id="loginBtn"><span class="lg-spin" style="display:none;width:16px;height:16px;border:2px solid rgba(255,255,255,.5);border-top-color:#fff;border-radius:50%;animation:lgspin .7s linear infinite;vertical-align:-2px;margin-right:8px"></span>{{ __('LogIn') }}</button><style>@keyframes lgspin{to{transform:rotate(360deg)}}</style>
                        <div class="login-button-group">
                            <a href="#" class="login-btn" onclick="copy('superadmin21@gmail.com', 'superadmin21')" data-toggle="tooltip" data-placement="top">
                                <i class="fas fa-lock"></i>
                                {{ __('Super Admin') }}
                            </a>

                            <a href="#"  class="login-btn" onclick="copy('admin21@gmail.com', 'admin21')" data-toggle="tooltip" data-placement="top">
                                <i class="fas fa-lock"></i>
                                {{ __('Admin') }}
                            </a>

                            <a href="#"  class="login-btn" onclick="copy('editor21@gmail.com', 'editor21')" data-toggle="tooltip" data-placement="top">
                                <i class="fas fa-lock"></i>
                                {{ __('Editor') }}
                            </a>
                            <a href="#"  class="login-btn" onclick="copy('reporter21@gmail.com', 'reporter21')" data-toggle="tooltip" data-placement="top">
                                <i class="fas fa-lock"></i>
                                {{ __('Reporter') }}
                            </a>
                            <a href="#"  class="login-btn" onclick="copy('accountant21@gmail.com', 'accountant21')" data-toggle="tooltip" data-placement="top">
                                <i class="fas fa-lock"></i>
                                {{ __('Accountant') }}
                            </a>
                        </div>
                    <script>document.currentScript.parentNode.addEventListener("submit",function(e){var b=document.getElementById("loginBtn");b.style.pointerEvents="none";b.querySelector(".lg-spin").style.display="inline-block"});</script></form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="{{ asset('adminassets/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('adminassets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('adminassets/dist/js/adminlte.min.js') }}"></script>
<!-- Login JS -->
<script src="{{ asset('adminassets/js/login.js') }}"></script>

<script>
        $(".hide-pass").click(function() {
            $(".passwordhide").attr("type", "text");
            $(".hide-pass").hide();
            $(".hideicon").show();
        });
        
        $(".hideicon").click(function() {
            $(".passwordhide").attr("type", "password");
            $(".hideicon").hide();
            $(".hide-pass").show();
        });
</script>

</body>
</html>
