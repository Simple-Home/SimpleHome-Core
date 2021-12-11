<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('app.name', 'Simple Home') }}</title>

    <!-- Scripts -->
    <script src="{{ asset(mix('js/manifest.js'), Request::server('HTTP_X_FORWARDED_PROTO') != 'http' ? true : '') }}" defer>
    </script>
    <script src="{{ asset(mix('js/vendor.js'), Request::server('HTTP_X_FORWARDED_PROTO') != 'http' ? true : '') }}" defer>
    </script>
    <script src="{{ asset(mix('js/app.js'), Request::server('HTTP_X_FORWARDED_PROTO') != 'http' ? true : '') }}" defer>
    </script>

    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"
        defer></script>
    <script type="text/javascript"
        src="{{ asset('js/bootstrap-iconpicker.bundle.min.js', Request::server('HTTP_X_FORWARDED_PROTO') != 'http' ? true : '') }}"
        defer></script>

    <!-- Styles -->
    <link href="https://necolas.github.io/normalize.css/8.0.1/normalize.css">
    <link href="{{ asset(mix('css/app.css'), Request::server('HTTP_X_FORWARDED_PROTO') != 'http' ? true : '') }}"
        rel="stylesheet">
    <meta name="color-scheme" content="dark light">

    <link rel="stylesheet"
        href="{{ asset('css/bootstrap-iconpicker.min.css', Request::server('HTTP_X_FORWARDED_PROTO') != 'http' ? true : '') }}" />

    @yield('customHead')

    <style>
        .nav-bar-padding {
            padding-bottom: 60px;
        }

    </style>
    <!-- PWA Manifest -->
    @laravelPWA
    <script src="{{ asset(mix('js/utillities.js'), Request::server('HTTP_X_FORWARDED_PROTO') != 'http' ? true : '') }}" defer>
    </script>

    <script
        src="{{ asset(mix('js/refresh-csrf.js'), Request::server('HTTP_X_FORWARDED_PROTO') != 'http' ? true : '') }}" defer>
        refreshCSRF('{{ route('system.refresh.csrf') }}');
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
    <div class="container">
        <div class="row">
            <div class="col p-md-0">
                @auth
                    @include('components.alerts')
                @endauth
            </div>
        </div>

        <div class="row nav-bar-padding">
            <div class="col p-md-0 mt-2">
                @auth
                    @yield('content')
                @endauth
            </div>
        </div>
    </div>
    </div>

    <!-- Botom Fixed Menu -->
    @if (!session('dashboard'))
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
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="notifications-list" data-url="{{ route('notifications.list') }}"></div>
                    </div>
                </div>
            </div>
        </div>
    @endauth

    @yield('beforeBodyEnd')
    <script src="{{ asset(mix('js/controls.js'), Request::server('HTTP_X_FORWARDED_PROTO') != 'http' ? true : '') }}" defer>
    </script>
    <script
        src="{{ asset(mix('js/notifications.js'), Request::server('HTTP_X_FORWARDED_PROTO') != 'http' ? true : '') }}" defer>
    </script>
</body>

</html>
