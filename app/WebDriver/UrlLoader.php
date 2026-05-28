<?php

declare(strict_types=1);

namespace App\WebDriver;

use App\Exception\UrlLoaderException;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverWait;

class UrlLoader
{
    public function __construct(
        private readonly RemoteWebDriver $webDriver,
    ) {
    }

    /**
     * @throws \RuntimeException
     */
    public function get(string $url, ?string $cssSelector = null): bool
    {
        $maxAttempts = config('webdriver.url_loader.max_attempts');
        $retryDelaySeconds = config('webdriver.url_loader.retry_delay_seconds');
        $waitTimeSeconds = config('webdriver.url_loader.wait_time_seconds');

        $lastException = null;

        for ($attempt = 1; $attempt <= $maxAttempts; ++$attempt) {
            try {
                $this->webDriver->get($url);

                if ($cssSelector === null) {
                    return true;
                }

                $wait = new WebDriverWait($this->webDriver, $waitTimeSeconds);

                $wait->until(
                    WebDriverExpectedCondition::presenceOfElementLocated(
                        WebDriverBy::cssSelector($cssSelector),
                    ),
                );

                return true;
            } catch (\Throwable $e) {
                $lastException = $e;

                if ($attempt < $maxAttempts) {
                    sleep($retryDelaySeconds);
                }
            }
        }

        throw new UrlLoaderException(
            sprintf(
                'Page "%s" failed to load: element "%s" was not found after %d attempts.',
                $url,
                $cssSelector ?? '[selector not provided]',
                $maxAttempts,
            ),
            0,
            $lastException,
        );
    }
}
