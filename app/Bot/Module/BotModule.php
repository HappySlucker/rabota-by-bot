<?php

declare(strict_types=1);

namespace App\Bot\Module;

interface BotModule
{
    public function name(): string;

    public function run(): void;
}
