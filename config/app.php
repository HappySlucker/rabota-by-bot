<?php

return [
    'name' => 'RabotaBy Bot',
    'url' => 'https://rabota.by',

    'debug' => true,

    'account' => [
        'country' => 'BY', // RU, BY, KZ, UZ
        'phone' => '',
        'password' => ''
    ],

    'selenium' => [
        'enabled' => true,
        'port' => 4444,
        'delay_after_raising_in_s' => 5
    ],
    
    'webdriver' => [
        'request_timeout_in_ms' => 240000,
        'url_loader' => [
            'max_attempts' => 3,
            'retry_delay_seconds' => 5,
            'wait_time_seconds' => 10
        ],
        'wait' => [
            'timeout_in_seconds' => 5,
            'interval_in_milliseconds' => 500
        ]
    ],
    
    'database' => [
        'driver' => 'mysql',
        'host' => 'localhost',
        'port' => 3306,
        'database' => '',
        'username' => '',
        'password' => ''
    ],
]; 