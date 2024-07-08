<?php

declare(strict_types=1);

namespace Example\Migration\Generator;

use App\Entity\User;
use App\Test\Tools\FakerTools;
use Laminas\Hydrator\ClassMethodsHydrator;

class UserGenerator
{
    use FakerTools;

    public function generate(int $count): array
    {
        $users = [];

        for ($i = 0; $i < $count; $i++) {
            $userData = [
                'login' => $this->getFaker()->name(),
                'mail' => $this->getFaker()->email(),
                'registration_time' => $this->getFaker()->dateTime(),
            ];

            $userHydrator = new ClassMethodsHydrator();
            $users[] = $userHydrator->hydrate($userData, new User());
        }

        return $users;
    }
}
