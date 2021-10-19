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

    <style>
        .nav-bar-padding {
            padding-bottom: 60px;
        }

    </style>

    @yield('customHead')

    <!-- PWA Manifest -->
    @laravelPWA

    <script src="{{ asset(mix('js/utillities.js'), Request::server('HTTP_X_FORWARDED_PROTO') != 'http' ? true : '') }}">

    </script>
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
    <div class="container nav-bar-padding h-100 d-flex flex-column">
        <div class="row justify-content-between header">
            @if (!session('dashboard'))
                <div class="col-auto p-md-0 my-auto">
                    <h1 class="mb-0 header-title">@yield('title')</h1>
                </div>
            @else
                <div class="col">
                    <h2 id='ct' class="my-auto my-auto"></h2>
                </div>
                <div class="col text-end my-auto">
                    <div>
                        <div class="h2 d-inline me-3">
                            <a onClick="$('#notifications').modal('toggle')">
                                <i class="fa fa-bell">
                                    <span
                                        class="position-absolute top-0 p-1 bg-danger border border-light rounded-circle d-inline d-md-none">
                                        <span class="visually-hidden">New alerts</span>
                                    </span>
                                </i>
                            </a>
                        </div>
                        <div class="h2 d-inline">
                            <a class="l1" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            @endif
            @if (strpos(Route::currentRouteName(), 'system') > -1)
                <div class="col my-auto text-end">
                    <a class="btn btn-danger" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('simplehome.logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            @elseif (strpos(Route::currentRouteName(), 'controls') > -1)
                <div class="col  my-auto">
                    <div class="avatars d-flex">
                        <div title="Haitem" class="avatar">
                            <img src="https://secure.gravatar.com/avatar/cfaee708dc7e5ff2259c45e186063f74" alt="Haitem">
                        </div>
                        <div title="Haitem" class="avatar is-offline">
                            <img src="https://secure.gravatar.com/avatar/cfaee708dc7e5ff2259c45e186063f74" alt="Haitem">
                        </div>
                        <div title="Haitem" class="avatar">
                            <img src="https://secure.gravatar.com/avatar/cfaee708dc7e5ff2259c45e186063f74" alt="Haitem">
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- <div class="row">
                <div class="col p-md-0">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                        <div class="card-footer">
                            Card footer
                        </div>
                    </div>
                </div>
            </div> --}}

        <div class="row">
            <div class="col p-md-0">
                <nav class="navbar p-0 overflow-auto text-nowrap no-scrool-bar" style="">

                    <div class="container-fluid p-0 mb-1">
                        <div class="navbar-expand w-100">
                            <ul class="navbar-nav nav-pills">
                                @auth
                                    @yield('subnavigation')
                                @endauth
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col p-md-0">
                @auth
                    @include('components.alerts')
                @endauth
            </div>
        </div>

        <div class="row flex-grow-1">
            <div class="col p-md-0">
                @auth
                    @yield('content')
                @endauth
            </div>
        </div>

        @if (!session('dashboard'))
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
        @endif
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
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="notifications-list" data-url="{{ route('notifications.list') }}"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endauth
        @if (session('dashboard'))
            <script>
                window.addEventListener("load", function() {
                    display_ct();
                });
            </script>
        @endif
        @yield('beforeBodyEnd')
        <script
                src="{{ asset(mix('js/notifications.js'), Request::server('HTTP_X_FORWARDED_PROTO') != 'http' ? true : '') }}">
        </script>
        <script
                src="{{ asset(mix('js/push-notifications.js'), Request::server('HTTP_X_FORWARDED_PROTO') != 'http' ? true : '') }}">
        </script>

        @if (strpos(Route::currentRouteName(), 'controls') > -1)
            <script src="{{ asset(mix('js/controls.js'), Request::server('HTTP_X_FORWARDED_PROTO') != 'http' ? true : '') }}">
            </script>
        @elseif (strpos(Route::currentRouteName(), 'automations') > -1)
            <script src="{{ asset(mix('js/automations.js'), Request::server('HTTP_X_FORWARDED_PROTO') != 'http' ? true : '') }}">
            </script>
        @endif
</body>

</html>
