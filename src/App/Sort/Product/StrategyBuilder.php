<?php

declare(strict_types=1);

namespace App\Sort\Product;

use App\Sort\Product\Api\StrategyBuilderInterface;
use App\Sort\Product\Api\StrategyInterface;
use App\Sort\Product\Strategy\SortByPriceAscendingStrategy;
use App\Sort\Product\Strategy\SortByPriceDescendingStrategy;

class StrategyBuilder implements StrategyBuilderInterface
{
    public function build(string $type): StrategyInterface
    {
        return match ($type) {
            'price_ascending' => new SortByPriceAscendingStrategy(),
            default => new SortByPriceDescendingStrategy()
        };
    }
}
