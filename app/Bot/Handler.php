<?php

declare(strict_types=1);

namespace App\Bot;

use App\Bot\DTO\Account;
use App\Bot\Module\ModuleRegistry;
use App\Bot\Modules\Auth\Auth;
use App\Exception\AuthException;

class Handler
{
    public function __construct(
        private readonly Auth $auth,
        private readonly ModuleRegistry $modules,
    ) {
    }

    public function run(): void
    {
        $account = Account::fromArray(config('account'));

        if (!$this->auth->login($account)) {
            throw new AuthException('Authorization failed.');
        }

        $this->modules->run();
    }
}
