<?php

declare(strict_types=1);

use App\Model\Database;
use App\Model\UserModel;
use App\Utils\UnitOfWork;

header('Content-Type: application/json');

UnitOfWork::setDb(new Database());

$userModel = new UserModel(UnitOfWork::getDb());

$allUsers = $userModel->getAll();

echo json_encode($allUsers);
