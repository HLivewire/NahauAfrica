<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{URL('/') }}" class="nav-link">{{ __('Frontend') }}</a>
        </li>
        <li class="nav-item dropdown  theme-color">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-palette"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
                <a href="#" class="dropdown-item theme-color violet @if($settings->theme_color=='theme-violet') active @endif " id="theme-violet" data-id="theme-violet" data-color="theme-violet" data-colortext="Violet">
                    {{__('Theme Violet')}}
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item theme-color brown @if($settings->theme_color=='theme-brown') active @endif" id="theme-brown" data-color="theme-brown" data-colortext="Brown">
                    {{__('Theme Brown')}}
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item theme-color blue @if($settings->theme_color=='theme-blue') active @endif" id="theme-blue" data-color="theme-blue" data-colortext="Blue">
                    {{__('Theme Blue')}}
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item theme-color magenta @if($settings->theme_color=='theme-magenta') active @endif" id="theme-magenta" data-color="theme-magenta" data-colortext="Magenta">
                    {{__('Theme Magenta')}}
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item theme-color green @if($settings->theme_color=='theme-green') active @endif" id="theme-green" data-color="theme-green" data-colortext="Green">
                    {{__('Theme Green')}}
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item theme-color orange @if($settings->theme_color=='theme-orange') active @endif" id="theme-orange" data-color="theme-orange" data-colortext=Orange">
                    {{__('Theme Orange')}}
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item theme-color pink @if($settings->theme_color=='theme-pink') active @endif" id="theme-pink" data-color="theme-pink" data-colortext="Pink">
                    {{__('Theme Pink')}}
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item theme-color dark @if($settings->theme_color=='theme-dark') active @endif" id="theme-dark" data-color="theme-dark" data-colortext="Dark">
                    {{__('Theme Dark')}}
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item theme-color red @if($settings->theme_color=='theme-red') active @endif" id="theme-red" data-color="theme-red" data-colortext="Red">
                    {{__('Theme Red')}}
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item theme-color maroon @if($settings->theme_color=='theme-maroon') active @endif" id="theme-maroon" data-color="theme-maroon" data-colortext="Maroon">
                    {{__('Theme Maroon')}}
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item theme-color rose @if($settings->theme_color=='theme-rose') active @endif" id="theme-rose" data-color="theme-rose" data-colortext="Rose">
                    {{__('Theme Rose')}}
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item theme-color broadcast @if($settings->theme_color=='theme-broadcast') active @endif" id="theme-broadcast" data-color="theme-broadcast" data-colortext="Broadcast Red">
                    {{__('Broadcast Red')}}
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item theme-color nahau @if($settings->theme_color=='theme-nahau') active @endif" id="theme-nahau" data-color="theme-nahau" data-colortext="NahauAfrica">
                    {{__('NahauAfrica Green')}}
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item theme-color black-white @if($settings->theme_color=='black-white') active @endif" id="black-white" data-color="black-white" data-colortext="Black & White">
                    {{__('Black & White')}}
                </a>

            </div>
        </li>

    </ul>

    <!-- Right navbar links -->

    <ul class="navbar-nav ml-auto align-items-center">
        <li class="nav-item d-none d-md-block"><button type="button" class="dx-iconbtn" id="dxFull" aria-label="{{ __('Toggle fullscreen') }}"><i class="fas fa-expand"></i></button></li>
        <li class="nav-item"><button type="button" class="dx-iconbtn" id="dxTheme" aria-label="{{ __('Toggle theme') }}"><i class="fas fa-sun i-sun"></i><i class="fas fa-moon i-moon"></i></button></li>

        @php
            $dxU = auth()->user();
            $dxName = $dxU->user_name ?? $dxU->name ?? 'Admin';
            $dxType = (string) ($dxU->user_type ?? '');
            $dxRole = ['4' => __('Super Admin'), '3' => __('Admin'), '2' => __('Editor')][$dxType] ?? __('Staff');
            $dxIni = strtoupper(mb_substr($dxName, 0, 2));
            try {
                $nMsgs = \App\Models\Contact::orderByDesc('id')->limit(3)->get(['name','created_at']);
                $nSubs = \App\Models\Maanuser::orderByDesc('id')->limit(3)->get(['first_name','last_name','created_at']);
                $nDraft = \App\Models\News::where('status', 0)->count();
                $nNew = \App\Models\Contact::where('created_at', '>=', now()->subDays(7))->count() + \App\Models\Maanuser::where('created_at', '>=', now()->subDays(7))->count() + $nDraft;
            } catch (\Throwable $e) { $nMsgs = collect(); $nSubs = collect(); $nDraft = 0; $nNew = 0; }
        @endphp
        <li class="nav-item dropdown dx-notif">
            <button type="button" class="dx-iconbtn dx-bell" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label="{{ __('Notifications') }}">
                <i class="far fa-bell"></i>@if($nNew)<span class="dx-dot"></span>@endif
            </button>
            <div class="dropdown-menu dropdown-menu-right dx-pop dx-pop--notif">
                <div class="dx-pop-h"><b>{{ __('Notifications') }}</b>@if($nNew)<span class="dx-pill">{{ $nNew }} {{ __('new') }}</span>@endif</div>
                @if($nDraft)<a class="dx-pop-i" href="{{ route('admin.news') }}"><span class="ic warn"><i class="fas fa-pen-square"></i></span><span><b>{{ $nDraft }} {{ __('drafts waiting') }}</b><small>{{ __('Review and publish') }}</small></span></a>@endif
                @foreach($nMsgs as $m)<a class="dx-pop-i" href="{{ route('admin.contact') }}"><span class="ic info"><i class="fas fa-envelope"></i></span><span><b>{{ __('Message from') }} {{ $m->name }}</b><small>{{ $m->created_at?->diffForHumans() }}</small></span></a>@endforeach
                @foreach($nSubs as $u)<a class="dx-pop-i" href="{{ route('admin.subscriber') }}"><span class="ic ok"><i class="fas fa-user-plus"></i></span><span><b>{{ __('New subscriber') }}: {{ trim($u->first_name.' '.$u->last_name) }}</b><small>{{ $u->created_at?->diffForHumans() }}</small></span></a>@endforeach
                @if(!$nDraft && $nMsgs->isEmpty() && $nSubs->isEmpty())<p class="dx-pop-empty">{{ __('You are all caught up.') }}</p>@endif
            </div>
        </li>
        <li class="nav-item dropdown dx-user">
            <button type="button" class="dx-userbtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label="{{ __('Open user menu') }}">
                <span class="dx-uav">{{ $dxIni }}</span>
                <span class="dx-uinfo d-none d-md-block"><b>{{ $dxName }}</b><small><i class="fas fa-shield-alt"></i> {{ $dxRole }}</small></span>
                <i class="fas fa-chevron-down dx-uchev d-none d-sm-inline"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right dx-pop dx-pop--user">
                <div class="dx-pop-head"><b>{{ $dxName }}</b><small>{{ $dxU->email ?? '' }}</small></div>
                <a class="dx-pop-link" href="{{ route('admin.dashboard') }}"><i class="far fa-user"></i> {{ __('My Dashboard') }}</a>
                @can('isSuperAdmin')<a class="dx-pop-link" href="{{ route('admin.settings.index') }}"><i class="fas fa-cog"></i> {{ __('Account Settings') }}</a>@endcan
                <a class="dx-pop-link" href="{{ URL('/') }}" target="_blank" rel="noopener"><i class="fas fa-external-link-alt"></i> {{ __('View site') }}</a>
                <div class="dx-pop-sep"></div>
                <a class="dx-pop-link danger" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i> {{ __('Sign Out') }}</a>
            </div>
        </li>
    </ul>
    <!-- Raw Links -->

</nav>
