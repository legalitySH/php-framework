<?php

declare(strict_types=1);

namespace App\Repository;

use App\App;
use App\Entity\Basket;
use App\Factory\BasketFactory;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

class BasketRepository extends EntityRepository
{

    public function create($basket): void
    {
        App::getEntityManager()->persist($basket);
        App::getEntityManager()->flush();
    }
    public function delete(int $id): ?Basket
    {
        $basket = $this->find($id);

        try {
            App::getEntityManager()->remove($basket);
            App::getEntityManager()->flush();

            return $basket;
        } catch (OptimisticLockException | ORMException $e) {
            return null;
        }
    }


}
