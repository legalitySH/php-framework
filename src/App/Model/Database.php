<?php

declare(strict_types=1);

namespace App\Model;

use PDO;
use PDOException;

class Database
{
    private \PDO $pdo;

    public function __construct()
    {
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        $connectionString = 'pgsql:host=postgres;dbname=users_db';

        try {
            $this->pdo = new PDO($connectionString, 'postgres', 'postgres', $options);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    public function setPdo(PDO $pdo): void
    {
        $this->pdo = $pdo;
    }
}
