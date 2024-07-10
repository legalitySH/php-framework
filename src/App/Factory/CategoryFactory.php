<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Category;
use App\Factory\Api\CategoryFactoryInterface;

class CategoryFactory implements CategoryFactoryInterface
{
    public function create(string $categoryName): Category
    {
        $category = new Category();

        $category->setName($categoryName);

        return $category;
    }
}
