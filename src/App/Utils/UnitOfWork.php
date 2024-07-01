<?php

declare(strict_types=1);

namespace App\Utils;

use App\Model\Database;

class UnitOfWork
{
    public static Database $db;

    public static function getDb(): Database
    {
        if (!isset(self::$db)) {
            self::$db = new Database();
        }

        return self::$db;
    }

    public static function setDb(Database $db): void
    {
        self::$db = $db;
    }
}
