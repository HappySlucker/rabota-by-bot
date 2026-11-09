<?php

declare(strict_types=1);

use App\Bot\Modules\UpdateResume\ResumeUpdater;

return [
    'modules' => [
        'resume_updater' => [
            'enabled' => (bool) env('ENABLE_RESUME_UPDATER', true),
            'class' => ResumeUpdater::class,
        ],
    ],
];
