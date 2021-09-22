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

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <script src="https://kit.fontawesome.com/9c343c1f2d.js" crossorigin="anonymous"></script>

    <!-- Styles -->
    <link href="https://necolas.github.io/normalize.css/8.0.1/normalize.css">
    <link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet">

    <meta name="color-scheme" content="dark light">

    <style>
        .nav-bar-padding {
            padding-bottom: 60px;
        }
    </style>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous">
    </script>
    <script>
        window.addEventListener("load", function() {
            $('button.relay ').click(function(e) {
                navigator.vibrate([10]);
                thisObj = $(this);
                thisObj.html("<div class=\"spinner-border text-primary\" role=\"status\"><span class=\"sr-only\"> Loading... </span></div>");
                console.log(thisObj.data("url"));
                $.ajax({
                    type: 'POST',
                    url: thisObj.data("url"),
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(msg) {
                        thisObj.html(msg.icon);
                    },
                    error: function() {
                        //timeout
                    },
                    timeout: 3000,
                });
            });

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

    @yield('customHead')

    <!-- PWA Manifest -->
    @laravelPWA
</head>

<body>
    <div class="container  nav-bar-padding">
        <div class="row justify-content-between">
            <div class="col-4 p-md-0">
                <h1 class="mb-0">@yield('title')</h1>
            </div>
        </div>

        {{--
            <div class="row">
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
            </div>
        --}}

        <div class="row">
            <div class="col p-md-0">
                <nav class="navbar p-0 overflow-auto text-nowrap">
                    <div class="container-fluid p-0 mb-1">
                        <div class="navbar-expand w-100">
                            <ul class="navbar-nav nav-pills">
                                @auth
                                @yield('subnavigation')
                                @endif
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


    <script src="{{ asset(mix('js/app.js')) }}"></script>
    @yield('beforeBodyEnd')
</body>

</html>