<?php

declare(strict_types=1);

namespace App\Config;

class Config
{
    private static array $config = [];

    public static function get(string $key, $default = null)
    {
        return static::parseKey($key) ?? $default;
    }

    public static function set(string $key, $value): void
    {
        $keys = explode('.', $key);
        $config = &static::$config;

        foreach ($keys as $i => $key) {
            if ($i === count($keys) - 1) {
                $config[$key] = $value;

                break;
            }

            if (!isset($config[$key]) || !is_array($config[$key])) {
                $config[$key] = [];
            }

            $config = &$config[$key];
        }
    }

    public static function load(string $path): void
    {
        if (file_exists($path)) {
            $config = require $path;

            if (is_array($config)) {
                static::$config = array_merge(static::$config, $config);
            }
        }
    }

    private static function parseKey(string $key): mixed
    {
        $segments = explode('.', $key);
        $config = static::$config;

        foreach ($segments as $segment) {
            if (!is_array($config) || !array_key_exists($segment, $config)) {
                return null;
            }
            $config = $config[$segment];
        }

        return $config;
    }
}
