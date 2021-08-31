<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('pageTitle') - {{ config('app.name', 'Simple Home') }}</title>

    <!-- Scripts -->
    <script src="{{ asset(mix('js/manifest.js')) }}"></script>
    <script src="{{ asset(mix('js/vendor.js')) }}"></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <script src="https://kit.fontawesome.com/9c343c1f2d.js" crossorigin="anonymous"></script>

    <!-- Styles -->
    <link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet">
    <meta name="color-scheme" content="dark light">

    @yield('customHead')
</head>

<body class="m-2 m-md-4">
    <div class="justify-content-center">
        <div class="row">
            <div class="col">
                <h1 class="mb-0">@yield('title')</h1>
            </div>
            <div class="col text-right">
                <div class="align-middle">
                    <i class="d-inline fas fa-sun"></i>
                    <div class="d-inline custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="darkSwitch" />
                        <label class="custom-control-label" for="darkSwitch"></label>
                    </div>
                    <i class="d-inline fas fa-moon"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="overflow-auto text-nowrap">
        <nav class="navbar navbar-expand p-0">
            <ul class="navbar-nav mr-auto nav-pills">
                @auth
                @yield('subnavigation')
                @endif
            </ul>
        </nav>
    </div>

    <div>
        @yield('content')
    </div>

    <nav class="fixed-bottom navbar-expand bg-white py-2">
        <ul class="navbar-nav justify-content-center nav nav-fill nav-pills">
            @auth
            @include('components.navigation')
            @endif
        </ul>
    </nav>

    <script src="{{ asset(mix('js/app.js')) }}"></script>
    <script>
        window.addEventListener("load", function() {
            initTheme();
        });
    </script>
    @yield('beforeBodyEnd')
</body>

</html>