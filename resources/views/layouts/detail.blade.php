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

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js" defer></script>
    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js" defer></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap-iconpicker.bundle.min.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <script src="https://kit.fontawesome.com/9c343c1f2d.js" crossorigin="anonymous"></script>

    <!-- Styles -->
    <link href="https://necolas.github.io/normalize.css/8.0.1/normalize.css">
    <link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet">
    <meta name="color-scheme" content="dark light">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap-iconpicker.min.css') }}" />

    @yield('customHead')

    <style>
        .nav-bar-padding {
            padding-bottom: 60px;
        }
    </style>

    <script>
        window.addEventListener("load", function() {
            var darkThemeSelected =
                localStorage.getItem("darkSwitch") !== null &&
                localStorage.getItem("darkSwitch") === "dark";
            if (darkThemeSelected) {
                document.body.setAttribute("data-theme", "dark");
            } else {
                document.body.removeAttribute("data-theme");
            }
        });
    </script>

    <!-- PWA Manifest -->
    @laravelPWA
</head>

<body>
    <div class="container nav-bar-padding">
        <div class="row">
            <div class="col p-md-0">
                @auth
                @include('components.alerts')
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