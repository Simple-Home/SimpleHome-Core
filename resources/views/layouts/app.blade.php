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
    <nav class="navbar bg-white navbar-expand">
        <ul class="navbar-nav mr-auto">
            @auth
            @yield('subnavigation')
            @endif
        </ul>
    </nav>
    <div class="container-fluid">
        @yield('content')
    </div>
    </div>
        <nav class="fixed-bottom navbar-expand  bg-white">
            <ul class="justify-content-center navbar-nav mr-auto">
                @auth
                @include('components.navigation')
                <li class="nav-item">
                    <div class="nav-link ">
                        <i class="d-inline fas fa-sun"></i>
                        <div class="d-inline custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="darkSwitch" />
                            <label class="custom-control-label" for="darkSwitch"></label>
                        </div>
                        <i class="d-inline fas fa-moon"></i>
                    </div>
                </li>
                @endif
            </ul>
        </nav>
    <script src="{{ asset(mix('js/app.js')) }}"></script>
    @yield('beforeBodyEnd')
</body>

</html>