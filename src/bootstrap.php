<?php

declare(strict_types=1);

use Doctrine\DBAL\DriverManager;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\ExistingConfiguration;
use Doctrine\Migrations\Configuration\Connection\ExistingConnection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\Migrations\Configuration\Migration\YamlFile;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
use App\App;
use Dotenv\Dotenv;

require './vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dbParams = [
    'driver' => 'pdo_pgsql',
    'host' => $_ENV['POSTGRES_HOST'],
    'user' => $_ENV['POSTGRES_USER'],
    'password' => $_ENV['POSTGRES_PASSWORD'],
    'dbname' => $_ENV['POSTGRES_DBNAME']
];

$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: [__DIR__ . "/App/Entity"],
    isDevMode: true
);
$connection = DriverManager::getConnection($dbParams, $config);
$entityManager = new EntityManager($connection, $config);
$entityManagerProvider = new SingleManagerProvider($entityManager);

$migrationsConfig = new YamlFile(__DIR__ . '/config/package/doctrine_migrations.yaml');

$dependencyFactory = DependencyFactory::fromEntityManager($migrationsConfig, new ExistingEntityManager($entityManager));

$dependencyFactory->getMigrationRepository();

App::setEntityManager($entityManager);
App::setDependencyFactory($dependencyFactory);
App::init();
