<?php

declare(strict_types=1);

use Doctrine\DBAL\DriverManager;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\Migrations\Configuration\Migration\YamlFile;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Predis\Client;
use App\Cache\Strategy\RedisStrategy;
use App\App;
use Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php';

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

$dependencyFactory = DependencyFactory::fromEntityManager(
    $migrationsConfig,
    new ExistingEntityManager($entityManager)
);

$dependencyFactory->getMigrationRepository();

$fixturesLoader = new Loader();
$fixturesLoader->addFixture(new \App\Test\Resource\Fixture\CategoryFixture());
$fixturesLoader->addFixture(new \App\Test\Resource\Fixture\ProductFixture());

$twigLoader = new FilesystemLoader(__DIR__ . '/App/View');
$twigProvider = new Environment($twigLoader, [
    'cache' => false
]);

$client = new Client([
    'scheme' => 'tcp',
    'host' => $_ENV['REDIS_HOST'],
    'port' => $_ENV['REDIS_PORT']
]);

App::setCacheStrategy(new RedisStrategy($client));
App::setEntityManager($entityManager);
App::setDependencyFactory($dependencyFactory);
App::setFixturesLoader($fixturesLoader);
App::setTwigProvider($twigProvider);
App::init();
