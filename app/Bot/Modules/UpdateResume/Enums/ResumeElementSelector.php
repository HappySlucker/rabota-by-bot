<?php

declare(strict_types=1);

namespace App\Bot\Modules\UpdateResume\Enums;

enum ResumeElementSelector: string
{
    case PROFILE_BTN = '[data-qa="profileAndResumes-button-text"]';
    case UPDATE_BTN = '[data-qa="resume-update-button resume-update-button_actions"]';
}
