<?php

return [

    'home_path' => env('SCRIBE_HOME'),

    'api' => [
        'url' => env('SCRIBE_API_URL'),

        'login' => env('SCRIBE_API_LOGIN', '/api/sanctum/token'),
    ],

    'timezone' => env('SCRIBE_TIMEZONE', 'America/New_York'),

];
