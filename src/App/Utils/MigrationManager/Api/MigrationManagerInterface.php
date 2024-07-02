<?php

declare(strict_types=1);

namespace App\Utils\MigrationManager\Api;

use App\Utils\MigrationManager\Enum\MigrationDestination;
use Doctrine\Migrations\AbstractMigration;

interface MigrationManagerInterface
{
    public function createMigration(string $version): AbstractMigration;

    public function applyMigrations(array $versions): array;

    public function rollupMigrations(array $versions): array;

    public function getMigrations(): array;

    public function createEmptyMigration(): array;

    public function migrate(array $versions, MigrationDestination $destination): array;

    public function getMigrationVersions(): array;
}
