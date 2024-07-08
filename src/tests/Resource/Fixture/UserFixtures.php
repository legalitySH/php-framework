<?php

declare(strict_types=1);

namespace App\Test\Resource\Fixture;

use App\Entity\User;
use App\Factory\UserFactory;
use App\Test\Tools\FakerTools;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures implements FixtureInterface
{
    use FakerTools;

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $newUser = UserFactory::create(
                $this->getFaker()->userName,
                $this->getFaker()->email,
                $this->getFaker()->dateTimeThisYear()
            );
            $manager->persist($newUser);
        }

        $manager->flush();
    }
}
