<?php

declare(strict_types=1);

namespace App\Sort\Product\Strategy;

use App\Sort\Product\Api\StrategyInterface;

class SortByPriceAscendingStrategy implements StrategyInterface
{
    public function sort(array $products): array
    {
        usort($products, fn($a, $b) => $a->getCost() > $b->getCost());
        return $products;
    }
}
