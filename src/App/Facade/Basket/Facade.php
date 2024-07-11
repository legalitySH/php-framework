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

class Facade implements FacadeInterface
{
    private EntityRepository $basketRepository;

    public function __construct(private readonly BasketFactory $basketFactory)
    {
        $this->basketRepository = App::getEntityManager()->getRepository(Basket::class);
    }

    public function add(User $user, Product $product): bool
    {
        try{
            if ($this->isExists($user, $product)) {
                $existingBasket = $this->get($user, $product);
                $basket = $existingBasket->setCount($existingBasket->getCount() + 1);
                $this->basketRepository->update($basket);
            }
            else {
                $this->basketRepository->create($this->basketFactory->create($product, $user));
            }

            return true;
        }
        catch (\Exception $e) {
            return false;
        }
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
        return $this->basketRepository->findOneBy([
            'user' => $user,
            'product' => $product
        ]);
    }

    public function getById(int $id): ?Basket
    {
        return $this->basketRepository->find($id);
    }

    private function isExists(User $user, Product $product): bool
    {
        return $this->get($user, $product) !== null;
    }
}
