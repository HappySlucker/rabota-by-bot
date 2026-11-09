<?php

declare(strict_types=1);

return [
    'name' => (string) env('APP_NAME', 'RabotaBy Bot'),
    'url' => (string) env('APP_URL', 'https://rabota.by'),

    'debug' => (bool) env('APP_DEBUG', true),

    'account' => [
        'country' => (string) env('ACCOUNT_COUNTRY', 'BY'), // RU, BY, KZ, UZ
        'phone' => (string) env('ACCOUNT_PHONE', ''),
        'password' => (string) env('ACCOUNT_PASSWORD', ''),
    ],

    'selenium' => [
        'enabled' => (bool) env('SELENIUM_ENABLED', true),
        'port' => (int) env('SELENIUM_PORT', 4444),
        'delay_after_raising_in_s' => (int) env('SELENIUM_DELAY_AFTER_RAISING_IN_S', 5),
    ],

    'webdriver' => [
        'request_timeout_in_ms' => (int) env('WEBDRIVER_REQUEST_TIMEOUT_IN_MS', 240000),
        'url_loader' => [
            'max_attempts' => (int) env('WEBDRIVER_URL_LOADER_MAX_ATTEMPTS', 3),
            'retry_delay_seconds' => (int) env('WEBDRIVER_URL_LOADER_RETRY_DELAY_SECONDS', 5),
            'wait_time_seconds' => (int) env('WEBDRIVER_URL_LOADER_WAIT_TIME_SECONDS', 10),
        ],
        'wait' => [
            'timeout_in_seconds' => (int) env('WEBDRIVER_WAIT_TIMEOUT_IN_SECONDS', 5),
            'interval_in_milliseconds' => (int) env('WEBDRIVER_WAIT_INTERVAL_IN_MILLISECONDS', 500),
        ],
    ],

    'database' => [
        'driver' => (string) env('DB_DRIVER', 'mysql'),
        'host' => (string) env('DB_HOST', 'localhost'),
        'port' => (int) env('DB_PORT', 3306),
        'database' => (string) env('DB_DATABASE', ''),
        'username' => (string) env('DB_USERNAME', ''),
        'password' => (string) env('DB_PASSWORD', ''),
    ],
];
