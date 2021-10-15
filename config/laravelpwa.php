<?php

return [
    'name' => 'LaravelPWA',
    'manifest' => [
        'name' => env('APP_NAME', 'My PWA App'),
        'short_name' => env('APP_NAME_SHORT', 'My PWA App Short Name'),       
        'start_url' => 'https:' . env('APP_URL', ''),
        'background_color' => '#F0F1F5',
        'theme_color' => '#F0F1F5',
        'display' => 'standalone',
        'orientation' => 'any',
        'status_bar' => 'black',
        'icons' => [
            '72x72' => [
                'path' => env('APP_URL', '') . '/images/icons/icon-72x72.png',
                'purpose' => 'any'
            ],
            '96x96' => [
                'path' => env('APP_URL', '') . '/images/icons/icon-96x96.png',
                'purpose' => 'any'
            ],
            '128x128' => [
                'path' => env('APP_URL', '') . '/images/icons/icon-128x128.png',
                'purpose' => 'any'
            ],
            '144x144' => [
                'path' => env('APP_URL', '') . '/images/icons/icon-144x144.png',
                'purpose' => 'any'
            ],
            '152x152' => [
                'path' => env('APP_URL', '') . '/images/icons/icon-152x152.png',
                'purpose' => 'any'
            ],
            '192x192' => [
                'path' => env('APP_URL', '') . '/images/icons/icon-192x192.png',
                'purpose' => 'any'
            ],
            '384x384' => [
                'path' => env('APP_URL', '') . '/images/icons/icon-384x384.png',
                'purpose' => 'any'
            ],
            '512x512' => [
                'path' => env('APP_URL', '') . '/images/icons/icon-512x512.png',
                'purpose' => 'any'
            ],
        ],
        'splash' => [],
        'shortcuts' => [],
        'custom' => [
            'appleMobileWebAppCapable' => 'yes',
            'appleMobileWebAppStatusBarStyle' => 'black-translucent',
                    'description' => env('APP_DESCRIPTION', 'My PWA App Desc'),
                    "title_bar_color" => "#1cca50",
                    "display_override" => ["window-controls-overlay"]
        ]
    ]
];
