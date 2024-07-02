<?php

declare(strict_types=1);

use App\App;
use App\Entity\User;
use Faker\Factory;

function generate(int $count): void
{
    $faker = Factory::create();


    for ($i = 0; $i < $count; $i++) {
        $newUser = new User();
        $newUser->setLogin($faker->name());
        $newUser->setMail($faker->email());
        $newUser->setRegistrationTime(new DateTime());

        try {
            App::getEntityManager()->persist($newUser);
        } catch (\Doctrine\ORM\Exception\ORMException $e) {
            echo $e->getMessage();
        }
    }
    try {
        App::getEntityManager()->flush();
    } catch (\Doctrine\ORM\Exception\ORMException $e) {
        echo $e->getMessage();
    }
}

generate(100);
