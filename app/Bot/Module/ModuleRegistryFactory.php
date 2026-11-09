<?php

declare(strict_types=1);

namespace App\Bot\Module;

use Psr\Container\ContainerInterface;

final class ModuleRegistryFactory
{
    public function __construct(
        private readonly ContainerInterface $container,
    ) {
    }

    public function create(): ModuleRegistry
    {
        $modules = [];

        foreach ((array) config('modules', []) as $name => $definition) {
            if (!($definition['enabled'] ?? false)) {
                continue;
            }

            $class = $definition['class'] ?? null;

            if (!is_string($class) || !is_a($class, BotModule::class, true)) {
                throw new \RuntimeException(sprintf(
                    'Module "%s" must point to a valid %s implementation.',
                    $name,
                    BotModule::class,
                ));
            }

            $modules[] = $this->container->get($class);
        }

        return new ModuleRegistry($modules);
    }
}
