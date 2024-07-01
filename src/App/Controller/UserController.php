<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Database;
use App\Model\UserModel;
use App\Utils\UnitOfWork;
use Exception;
use PDO;

class UserController
{
    public function __construct(protected ?UserModel $userModel = null)
    {
        $this->userModel = $userModel ?? new UserModel(UnitOfWork::getDb());
    }


    public function getUser(int $id): array
    {
        return $this->userModel->find($id);
    }

    public function getAll(): array
    {
        return $this->userModel->getAll();
    }

    public function remove(?string $id, string $table = 'users'): bool
    {
        if ($id === '') {
            echo 'Error id is null';
            return false;
        }
        $this->userModel->removeById(intval($id));
        return true;
    }

    /** @throws Exception */
    public function add(?string $login, string $table = 'users'): bool
    {
        if ($login === '') {
            throw new Exception('Empty login exception');
        }
        $this->userModel->add($login, $table);
        return true;
    }
}
