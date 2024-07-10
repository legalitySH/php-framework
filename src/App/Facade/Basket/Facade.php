<?php

declare(strict_types=1);

namespace App\Facade\Basket;

use App\App;
use App\Entity\Basket;
use App\Entity\Product;
use App\Entity\User;
use App\Facade\Basket\Api\FacadeInterface;
use App\Factory\BasketFactory;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Exception;

class Facade implements FacadeInterface
{
    private EntityRepository $basketRepository;

    public function __construct()
    {
        $this->basketRepository = App::getEntityManager()->getRepository(Basket::class);
    }

    public function add(User $user, Product $product): bool
    {
        $factory = new BasketFactory();
        $basket = $factory->create($product, $user);

        $this->basketRepository->add($basket);

        return true;
    }

    public function getAll(User $user): array
    {
        return $this->basketRepository->findBy(['user' => $user]);
    }

    public function deleteById(int $id): ?Basket
    {
        return $this->basketRepository->delete($id);
    }

    public function get(User $user, Product $product): ?Basket
    {
        return $this->basketRepository->findOneBy(['user' => $user, 'product' => $product]);
    }

    public function getById(int $id): ?Basket
    {
        return $this->basketRepository->find($id);
    }
}
