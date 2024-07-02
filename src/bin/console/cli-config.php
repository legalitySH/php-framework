<?php

declare(strict_types=1);

use Symfony\Component\Console\Application;
use Doctrine\Migrations\Tools\Console\Command;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\CreateCommand as SchemaCreateCommand;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\UpdateCommand as SchemaUpdateCommand;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\DropCommand as SchemaDropCommand;

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../bootstrap.php';

$cli = new Application('Framework testing');
$cli->setCatchExceptions(true);


if (isset($dependencyFactory) && isset($entityManagerProvider)) {
    $cli->addCommands(array(
        new Command\CurrentCommand($dependencyFactory),
        new Command\DiffCommand($dependencyFactory),
        new Command\DumpSchemaCommand($dependencyFactory),
        new Command\ExecuteCommand($dependencyFactory),
        new Command\GenerateCommand($dependencyFactory),
        new Command\LatestCommand($dependencyFactory),
        new Command\ListCommand($dependencyFactory),
        new Command\MigrateCommand($dependencyFactory),
        new Command\RollupCommand($dependencyFactory),
        new Command\StatusCommand($dependencyFactory),
        new Command\SyncMetadataCommand($dependencyFactory),
        new Command\UpToDateCommand($dependencyFactory),
        new Command\VersionCommand($dependencyFactory),

        new SchemaCreateCommand($entityManagerProvider),
        new SchemaUpdateCommand($entityManagerProvider),
        new SchemaDropCommand($entityManagerProvider),
    ));
}

try {
    $cli->run();
} catch (Exception $e) {
    echo 'Console application error: ' . $e->getMessage() . PHP_EOL;
}
