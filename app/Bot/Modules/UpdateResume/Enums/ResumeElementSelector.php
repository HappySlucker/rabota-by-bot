<?php

declare(strict_types=1);

namespace App\Bot\Modules\UpdateResume\Enums;

enum ResumeElementSelector: string
{
    case PROFILE_BTN = '[data-qa="profileAndResumes-button"]';
    case UPDATE_BTN = '[data-qa="resume-recommendations__button_respond"]';
}
