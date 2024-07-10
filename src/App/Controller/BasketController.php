<?php

declare(strict_types=1);

namespace App\Controller;

use App\App;
use App\Entity\Basket;
use App\Entity\Product;
use App\Entity\User;
use App\Facade\Basket\Facade as BasketFacade;
use App\Factory\BasketFactory;
use App\Repository\BasketRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Exception;

class BasketController
{
    public function __construct(private ?BasketFacade $facade = null)
    {
        $this->facade = $facade ?? new BasketFacade();
    }
    public function index(): void
    {
        echo App::getTwigProvider()->render('basket.twig', [
            'title' => 'Basket',
            'basketOrders' => $this->facade->getAll(App::getEntityManager()->getRepository(User::class)->findAll()[0])
        ]);
    }

    public function getAllBasketOrders(User $user): array
    {
        return $this->facade->getAll($user) ?? [];
    }

    public function add(User $user, int $productId): bool
    {
        $product = App::getEntityManager()->getRepository(Product::class)->find($productId);
        return $this->facade->add($user, $product);
    }

    public function delete(int $id): ?Basket
    {
        return $this->facade->deleteById($id);
    }
}
