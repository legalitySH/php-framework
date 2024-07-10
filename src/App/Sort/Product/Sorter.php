<?php

declare(strict_types=1);

namespace App\Sort\Product;

use App\Sort\Product\Api\StrategyInterface;

class Sorter
{
    private StrategyInterface $sortStrategy;

    public function __construct(StrategyInterface $sortStrategy)
    {
        $this->sortStrategy = $sortStrategy;
    }

    public function setSortStrategy(StrategyInterface $sortStrategy): void
    {
        $this->sortStrategy = $sortStrategy;
    }

    public function sort(array $products): array
    {
        return $this->sortStrategy->sort($products);
    }
}
