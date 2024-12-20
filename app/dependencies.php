<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use JakVas\Application\Components\Helpers\EnvironmentHelper;
use Symfony\Component\Cache\Adapter\PhpFilesAdapter;

return static function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        EntityManager::class => function (): EntityManager {
            $cacheDir = __DIR__ . '/../var/cache';

            $cache = new PhpFilesAdapter(
                'doctrine_queries',
                0,
                $cacheDir . '/doctrine'
            );

            $config = ORMSetup::createAttributeMetadataConfiguration(
                [__DIR__ . '/../src/Model/'],
                EnvironmentHelper::isDevelopmentEnvironment(),
                $cacheDir . '/doctrine_proxy',
                $cache
            );

            $connection = DriverManager::getConnection(
                [
                    'driver' => $_ENV['DB_DRIVER'],
                    'host' => $_ENV['DB_HOST'],
                    'port' => $_ENV['DB_PORT'],
                    'dbname' => $_ENV['DB_NAME'],
                    'user' => $_ENV['DB_USER'],
                    'password' => $_ENV['DB_PASSWORD'],
                    'charset' => $_ENV['DB_CHARSET'],
                ],
                $config
            );

            return new EntityManager($connection, $config);
        }
    ]);
};
