<?php

declare(strict_types=1);

namespace App\WebDriver;

use App\Exception\JsExecutorException;
use Facebook\WebDriver\Remote\RemoteWebDriver;

class JsExecutor
{
    public function __construct(
        private readonly RemoteWebDriver $webDriver,
    ) {
    }

    public function click(string $selector, int $timeout = 10): void
    {
        $endTime = microtime(true) + $timeout;

        do {
            $clicked = $this->webDriver->executeScript(
                <<<JS
                let el = document.querySelector(arguments[0]);
                if (el) { 
                    el.scrollIntoView({behavior: 'smooth', block: 'center'}); 
                    el.click(); 
                    return true; 
                } 
                return false;
                JS,
                [$selector],
            );

            if ($clicked) {
                return;
            }

            usleep(500_000);
        } while (microtime(true) < $endTime);

        $errorMessage = "Element matching selector '{$selector}' not found or not clickable";

        logger()->error($errorMessage);

        throw new JsExecutorException($errorMessage);
    }

    public function setInputValue(
        string $selector,
        string $text,
        string $attribute = 'value',
        int $timeout = 10,
    ): void {
        $endTime = microtime(true) + $timeout;

        do {
            $success = $this->webDriver->executeScript(
                <<<JS
                let el = document.querySelector(arguments[0]);
                if (!el) return false;
                el.scrollIntoView({behavior: 'smooth', block: 'center'});
                el[arguments[1]] = arguments[2];
                
                let eventInput = new Event('input', { bubbles: true });
                let eventChange = new Event('change', { bubbles: true });
                el.dispatchEvent(eventInput);
                el.dispatchEvent(eventChange);

                return true;
                JS,
                [$selector, $attribute, $text],
            );

            if ($success) {
                return;
            }

            usleep(500_000);
        } while (microtime(true) < $endTime);

        $errorMessage = "Element matching selector '{$selector}' not found or not editable";

        logger()->error($errorMessage);

        throw new JsExecutorException($errorMessage);
    }
}
