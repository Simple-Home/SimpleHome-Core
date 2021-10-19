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

<script type="text/javascript">
    // Initialize the service worker

    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {

            navigator.serviceWorker.register(
                "{{ asset('serviceworker.js', Request::server('HTTP_X_FORWARDED_PROTO') != 'http' ? true : '') }}", {
                    scope: 'https:{{ env('APP_URL') }}'
                }).then(function(registration) {
                // Registration was successful
                console.log('Laravel PWA: ServiceWorker registration successful with scope: ',
                    registration.scope);

                registration.addEventListener('updatefound', function() {
                    console.log("Update Found");
                });

                var refreshing;
                registration.addEventListener('controllerchange', function() {
                    if (refreshing) return;
                    console.log("Update Reload");
                    window.location.reload();
                    refreshing = true;
                });

                if (registration.waiting) {
                    console.log('Service working in skipwaiting state.');
                }
            }, function(err) {
                // registration failed :(
                console.log('Laravel PWA: ServiceWorker registration failed: ', err);
            });
        });
    }
</script>
