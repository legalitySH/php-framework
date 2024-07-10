<?php

declare(strict_types=1);

namespace App\Factory\Api;

use App\Entity\Category;
use App\Entity\Product;

interface ProductFactoryInterface
{
    public function create(string $productName, float $cost, Category $category): Product;
}
