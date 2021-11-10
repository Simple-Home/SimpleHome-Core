<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="dark light">

    <link
        href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,600,700,800&amp;display=swap&amp;subset=latin-ext"
        rel="stylesheet">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    @hasSection('title')
        <title>@yield('title') - {{ config('app.name') }}</title>
    @else
        <title>{{ config('app.name') }}</title>
    @endif

    <!-- Scripts -->
    <script src="{{ asset(mix('js/manifest.js'), Request::server('HTTP_X_FORWARDED_PROTO') != 'http' ? true : '') }}">
    </script>
    <script src="{{ asset(mix('js/vendor.js'), Request::server('HTTP_X_FORWARDED_PROTO') != 'http' ? true : '') }}">
    </script>
    <script src="{{ asset(mix('js/app.js'), Request::server('HTTP_X_FORWARDED_PROTO') != 'http' ? true : '') }}">
    </script>
    <script src="{{ asset(mix('js/refresh-csrf.js'), Request::server('HTTP_X_FORWARDED_PROTO') != 'http' ? true : '') }}">
    </script>
    <script>
        refreshCSRF('{{ route('system.refresh.csrf') }}');
    </script>

    <script src="{{ asset(mix('js/utillities.js'), Request::server('HTTP_X_FORWARDED_PROTO') != 'http' ? true : '') }}">
    </script>

    <!-- Styles -->
    <link href="https://necolas.github.io/normalize.css/8.0.1/normalize.css">
    <link href="{{ asset(mix('css/app.css'), Request::server('HTTP_X_FORWARDED_PROTO') != 'http' ? true : '') }}"
        rel="stylesheet">
    <style>
        .nav-bar-padding {
            padding-bottom: 60px;
        }

        .custom-zoom {
            bottom: .5em;
            left: .5em;
        }

        .custom-zoom button {
            background-color: rgba(40, 40, 40, .7);
            border-radius: 50%;
        }

    </style>

    <!-- Custome Head -->
    @yield('customHead')

    <!--PWA Manifest-->
    @laravelPWA

    <script defer>
        var darkThemeSelected =
            localStorage.getItem("darkSwitch") !== null &&
            localStorage.getItem("darkSwitch") === "dark";

        if (darkThemeSelected) {
            localStorage.setItem("darkSwitch", "dark");
            $('head meta[name="theme-color"]').attr('content', '#111');
        } else {
            localStorage.removeItem("darkSwitch");
            $('head meta[name="theme-color"]').attr('content', "{{ $config['theme_color'] }}");
        }

        if (!isMobile()) {
            $('head meta[name="theme-color"]').attr('content', '#1cca50');
        }
    </script>
</head>

<body>
    <script defer>
        var darkThemeSelected =
            localStorage.getItem("darkSwitch") !== null &&
            localStorage.getItem("darkSwitch") === "dark";

        if (darkThemeSelected && document.body.getAttribute("data-theme") != "dark") {
            document.body.setAttribute("data-theme", "dark");
            console.log("darkmode-set");
        } else {
            document.body.removeAttribute("data-theme");
        }
    </script>
    <div class="container-fluid">
        <div class="row justify-content-between header ms-md-2">
            <div class="col-auto p-md-0 my-auto ">
                <h1 class="mb-0 header-title">@yield('title')</h1>
            </div>
            <div class="col-auto p-md-0 my-auto">
                <button class="navbar-toggler d-md-none border-3 text-primary" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>

        <div class="row m-0 m-md-2 mt-md-0">
            <div class="col-12 col-md-auto p-0 pe-md-2">
                <nav class="navbar navbar-expand-md sticky-top py-0">
                    <div class="collapse navbar-collapse nav-pills" id="navbarTogglerDemo01">
                        <div class="subNav ">
                            {{-- Menu Items Start --}}
                            <ul class="nav flex-column">
                                <li class="nav-item my-auto">
                                    <a class="nav-link {{ strpos(Route::currentRouteName(), 'profile') > -1 ? 'active' : '' }} ps-1"
                                        title="test" href="{{ route('system.profile') }}">
                                        <img src="{{ auth()->user()->getGavatarUrl() }}"
                                            alt="{{ auth()->user()->name }}" style="height: 30px; width:30px"
                                            class="my-auto rounded-circle border-primary border-3 ms-1">
                                        <span class="py-auto ms-1">{{ auth()->user()->name }}</span>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav flex-column">
                                <li class="nav-item my-auto">
                                    <p class="m-0">{{ __('general') }}</p>
                                </li>
                            </ul>
                            <ul class="nav flex-column">
                                <li class="nav-item my-auto ">
                                    <a class="nav-link  {{ strpos(Route::currentRouteName(), 'integrations') > -1 ? 'active' : '' }}"
                                        title="test" href="{{ route('system.integrations.list') }}">
                                        <i class="fas fa-th-large"></i>
                                        <span class="ms-md-2 ">{{ __('Integrations') }}</span></a>
                                </li>
                            </ul>
                            <ul class="nav flex-column">
                                <li class="nav-item my-auto ">
                                    <a class="nav-link {{ strpos(Route::currentRouteName(), 'housekeepings') > -1 ? 'active' : '' }}"
                                        title="test" href="{{ route('system.housekeepings') }}">
                                        <i class="fas fa-recycle"></i>
                                        <span class="ms-md-2 ">{{ __('Housekeeping') }}</span></a>
                                </li>
                            </ul>
                            <ul class="nav flex-column">
                                <li class="nav-item my-auto ">
                                    <a class="nav-link {{ strpos(Route::currentRouteName(), 'users') > -1 ? 'active' : '' }}"
                                        title="test" href="{{ route('system.users.list') }}">
                                        <i class="fas fa-users"></i>
                                        <span class="ms-md-2 ">{{ __('Users') }}</span></a>
                                </li>
                            </ul>
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link {{ strpos(Route::currentRouteName(), 'developments') > -1 ? 'active' : '' }}"
                                        href="{{ route('system.developments.index') }}">
                                        <i class=" fa fa-bell"></i>
                                        <span class="ms-md-2 ">{{ __('Developments') }}</span></a>
                                </li>
                            </ul>
                            <ul class="nav flex-column">
                                <li class="nav-item my-auto">
                                    <p class="m-0">{{ __('home') }}</p>
                                </li>
                            </ul>
                            <ul class="nav flex-column">
                                <li class="nav-item my-auto">
                                    <a class="nav-link {{ strpos(Route::currentRouteName(), 'rooms') > -1 ? 'active' : '' }}"
                                        title="test" href="{{ route('system.rooms.list') }}">
                                        <i class=" fa fa-home"></i>
                                        <span class="ms-md-2 ">{{ __('Rooms') }}</span></a>
                                </li>
                            </ul>
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link {{ strpos(Route::currentRouteName(), 'locations') > -1 ? 'active' : '' }}"
                                        href="{{ route('system.locations.index') }}">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span class="ms-md-2 ">{{ __('Locations') }}</span>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link {{ strpos(Route::currentRouteName(), 'devices') > -1 ? 'active' : '' }}"
                                        href="{{ route('system.devices.list') }}">
                                        <i class="fas fa-ethernet"></i>
                                        <span class="ms-md-2 ">{{ __('Devices') }}</span></a>
                                </li>
                            </ul>
                            <ul class="nav flex-column">
                                <li class="nav-item my-auto">
                                    <p class="m-0">{{ __('system') }}</p>
                                </li>
                            </ul>
                            <ul class="nav flex-column">
                                <li class="nav-item my-auto ">
                                    <a class="nav-link  {{ strpos(Route::currentRouteName(), 'diagnostics') > -1 ? 'active' : '' }}"
                                        title="test" href="{{ route('system.diagnostics.list') }}">
                                        <i class="fas fa-tachometer-alt"></i>
                                        <span class="ms-md-2 ">{{ __('Diagnostics') }}</span></a>
                                </li>
                            </ul>
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link {{ strpos(Route::currentRouteName(), 'settings') > -1 ? 'active' : '' }}"
                                        href="{{ route('system.settings.list') }}">
                                        <i class="fas fa-cog"></i>
                                        <span class="ms-md-2 ">{{ __('Settings') }}</span></a>
                                </li>
                            </ul>
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link {{ strpos(Route::currentRouteName(), 'backups') > -1 ? 'active' : '' }}"
                                        href="{{ route('system.backups') }}">
                                        <i class="fas fa-file-archive"></i>
                                        <span class="ms-md-2 ">{{ __('Backups') }}</span></a>
                                </li>
                            </ul>
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link {{ strpos(Route::currentRouteName(), 'logs') > -1 ? 'active' : '' }}"
                                        href="{{ route('system.logs') }}">
                                        <i class="fas fa-bug"></i>
                                        <span class="ms-md-2 ">{{ __('Logs') }}</span>
                                    </a>
                                </li>
                            </ul>
                            {{-- Menu Items End --}}

                        </div>
                    </div>
                </nav>
            </div>
            <div class="col p-0">
                <div class="col p-md-0">
                    @auth
                        @include('components.alerts')
                    @endauth
                </div>

                <div class="col p-md-0 d-none" id="notification">
                    <div class="card mb-2">
                        <div class="card-body d-flex justify-content-between mb-0">
                            <a class="btn btn-primary my-auto" id="reload" href="#">UPDATE</a>
                            <p class="ms-2 mb-0 my-auto"> new version of this app is available</p>
                        </div>
                    </div>
                </div>

                <div class="flex-grow-1 pb-3 nav-bar-padding">
                    <div class="col m-0">
                        @auth
                            @yield('content')
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <!-- Botom Fixed Menu -->
            <nav class="navbar fixed-bottom bg-light fw-900 p-0"
                style="z-index: 1056; height: 60px; font-size: 22px; padding-bottom: env(safe-area-inset-bottom);">
                <div class="container-fluid p-0">
                    <div class="navbar-expand w-100">
                        <ul class="navbar-nav justify-content-around nav-pills">
                            @auth
                                @include('components.navigation')
                            @endauth
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Full screen modal -->
    @auth
        @yield('modal')
        <div class="modal" id="notifications" tabindex="-1" aria-labelledby="notifications" aria-hidden="true"
            role="dialog">
            <div class="modal-dialog modal-fullscreen-md-down">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ __('simplehome.notification') }}
                        </h5>
                        <div class="btn-group">
                            <a data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-h"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a id="notification-control-load" class="btn btn-primary dropdown-item"
                                        data-url="{{ route('notifications.read', ['notification_id' => 'all']) }}">
                                        readAll
                                    </a>
                                </li>
                                <li>
                                    <a id="notification-control-load" class="btn btn-primary dropdown-item"
                                        data-url="{{ route('notifications.delete', ['notification_id' => 'all']) }}">
                                        deleteAll
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="notifications-list" data-url="{{ route('notifications.list') }}"></div>
                    </div>
                </div>
            </div>
        </div>
    @endauth

    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script
        src="{{ asset(mix('js/notifications.js'), Request::server('HTTP_X_FORWARDED_PROTO') != 'http' ? true : '') }}">
    </script>
    <script
        src="{{ asset(mix('js/push-notifications.js'), Request::server('HTTP_X_FORWARDED_PROTO') != 'http' ? true : '') }}">
    </script>
    <script src="{{ asset(mix('js/locators.js'), Request::server('HTTP_X_FORWARDED_PROTO') != 'http' ? true : '') }}">
    </script>
    @yield('beforeBodyEnd')
</body>

</html>
