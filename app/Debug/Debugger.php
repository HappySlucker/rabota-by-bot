<?php

declare(strict_types=1);

namespace App\Debug;

use Facebook\WebDriver\Remote\RemoteWebDriver;

class Debugger
{
    private const string DEFAULT_PATH = 'logs/debug';

    public function __construct(
        private readonly RemoteWebDriver $webDriver,
    ) {
    }

    public function isEnabled(): bool
    {
        return (bool) config('debug');
    }

    public function screenshot(string $name): void
    {
        $this->capture($name, 'png', function (string $path): void {
            $this->webDriver->takeScreenshot($path);
        });
    }

    public function pageSource(string $name): void
    {
        $this->capture($name, 'html', function (string $path): void {
            file_put_contents($path, $this->webDriver->getPageSource());
        });
    }

    public function snapshot(string $name): void
    {
        $this->screenshot($name);
        $this->pageSource($name);
    }

    private function capture(string $name, string $extension, callable $writer): void
    {
        if (!$this->isEnabled()) {
            return;
        }

        $path = $this->path($name, $extension);

        try {
            $writer($path);
        } catch (\Throwable $e) {
            logger()->warning(sprintf('Unable to save debug artifact "%s": %s', $path, $e->getMessage()));
        }
    }

    private function path(string $name, string $extension): string
    {
        $directory = $this->directory();

        if (!is_dir($directory) && !mkdir($directory, 0777, true) && !is_dir($directory)) {
            throw new \RuntimeException(sprintf('Unable to create debug directory "%s".', $directory));
        }

        return sprintf(
            '%s/%s-%s.%s',
            $directory,
            (new \DateTimeImmutable())->format('Y-m-d_His_u'),
            $this->sanitize($name),
            $extension,
        );
    }

    private function directory(): string
    {
        $path = (string) config('debug_path', self::DEFAULT_PATH);

        if (str_starts_with($path, '/')) {
            return rtrim($path, '/');
        }

        return dirname(__DIR__, 2) . '/' . trim($path, '/');
    }

    private function sanitize(string $name): string
    {
        $sanitized = preg_replace('/[^a-zA-Z0-9_-]+/', '-', $name);

        return trim((string) $sanitized, '-') ?: 'debug';
    }
}
