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

    <!-- Styles -->
    <link href="https://necolas.github.io/normalize.css/8.0.1/normalize.css">
    <link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet">

    <meta name="color-scheme" content="dark light">

    <style>
        .nav-bar-padding {
            padding-bottom: 60px;
        }
    </style>

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
    <nav class="navbar fixed-bottom bg-light" style="z-index: 1056;">
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
    <script>
        window.addEventListener("load", function() {
            $('div.control-relay ').click(function(e) {
                navigator.vibrate([10]);
                thisObj = $(this);
                thisObj.html("<div class=\"spinner-border text-primary\" role=\"status\"></div>");

                console.log(thisObj.data("url"));

                $.ajax({
                    type: 'POST',
                    url: thisObj.data("url"),
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(msg) {
                        thisObj.html(msg.icon);
                        thisObj.data("url", msg.url)
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



    @yield('beforeBodyEnd')
</body>


<!-- Full screen modal -->
<div class="modal" id="notifications" tabindex="-1" aria-labelledby="notifications" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('simplehome.notification') }}</h5>
                <div class="btn-group">
                    <a data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-h"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="btn btn-primary dropdown-item" href="{{route('notifications.read', ['notification_id' => 'all'])}}">
                                readAll
                            </a>
                        </li>
                        <li>
                            <a class="btn btn-primary dropdown-item" href="{{route('notifications.delete', ['notification_id' => 'all'])}}">
                                deleteAll
                            </a>
                        </li>
                    </ul>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @foreach (Auth::user()->notifications as $notification)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="text-right text-nowrap">
                                <div class="d-flex justify-content-start">
                                    <div>
                                        @if(!empty($notification->data))
                                        <div class="h3 mb-0">
                                            {{$notification->data['title']}}
                                        </div>
                                        @endif
                                        <div class="p" style="color: #686e73;">
                                            {{$notification->created_at->diffForHumans()}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a class="p" href="{{route('notifications.delete', ['notification_id' => $notification->id])}}">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>

                        @if(empty($notification->read_at))
                        <a href="{{route('notifications.read', ['notification_id' => $notification->id])}}">mark as read</a>
                        @endif
                        @if(!empty($notification->data))
                        <p>{{$notification->data['message']}}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>


</html>