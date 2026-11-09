<?php

declare(strict_types=1);

namespace App\Bot\Modules\UpdateResume;

use App\Bot\Module\BotModule;
use App\Bot\Modules\UpdateResume\Enums\ResumeElementSelector;
use App\Exception\ResumeUpdaterException;
use App\WebDriver\UrlLoader;
use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

class ResumeUpdater implements BotModule
{
    private const string RESUME_LIST_PAGE = '/applicant/resumes';

    public function __construct(
        private readonly RemoteWebDriver $webDriver,
        private readonly UrlLoader $urlLoader,
    ) {
    }

    public function name(): string
    {
        return 'resume_updater';
    }

    public function run(): void
    {
        $this->update();
    }

    public function update(): bool
    {
        try {
            $this->urlLoader->get(
                config('url') . self::RESUME_LIST_PAGE,
                ResumeElementSelector::PROFILE_BTN->value,
            );

            $this->webDriver->findElement(WebDriverBy::cssSelector(ResumeElementSelector::PROFILE_BTN->value))->click();

            try {
                $updateBtnElement = $this->webDriver->wait(
                    config('webdriver.wait.timeout_in_seconds'),
                    config('webdriver.wait.interval_in_milliseconds'),
                )->until(
                    WebDriverExpectedCondition::elementToBeClickable(
                        WebDriverBy::cssSelector(ResumeElementSelector::UPDATE_BTN->value),
                    ),
                );

                $updateBtnElement->click();

                return true;
            } catch (NoSuchElementException) {
                // Bcs the element may actually be missing and in this case it's normal
                return false;
            }
        } catch (\Throwable $e) {
            logger()->error($e->getMessage());

            throw new ResumeUpdaterException($e->getMessage());
        }
    }
}
