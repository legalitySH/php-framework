<?php

declare(strict_types=1);

namespace App;

use App\Utils\MigrationManager\MigrationManager;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\ORM\EntityManager;

class App
{
    private static EntityManager $entityManager;

    private static DependencyFactory $dependencyFactory;

    private static MigrationManager $migrationManager;


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
