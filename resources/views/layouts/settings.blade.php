<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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

    <!-- Styles -->
    <link href="https://necolas.github.io/normalize.css/8.0.1/normalize.css">
    <link href="{{ asset(mix('css/app.css'), Request::server('HTTP_X_FORWARDED_PROTO') != 'http' ? true : '') }}"
        rel="stylesheet">

    <meta name="color-scheme" content="dark light">

    <script>
        refreshCSRF('{{ route('system.refresh.csrf') }}');
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
        <div class="row m-2" style="overflow: auto">
            <div class="col-auto sidebar navbar-nav nav-pills sticky-top" style="font-size: 22px;">
                <ul class="nav flex-column ps-2">
                    <li class="nav-item my-auto">
                        <a class="nav-link btn-sq {{ strpos(Route::currentRouteName(), 'profile') > -1 ? 'active' : '' }}"
                            title="test" href="{{ route('system.profile') }}">
                            <i class="ms-3 fa fa-bell"></i>
                            <span class="d-none ms-md-2 d-md-inline">{{ __('Profile') }}</span></a>
                    </li>
                </ul>
                <ul class="nav flex-column ps-2">
                    <li class="nav-item my-auto btn-sq">
                        <a class="nav-link btn-sq {{ strpos(Route::currentRouteName(), 'diagnostics') > -1 ? 'active' : '' }}"
                            title="test" href="{{ route('system.diagnostics.list') }}">
                            <i class="ms-3 fa fa-bell"></i>
                            <span class="d-none ms-md-2 d-md-inline">{{ __('Diagnostics') }}</span></a>
                    </li>
                </ul>
                <ul class="nav flex-column ps-2">
                    <li class="nav-item my-auto btn-sq">
                        <a class="nav-link btn-sq {{ strpos(Route::currentRouteName(), 'integrations') > -1 ? 'active' : '' }}"
                            title="test" href="{{ route('system.integrations.list') }}">
                            <i class="ms-3 fa fa-bell"></i>
                            <span class="d-none ms-md-2 d-md-inline">{{ __('Integrations') }}</span></a>
                    </li>
                </ul>
                <ul class="nav flex-column ps-2">
                    <li class="nav-item my-auto btn-sq">
                        <a class="nav-link btn-sq {{ strpos(Route::currentRouteName(), 'housekeepings') > -1 ? 'active' : '' }}"
                            title="test" href="{{ route('system.housekeepings') }}">
                            <i class="ms-3 fa fa-bell"></i>
                            <span class="d-none ms-md-2 d-md-inline">{{ __('Housekeeping') }}</span></a>
                    </li>
                </ul>
                <ul class="nav flex-column ps-2">
                    <li class="nav-item my-auto btn-sq">
                        <a class="nav-link btn-sq {{ strpos(Route::currentRouteName(), 'users') > -1 ? 'active' : '' }}"
                            title="test" href="{{ route('system.users.list') }}">
                            <i class="ms-3 fa fa-bell"></i>
                            <span class="d-none ms-md-2 d-md-inline">{{ __('Users') }}</span></a>
                    </li>
                </ul>
                <ul class="nav flex-column ps-2">
                    <li class="nav-item my-auto btn-sq">
                        <a class="nav-link btn-sq {{ strpos(Route::currentRouteName(), 'rooms') > -1 ? 'active' : '' }}"
                            title="test" href="{{ route('system.rooms.list') }}">
                            <i class="ms-3 fa fa-bell"></i>
                            <span class="d-none ms-md-2 d-md-inline">{{ __('Rooms') }}</span></a>
                    </li>
                </ul>
                <ul class="nav flex-column ps-2">
                    <li class="nav-item btn-sq">
                        <a class="nav-link btn-sq {{ strpos(Route::currentRouteName(), 'backups') > -1 ? 'active' : '' }}"
                            href="{{ route('system.backups') }}">
                            <i class="ms-3 fa fa-bell"></i>
                            <span class="d-none ms-md-2 d-md-inline">{{ __('Backups') }}</span></a>
                    </li>
                </ul>
                <ul class="nav flex-column ps-2">
                    <li class="nav-item btn-sq">
                        <a class="nav-link btn-sq {{ strpos(Route::currentRouteName(), 'devices') > -1 ? 'active' : '' }}"
                            href="{{ route('system.devices.list') }}">
                            <i class="ms-3 fa fa-bell"></i>
                            <span class="d-none ms-md-2 d-md-inline">{{ __('Devices') }}</span></a>
                    </li>
                </ul>
                <ul class="nav flex-column ps-2">
                    <li class="nav-item btn-sq">
                        <a class="nav-link btn-sq {{ strpos(Route::currentRouteName(), 'settings') > -1 ? 'active' : '' }}"
                            href="{{ route('system.settings.list') }}">
                            <i class="ms-3 fa fa-bell"></i>
                            <span class="d-none ms-md-2 d-md-inline">{{ __('Settings') }}</span></a>
                    </li>
                </ul>
                <ul class="nav flex-column ps-2">
                    <li class="nav-item btn-sq">
                        <a class="nav-link btn-sq {{ strpos(Route::currentRouteName(), 'developments') > -1 ? 'active' : '' }}"
                            href="{{ route('system.developments.index') }}">
                            <i class="ms-3 fa fa-bell"></i>
                            <span class="d-none ms-md-2 d-md-inline">{{ __('Developments') }}</span></a>
                    </li>
                </ul>
                <ul class="nav flex-column ps-2">
                    <li class="nav-item btn-sq">
                        <a class="nav-link btn-sq {{ strpos(Route::currentRouteName(), 'logs') > -1 ? 'active' : '' }}"
                            href="{{ route('system.logs') }}">
                            <i class="ms-3 fa fa-bell"></i>
                            <span class="d-none ms-md-2 d-md-inline">{{ __('Logs') }}</span>
                        </a>
                    </li>
                </ul>
                <ul class="nav flex-column ps-2">
                    <li class="nav-item btn-sq">
                        <a class="nav-link btn-sq {{ strpos(Route::currentRouteName(), 'locations') > -1 ? 'active' : '' }}"
                            href="{{ route('system.locations.index') }}">
                            <i class="ms-3 fa fa-bell"></i>
                            <span class="d-none ms-md-2 d-md-inline">{{ __('Locations') }}</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col">
                <div class="row">
                    <div class="col p-md-0">
                        @auth
                            @include('components.alerts')
                        @endauth
                    </div>
                </div>
                <div class="row d-none" id="notification">
                    <div class="col p-md-0">
                        <div class="card mb-2">
                            <div class="card-body d-flex justify-content-between mb-0">
                                <a class="btn btn-primary my-auto" id="reload" href="#">UPDATE</a>
                                <p class="ms-2 mb-0 my-auto"> new version of this app is available</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row flex-grow-1 pb-3">
                    <div class="col p-md-0">
                        @auth
                            @yield('content')
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
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
</body>

</html>
