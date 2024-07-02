<?php

declare(strict_types=1);

namespace App\Utils\MigrationManager\Enum;

enum MigrationDestination: string
{
    case UP = 'up';

    case DOWN = 'down';
}
