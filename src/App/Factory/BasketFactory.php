<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Basket;
use App\Entity\Product;
use App\Entity\User;
use App\Factory\Api\BasketFactoryInterface;

class BasketFactory implements BasketFactoryInterface
{
    public function create(Product $product, User $user, int $count = 1): Basket
    {
        return (new Basket())->setCount($count)
            ->setProduct($product)
            ->setUser($user);
    }
}
