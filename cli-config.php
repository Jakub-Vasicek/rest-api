<?php
declare(strict_types=1);

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\DBAL\DriverManager;
use Ramsey\Uuid\Doctrine\UuidType;

require 'vendor/autoload.php';

$config = new PhpFile('migrations.php');

$paths = [__DIR__.'/src/Model/'];

$ORMConfig = ORMSetup::createAttributeMetadataConfiguration($paths, true);
$connection = DriverManager::getConnection([
    'driver' => 'pdo_mysql',
    'host' => 'db',
    'port' => 3306,
    'dbname' => 'app_db',
    'user' => 'app_user',
    'password' => 'app_password',
]);

if (!Type::hasType('uuid')) {
    Type::addType('uuid', UuidType::class);
}

$entityManager = new EntityManager($connection, $ORMConfig);

return DependencyFactory::fromEntityManager($config, new ExistingEntityManager($entityManager));