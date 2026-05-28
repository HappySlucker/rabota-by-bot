<?php

declare(strict_types=1);

namespace App\Bot;

use App\Bot\DTO\Account;
use App\Bot\Modules\Auth\Auth;
use App\Bot\Modules\UpdateResume\ResumeUpdater;

class Handler
{
    public function __construct(
        private readonly Auth $auth,
        private readonly ResumeUpdater $resumeUpdater,
    ) {
    }

    public function run(): void
    {
        $this->auth->login(Account::fromArray(config('account')));
        $this->resumeUpdater->update();
    }
}
