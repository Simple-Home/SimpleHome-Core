<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@hasSection('title') @yield('title') - @endif {{ config('app.name', 'Simple Home') }}</title>

    <!-- Scripts -->
    <script src="{{ asset(mix('js/manifest.js')) }}"></script>
    <script src="{{ asset(mix('js/vendor.js')) }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>



    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <script src="https://kit.fontawesome.com/9c343c1f2d.js" crossorigin="anonymous"></script>


    <!-- Styles -->
    <link href="https://necolas.github.io/normalize.css/8.0.1/normalize.css">
    <link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet">
    <meta name="color-scheme" content="dark light">

    <!-- Bootstrap-Iconpicker -->
    <link rel="stylesheet" href="dist/css/bootstrap-iconpicker.min.css" />

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" />
    @yield('customHead')

    <!-- PWA Manifest -->
    @laravelPWA
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col p-md-0">
                @auth
                @yield('alerts')
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col p-md-0">
                @auth
                @yield('content')
                @endif
            </div>
        </div>

    </div>
    <!-- Botom Fixed Menu -->
    <nav class="navbar fixed-bottom bg-light">
        <div class="container-fluid">
            <div class="navbar-expand w-100">
                <ul class="navbar-nav justify-content-around nav-pills">
                    @auth
                    @include('components.navigation')
                    @endif
                </ul>
            </div>
        </div>
    </nav>


    @yield('beforeBodyEnd')
    <script src="{{ asset(mix('js/app.js')) }}"></script>
</body>

</html>