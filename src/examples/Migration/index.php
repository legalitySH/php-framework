<?php

declare(strict_types=1);

use Example\Migration\Generator\UserGenerator;
use App\App;

require __DIR__ . '/../../bootstrap.php';


$migrationManager = App::getMigrationManager();
$entityManager = App::getEntityManager();

//$migrationManager->createMigration(\App\Migrations\Version202407021533_AddUserTable::class);
//$migrationManager->applyMigrations([\App\Migrations\Version202407021533_AddUserTable::class]);
//
//$userGenerator = new UserGenerator();
//$users = $userGenerator->generate(3);
//
//foreach ($users as $user) {
//    try {
//        $entityManager->persist($user);
//    } catch (\Doctrine\ORM\Exception\ORMException $e) {
//    }
//}
//
//$entityManager->flush();
//
//var_dump($entityManager->getRepository(\App\Entity\User::class)->findAll());


$migrationManager->createMigration(\App\Migrations\Version202407021542_AddMailColumnToUsers::class);
$migrationManager->applyMigrations([\App\Migrations\Version202407021542_AddMailColumnToUsers::class]);

$userGenerator = new UserGenerator();
$users = $userGenerator->generate(3);

foreach ($users as $user) {
    try {
        $entityManager->persist($user);
    } catch (\Doctrine\ORM\Exception\ORMException $e) {
    }
}

$entityManager->flush();

var_dump($entityManager->getRepository(\App\Entity\User::class)->findAll());
