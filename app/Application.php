<?php

declare(strict_types=1);

namespace App;

use App\Bot\Handler as BotHandler;
use App\Selenium\SeleniumServer;
use App\ServiceProviders\ConfigServiceProvider;
use App\WebDriver\DriverFactory;
use DI\ContainerBuilder;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Psr\Container\ContainerInterface;

class Application
{
    private static ?Application $instance = null;
    private ContainerInterface $container;

    private function __construct()
    {
        $this->setupContainer();
        $this->registerBaseProviders();
    }

    private function setupContainer(): void
    {
        $builder = new ContainerBuilder();

        $builder->addDefinitions([
            RemoteWebDriver::class => static function () {
                return DriverFactory::create(config('webdriver.headless', true));
            },
        ]);

        $this->container = $builder->build();
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function registerBaseProviders(): void
    {
        (new ConfigServiceProvider())->register();
    }

    public function run(): void
    {
        $this->init();

        try {
            $botHandler = $this->container->get(BotHandler::class);
            $botHandler->run();
        } finally {
            $this->terminate();
        }
    }

    private function init(): void
    {
        if (config('selenium.enabled', true)) {
            SeleniumServer::start();
        }
    }

    private function terminate(): void
    {
        if ($this->container->has(RemoteWebDriver::class)) {
            try {
                $this->container->get(RemoteWebDriver::class)->quit();
            } catch (\Throwable) {
            }
        }

        if (config('selenium.enabled', true)) {
            SeleniumServer::stop();
        }
    }
}
