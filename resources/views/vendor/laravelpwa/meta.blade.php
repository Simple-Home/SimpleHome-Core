<!-- Web Application Manifest -->
<link rel="manifest" href="{{ route('laravelpwa.manifest') }}">
<!-- Chrome for Android theme color -->
<meta name="theme-color" content="{{ $config['theme_color'] }}">

<!-- Add to homescreen for Chrome on Android -->
<meta name="mobile-web-app-capable" content="{{ $config['display'] == 'standalone' ? 'yes' : 'no' }}">
<meta name="application-name" content="{{ $config['short_name'] }}">
<link rel="icon" sizes="{{ data_get(end($config['icons']), 'sizes') }}"
    href="{{ data_get(end($config['icons']), 'src') }}">

<!-- Add to homescreen for Safari on iOS -->
<meta name="apple-mobile-web-app-capable" content="{{ $config['display'] == 'standalone' ? 'yes' : 'no' }}">
<meta name="apple-mobile-web-app-status-bar-style" content="{{ $config['status_bar'] }}">
<meta name="apple-mobile-web-app-title" content="{{ $config['short_name'] }}">
<link rel="apple-touch-icon" href="{{ data_get(end($config['icons']), 'src') }}">

@if (!empty($config['splash']))
    @foreach ($config['splash'] as $key => $splash)
        <link href="{{ asset($splash) }}"
            media="(device-width: {{ explode('x', $key)[0] }}px) and (device-height: {{ explode('x', $key)[1] }}px) and (-webkit-device-pixel-ratio: 2)"
            rel="apple-touch-startup-image" />
    @endforeach
@endif

<!-- Tile for Win8 -->
<meta name="msapplication-TileColor" content="{{ $config['background_color'] }}">
<meta name="msapplication-TileImage" content="{{ asset(data_get(end($config['icons']), 'src')) }}">

<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js">
</script>
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-messaging.js"></script>
<script type="text/javascript">
    // Initialize the service worker
    let newWorker;
    var refreshing;
    window.addEventListener('load', function() {

        // The click event on the notification
        $('body').on('click', 'a#reload', function(event) {
            newWorker.postMessage({
                action: 'skipWaiting'
            });
        });

        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register(
                "{{ asset('serviceworker.js', Request::server('HTTP_X_FORWARDED_PROTO') != 'http' ? true : '') }}", {
                    scope: 'https:{{ env('APP_URL') }}'
                }).then(function(registration) {
                    // Registration was successful
                    console.log(
                        'Laravel PWA: ServiceWorker registration successful with scope: ',
                        registration.scope);

                    registration.addEventListener('updatefound', function() {
                        console.log("Update Found");

                        newWorker = registration.installing;
                        newWorker.addEventListener('statechange', () => {
                            // Has service worker state changed?
                            switch (newWorker.state) {
                                case 'installed':
                                    console.log("Update installed");
                                    // There is a new service worker available, show the notification
                                    if (navigator.serviceWorker.controller) {
                                        let notification = document
                                            .getElementById(
                                                'notification');
                                        notification.className = 'd-block';
                                    }

                                    break;
                            }
                        });
                    });

                    if (Notification.permission === "granted") {
                        var firebaseConfig = {
                            apiKey: "{{ env('FIREBASE_API_KEY') }}",
                            authDomain: "{{ env('FIREBASE_AUTH_DOMAIN') }}",
                            databaseURL: "{{ env('FIREBASE_DB_URL') }}",
                            projectId: "{{ env('FIREBASE_PROJECT_ID') }}",
                            storageBucket: "{{ env('FIREBASE_STORAGE_BUCKET') }}",
                            messagingSenderId: "{{ env('FIREBASE_MESSAGING_SENDER_ID') }}",
                            appId: "{{ env('FIREBASE_AP_ID') }}"
                        };

                        if (!firebase.apps.length) {
                            firebase.initializeApp(firebaseConfig);
                        } else {
                            firebase.app(); // if already initialized, use that one
                        }

                        const messaging = firebase.messaging.isSupported() ?
                            firebase.messaging() :
                            null;

                        var pushtoken = localStorage.getItem('pushtoken') || null;


                        messaging.getToken({
                            vapidKey: '{{ env('FIREBASE_VAPY_KEY') }}',
                            serviceWorkerRegistration: registration
                        }).then(function(token) {
                            pushtoken = token;
                            localStorage.setItem('pushtoken', token);

                            $.ajax({
                                url: '{{ route('system.profile.notifications.subscribe') }}',
                                type: 'POST',
                                data: {
                                    token: pushtoken
                                },
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                        'content')
                                },
                                success: function(data) {
                                    console.log('saved', data);
                                },
                                error: function(error) {
                                    console.log(error);
                                }
                            });
                        });




                        console.log("token FCM", pushtoken);
                    }

                },
                function(err) {
                    // registration failed :(
                    console.log('Laravel PWA: ServiceWorker registration failed: ', err);
                });
        }

        navigator.serviceWorker.addEventListener('controllerchange', function() {
            if (refreshing) return;
            console.log("Update Reload");
            window.location.reload();
            refreshing = true;
        });

        navigator.serviceWorker.addEventListener('message', event => {
            if (event.data.action === 'refresh') {
                if (refreshing) return;
                console.log("Update Reload");
                window.location.reload();
                refreshing = true;
            }
        });
    });
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
        $('head meta[name="theme-color"]').attr('content', '{{ $config['theme_color'] }}');
    }

    if (!isMobile()) {
        $('head meta[name="theme-color"]').attr('content', '#1cca50');
    }
</script>
