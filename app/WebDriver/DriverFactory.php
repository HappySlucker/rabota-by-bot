<?php

declare(strict_types=1);

namespace App\WebDriver;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

class DriverFactory
{
    public static function create(bool $isHeadless = true): RemoteWebDriver
    {
        $chromeOptions = new ChromeOptions();
        $isHeadless
            ? $chromeOptions->addArguments(
                [
                    '--headless',
                    '--blink-settings=imagesEnabled=false',
                    '--window-size=1920,1080',
                    '--no-sandbox',
                    '--disable-dev-shm-usage',
                ],
            )
            : $chromeOptions->addArguments(['--blink-settings=imagesEnabled=false']);
        $capabilities = DesiredCapabilities::chrome();
        $capabilities->setCapability(ChromeOptions::CAPABILITY_W3C, $chromeOptions);

        return RemoteWebDriver::create(
            'http://localhost:' . config('selenium.port') . '/wd/hub',
            $capabilities,
            request_timeout_in_ms: config('webdriver.request_timeout_in_ms'),
        );
    }
}
