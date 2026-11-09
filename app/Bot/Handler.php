<?php

declare(strict_types=1);

namespace App\Bot;

use App\Bot\DTO\Account;
use App\Bot\Module\ModuleRegistry;
use App\Bot\Modules\Auth\Auth;

class Handler
{
    public function __construct(
        private readonly Auth $auth,
        private readonly ModuleRegistry $modules,
    ) {
    }

    public function run(): void
    {
        $this->auth->login(Account::fromArray(config('account')));
        $this->modules->run();
    }
}
