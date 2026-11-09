<?php

declare(strict_types=1);

namespace App\Bot\Modules\Auth;

use App\Bot\DTO\Account;
use App\Bot\Modules\Auth\Enums\AuthElementSelector;
use App\Debug\Debugger;
use App\Exception\AuthException;
use App\WebDriver\JsExecutor;
use App\WebDriver\UrlLoader;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;

class Auth
{
    private const string LOGIN_PAGE = '/account/login?role=applicant';
    private const string LOGIN_PATH = '/account/login';

    public function __construct(
        private readonly RemoteWebDriver $webDriver,
        private readonly UrlLoader $urlLoader,
        private readonly JsExecutor $jsExecutor,
        private readonly Debugger $debugger,
    ) {
    }

    public function login(Account $account): bool
    {
        try {
            $this->urlLoader->get(
                config('url') . self::LOGIN_PAGE,
                AuthElementSelector::SUBMIT_LOGIN_BTN->value,
            );

            $this->webDriver->findElement(WebDriverBy::cssSelector(AuthElementSelector::SUBMIT_LOGIN_BTN->value))->click();
            $this->webDriver->findElement(WebDriverBy::cssSelector(AuthElementSelector::PHONE_DROP->value))->click();

            $this->selectCountry($account->country);
            $this->pastePhoneNumber($account->phone);
            $this->pastePassword($account->password);

            $this->debugger->screenshot('auth-form-filled');

            $this->webDriver->findElement(WebDriverBy::cssSelector(AuthElementSelector::SUBMIT_LOGIN_BTN->value))->click();

            $this->debugger->snapshot('auth-after-submit');

            return $this->isAuthorized();
        } catch (\Throwable $e) {
            $this->debugger->snapshot('auth-error');
            logger()->error($e->getMessage());

            throw new AuthException($e->getMessage());
        }
    }

    private function isAuthorized(): bool
    {
        try {
            $this->webDriver->wait(
                config('webdriver.wait.timeout_in_seconds'),
                config('webdriver.wait.interval_in_milliseconds'),
            )->until(
                static function (RemoteWebDriver $webDriver): bool {
                    if (!str_contains($webDriver->getCurrentURL(), self::LOGIN_PATH)) {
                        return true;
                    }

                    return $webDriver->findElements(
                        WebDriverBy::cssSelector(AuthElementSelector::NOTIFICATION_BTN->value),
                    ) !== [];
                },
            );

            return true;
        } catch (\Throwable) {
            $this->debugger->snapshot('auth-not-authorized');
            logger()->error(sprintf(
                'Authorization failed. URL: %s, title: %s',
                $this->webDriver->getCurrentURL(),
                $this->webDriver->getTitle(),
            ));

            return false;
        }
    }

    private function pastePassword(string $password): void
    {
        $this->jsExecutor->click(AuthElementSelector::LOGIN_WITH_PASSWORD_BTN->value);
        $this->jsExecutor->setInputValue(AuthElementSelector::PASSWORD_INPUT->value, $password);
    }

    private function pastePhoneNumber(string $phone): void
    {
        $code = $this->webDriver
            ->findElement(WebDriverBy::cssSelector(AuthElementSelector::PHONE_CODE_INPUT->value))
            ->getAttribute('value');

        $this->jsExecutor->setInputValue(
            AuthElementSelector::PHONE_INPUT->value,
            str_replace($code, '', $phone),
        );
    }

    private function selectCountry(string $country): void
    {
        $countrySelector = sprintf(AuthElementSelector::COUNTRY_OPT->value, strtoupper($country));
        $this->jsExecutor->click($countrySelector);
    }
}
