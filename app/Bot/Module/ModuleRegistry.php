<?php

declare(strict_types=1);

namespace App\Bot\Module;

final class ModuleRegistry
{
    /**
     * @param BotModule[] $modules
     */
    public function __construct(
        private readonly array $modules = [],
    ) {
    }

    /**
     * @return BotModule[]
     */
    public function all(): array
    {
        return $this->modules;
    }

    public function run(): void
    {
        foreach ($this->modules as $module) {
            $module->run();
        }
    }
}
