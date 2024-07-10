<?php

namespace App\Facade\Basket\Api;

use App\Entity\Basket;
use App\Entity\Product;
use App\Entity\User;

interface FacadeInterface
{
    public function add(User $user, Product $product): bool;

    public function getAll(User $user): array;

    public function deleteById(int $id): ?Basket;

    public function get(User $user, Product $product): ?Basket;

    public function getById(int $id): ?Basket;

}