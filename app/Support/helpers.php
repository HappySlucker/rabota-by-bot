<?php

declare(strict_types=1);

use App\Config\Config;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;

if (!function_exists('config')) {
    /**
     * Get / set the specified configuration value.
     *
     * If an array is passed as the key, we will assume you want to set an array of values.
     */
    function config(array|string|null $key = null, mixed $default = null): mixed
    {
        if (null === $key) {
            return new Config();
        }

        if (is_array($key)) {
            foreach ($key as $k => $value) {
                Config::set($k, $value);
            }

            return null;
        }

        return Config::get($key, $default);
    }
}

if (!function_exists('dd')) {
    function dd(mixed $data): void
    {
        var_dump($data);
        exit;
    }
}

if (!function_exists('dump')) {
    function dump(mixed $data): void
    {
        var_dump($data);
    }
}

if (!function_exists('logger')) {
    function logger(): Logger
    {
        static $logger = null;

        if ($logger === null) {
            $logger = new Logger(config('name'));

            if (!is_dir('logs')) {
                mkdir('logs', 0777, true);
            }

            $logger->pushHandler(new StreamHandler(
                'logs/parser.log',
                Level::Debug,
            ));

            $logger->pushHandler(new StreamHandler(
                'logs/parser_error.log',
                Level::Error,
            ));
        }

        return $logger;
    }
}
