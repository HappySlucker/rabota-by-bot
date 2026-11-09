<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use App\Application;
use Dotenv\Dotenv;

Dotenv::createImmutable(__DIR__)->safeLoad();

$app = Application::getInstance();
$app->run();