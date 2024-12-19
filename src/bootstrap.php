<?php
declare(strict_types=1);

use DI\ContainerBuilder;

date_default_timezone_set('Europe/Prague');

require __DIR__ . '/../vendor/autoload.php';

// Instantiate PHP-DI ContainerBuilder
$containerBuilder = new \DI\ContainerBuilder();
$containerBuilder->addDefinitions([
    'doctrine.entity_manager' => function() {
        $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
            [__DIR__ . '/src'],
            true,
            null,
            null,
            false
        );
        $conn = [
            'driver' => 'pdo_mysql',
            'user' => 'app_user',
            'password' => 'app_password',
            'dbname' => 'app_db',
        ];
        return \Doctrine\ORM\EntityManager::create($conn, $config);
    },
]);
$container = $containerBuilder->build();

// Build PHP-DI Container instance
return $containerBuilder->build();
