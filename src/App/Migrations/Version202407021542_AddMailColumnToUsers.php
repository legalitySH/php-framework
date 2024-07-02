<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Exception as DBALException;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\Migrations\Exception\MigrationException;

class Version202407021542_AddMailColumnToUsers extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users ADD mail TEXT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users DROP mail');
    }
}
