<?php

declare(strict_types=1);

namespace App\Bot\Modules\Auth\Enums;

enum AuthElementSelector: string
{
    case PHONE_DROP = '[data-qa="magritte-phone-input-calling-code"]';
    case COUNTRY_OPT = '[data-qa="magritte-select-option-%s"]';
    case PHONE_CODE_INPUT = '[data-qa="magritte-phone-input-calling-code-input"]';
    case PHONE_INPUT = '[data-qa="magritte-phone-input-national-number-input"]';
    case LOGIN_WITH_PASSWORD_BTN = '[data-qa="expand-login-by-password"]';
    case PASSWORD_INPUT = '[data-qa="applicant-login-input-password"]';
    case SUBMIT_LOGIN_BTN = '[data-qa="submit-button"]';
    case NOTIFICATION_BTN = '[data-qa="mainmenu_notifications"]';
}
