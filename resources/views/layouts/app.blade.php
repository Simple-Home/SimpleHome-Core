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

<body>
    <script>
        window.addEventListener("load", function() {
            initTheme();
        });
    </script>
    <div class="overflow-auto text-nowrap">
        <nav class="navbar navbar-expand">
            <ul class="navbar-nav mr-auto nav-pills">
                @auth
                @yield('subnavigation')
                @endif
            </ul>
        </nav>
    </div>
    <div class="container-fluid">
        @yield('content')
    </div>
    </div>

    <nav class="fixed-bottom navbar-expand bg-white  py-3">
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