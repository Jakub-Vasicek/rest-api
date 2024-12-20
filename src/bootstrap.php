<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Symfony\Component\Dotenv\Dotenv;

date_default_timezone_set('Europe/Prague');

require __DIR__ . '/../vendor/autoload.php';
$envFile = __DIR__ . '/../.env';

if (!file_exists($envFile)) {
    throw new \RuntimeException('Environment file not found. Please create .env file in the root directory.');
}

$dotenv = new Dotenv();
$dotenv->load($envFile);

// Instantiate PHP-DI ContainerBuilder
$containerBuilder = new ContainerBuilder();

// Set up dependencies
$dependencies = require __DIR__ . '/../app/dependencies.php';
$dependencies($containerBuilder);

// Build PHP-DI Container instance
return $containerBuilder->build();
