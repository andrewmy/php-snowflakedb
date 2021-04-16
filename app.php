<?php

declare(strict_types=1);

use App\Ui\Cli\ConnectCommand;
use App\Ui\Cli\TableCommand;
use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;
use Symfony\Component\Console\Application;

require_once './vendor/autoload.php';

try {
    (Dotenv::createImmutable(__DIR__))->load();
} catch (InvalidPathException $exception) {
    echo ".env file not found, please copy .env.example and fill in the values.";
    exit(1);
}

$app = new Application();
$app->add(new ConnectCommand());
$app->add(new TableCommand());

$app->run();