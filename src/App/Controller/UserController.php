<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Factory\UserFactory;
use Doctrine\ORM\Exception\ORMException;
use App\App;

class UserController
{
    public function getUser(int $id): ?User
    {
        return App::getEntityManager()->getRepository(User::class)->find($id);
    }

    public function getByLogin(string $login): ?User
    {
        return App::getEntityManager()->getRepository(User::class)->findOneBy(['login' => $login]);
    }

    public function getAll(): array
    {
        return App::getEntityManager()->getRepository(User::class)->findAll();
    }

    public function remove(?string $id): bool
    {
        try {
            $user = $this->getUser((int)$id);

            if ($user === null) {
                return false;
            }

            App::getEntityManager()->remove($this->getUser((int)$id));
            App::getEntityManager()->flush();
            return true;
        } catch (ORMException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function add(?string $login, ?string $mail): bool
    {
        if ($login !== '' && $mail !== '') {
            $user = UserFactory::create($login, $mail, new \DateTime());

            try {
                App::getEntityManager()->persist($user);
                App::getEntityManager()->flush();
                return true;
            } catch (ORMException $e) {
                echo $e->getMessage();
                return false;
            }
        }

        return false;
    }
}
