<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Category;
use App\Entity\Product;
use App\Factory\Api\ProductFactoryInterface;

class ProductFactory implements ProductFactoryInterface
{
    public function create(string $productName, float $cost, Category $category): Product
    {
        $product = new Product();

        $product->setProductName($productName);
        $product->setCategory($category);
        $product->setCost($cost);

        return $product;
    }
}
