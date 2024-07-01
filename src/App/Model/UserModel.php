<?php

declare(strict_types=1);

namespace App\Model;

use PDO;

class UserModel
{
    public function __construct(protected Database $db)
    {
    }

    public function find($id): array
    {
        $stmt = $this->db->getPdo()->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAll(string $table = 'users'): array
    {
        $stmt = $this->db->getPdo()->prepare("SELECT * FROM {$table}");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function removeById(int $id, string $table = 'users'): void
    {
        $stmt = $this->db->getPdo()->prepare("DELETE FROM {$table} WHERE id= :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function add(string $login, string $table = 'users'): void
    {
        $stmt = $this->db->getPdo()->prepare("INSERT INTO  {$table}(login) VALUES(:login)");
        $stmt->bindParam(':login', $login);
        $stmt->execute();
    }
}
