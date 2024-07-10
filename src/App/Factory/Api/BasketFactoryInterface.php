<?php

declare(strict_types=1);

namespace App\Factory\Api;

use App\Entity\Basket;
use App\Entity\Product;
use App\Entity\User;

interface BasketFactoryInterface
{
    public function create(Product $product, User $user, int $count = 1): Basket;
}
