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
    public function add(Basket $basket): bool
    {
        $existingBasket = App::getEntityManager()->getRepository(Basket::class)->findOneBy([
            'product' => $basket->getProduct(),
            'user' => $basket->getUser()
        ]);

        if ($existingBasket !== null) {
            try {
                $this->incrementCountAndUpdateBasket($existingBasket);
                return true;
            } catch (\Exception $e) {
                return false;
            }
        } else {
            try {
                $this->createNewBasket($basket);

                return true;
            } catch (\Exception $e) {
                return false;
            }
        }
    }

    public function delete(int $id): ?Basket
    {
        $basket = App::getEntityManager()->getRepository(Basket::class)->find($id);

        try {
            App::getEntityManager()->remove($basket);
            App::getEntityManager()->flush();

            return $basket;

        } catch (OptimisticLockException | ORMException $e) {
            return null;
        }
    }

    private function incrementCountAndUpdateBasket(Basket $basket): void
    {
        $basket->setCount($basket->getCount() + 1);
        App::getEntityManager()->persist($basket);
        App::getEntityManager()->flush();
    }

    private function createNewBasket(Basket $basket): void
    {
        App::getEntityManager()->persist($basket);
        App::getEntityManager()->flush();
    }
}
