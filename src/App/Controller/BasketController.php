<?php

declare(strict_types=1);

namespace App\Controller;

use App\App;
use App\Entity\Basket;
use App\Entity\Product;
use App\Entity\User;
use App\Facade\Basket\Api\FacadeInterface;
use App\Facade\Basket\Facade;
use App\Facade\Basket\Facade as BasketFacade;
use App\Factory\BasketFactory;
use App\Proxy\Basket\BasketProxy;
use App\Repository\BasketRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Exception;

class BasketController
{
    public function __construct(private ?FacadeInterface $facade = null)
    {
        $this->facade = $facade ?? new BasketProxy(new Facade(new BasketFactory()));
    }
    public function index(): void
    {
        echo App::getTwigProvider()->render('basket.twig', [
            'title' => 'Basket',
            'basketOrders' => $this->getAll(App::getAuthorizedUser()),
            'isAuthorized' => App::getAuthorizedUser() !== null
        ]);
    }

    public function getAll(User $user): array
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
