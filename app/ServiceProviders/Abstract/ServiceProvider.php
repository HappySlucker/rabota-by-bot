<?php

declare(strict_types=1);

namespace App\ServiceProviders\Abstract;

abstract class ServiceProvider
{
    abstract public function register(): void;

    abstract public function boot(): void;
}
