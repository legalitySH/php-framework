<?php

namespace App\Sort\Product\Api;

use App\Entity\Product;

interface StrategyInterface
{
    public function sort(array $products): array;
}