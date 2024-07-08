<?php

declare(strict_types=1);

namespace App;

use App\Utils\MigrationManager\MigrationManager;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\DataFixtures\Loader;
use Twig\Environment;

class App
{
    private static EntityManager $entityManager;

    private static DependencyFactory $dependencyFactory;

    private static MigrationManager $migrationManager;

    private static Loader $fixturesLoader;

    private static Environment $twigProvider;

    public static function getTwigProvider(): Environment
    {
        return self::$twigProvider;
    }

    public static function setTwigProvider(Environment $twigProvider): void
    {
        self::$twigProvider = $twigProvider;
    }


    public static function getFixturesLoader(): Loader
    {
        return self::$fixturesLoader;
    }

    public static function setFixturesLoader(Loader $fixturesLoader): void
    {
        self::$fixturesLoader = $fixturesLoader;
    }


    public static function init(): void
    {
        self::$migrationManager = new MigrationManager(self::$dependencyFactory);
    }

    public static function setDependencyFactory(DependencyFactory $dependencyFactory): void
    {
        self::$dependencyFactory = $dependencyFactory;
    }

    public static function getMigrationManager(): MigrationManager
    {
        return self::$migrationManager;
    }


    public static function getEntityManager(): EntityManager
    {
        return self::$entityManager;
    }

    public static function setEntityManager(EntityManager $entityManager): void
    {
        self::$entityManager = $entityManager;
    }
}
