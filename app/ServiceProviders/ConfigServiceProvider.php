<?php

declare(strict_types=1);

namespace App\ServiceProviders;

use App\Config\Config;
use App\ServiceProviders\Abstract\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $configPath = dirname(__DIR__, 2) . '/config/';

        foreach (glob($configPath . '*.php') as $configFile) {
            Config::load($configFile);
        }
    }

    public function boot(): void
    {
        // Nothing to boot for config
    }
}
