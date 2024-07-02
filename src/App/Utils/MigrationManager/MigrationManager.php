<?php

declare(strict_types=1);

namespace App\Utils\MigrationManager;

use App\Utils\MigrationManager\Api\MigrationManagerInterface;
use App\Utils\MigrationManager\Enum\MigrationDestination;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Metadata\MigrationPlanList;
use Doctrine\Migrations\MigratorConfiguration;

class MigrationManager implements MigrationManagerInterface
{
    function __construct(private readonly DependencyFactory $dependencyFactory)
    {
    }

    public function createMigration(string $version): AbstractMigration
    {
        return $this->dependencyFactory->getMigrationFactory()->createVersion($version);
    }

    public function applyMigrations(array $versions): array
    {
        return $this->migrate($versions, MigrationDestination::UP);
    }

    public function rollupMigrations(array $versions): array
    {
        return $this->migrate($versions, MigrationDestination::DOWN);
    }

    public function getMigrations(): array
    {
        return $this->dependencyFactory->getMigrationRepository()->getMigrations()->getItems();
    }

    public function createEmptyMigration(): array
    {
        return [];
    }

    private function getMigrationPlanList(array $versions, string $destination): MigrationPlanList
    {
        return $this->dependencyFactory
            ->getMigrationPlanCalculator()
            ->getPlanForVersions($versions, $destination);
    }

    private function syncMetaDataStorage(): void
    {
        $this->dependencyFactory->getMetadataStorage()->ensureInitialized();
    }

    public function migrate(array $versions, MigrationDestination $destination): array
    {
        $this->syncMetaDataStorage();
        return $this->dependencyFactory->getMigrator()->migrate(
            $this->getMigrationPlanList($versions, MigrationDestination::UP->value),
            new MigratorConfiguration()
        );
    }

    public function getMigrationVersions(): array
    {
        $versions = [];
        $migrations = $this->getMigrations();

        foreach ($migrations as $migration) {
            $versions[] = $migration->getVersion();
        }

        return $versions;
    }
}
