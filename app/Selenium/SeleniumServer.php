<?php

declare(strict_types=1);

namespace App\Selenium;

use App\Exception\SeleniumServerException;

final class SeleniumServer
{
    private const string SELENIUM_NOT_FOUND = 'Selenium Server JAR not found.';
    private const string LOG_FILE = '/app/logs/selenium.log';

    public static function start(): void
    {
        self::stop();
        self::startSeleniumServer();

        sleep((int) config('selenium.delay_after_raising_in_s'));
    }

    public static function stop(): void
    {
        $commands = [
            'pkill -f selenium-server',
            'pkill -f chromedriver',
            "pkill -f 'chrome|google-chrome|chromium'",
        ];

        foreach ($commands as $command) {
            exec($command);
        }
    }

    private static function startSeleniumServer(): void
    {
        $seleniumServerJarPath = realpath(__DIR__ . '/../../selenium/selenium-server-standalone-3.141.59.jar');

        if ($seleniumServerJarPath === false) {
            throw new SeleniumServerException(self::SELENIUM_NOT_FOUND);
        }

        @mkdir(dirname(self::LOG_FILE), 0777, true);

        $command = sprintf(
            'nohup java -Dwebdriver.chrome.driver=/usr/bin/chromedriver -jar %s > %s 2>&1 &',
            escapeshellarg($seleniumServerJarPath),
            escapeshellarg(self::LOG_FILE),
        );

        exec($command);
    }
}
