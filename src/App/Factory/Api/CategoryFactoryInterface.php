<?php

declare(strict_types=1);

namespace App\Factory\Api;

use App\Entity\Category;

interface CategoryFactoryInterface
{
    public function create(string $categoryName): Category;
}
