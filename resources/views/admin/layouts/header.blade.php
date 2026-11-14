<nav class="main-header navbar navbar-expand navbar-light" style="background-color:#D9D9D9 !important; border-bottom:1px solid #c0c0c0;">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button" aria-label="{{ __('Toggle sidebar') }}"><i class="fas fa-bars"></i></a>
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
