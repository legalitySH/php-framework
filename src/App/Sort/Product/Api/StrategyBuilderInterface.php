<?php

namespace App\Sort\Product\Api;

interface StrategyBuilderInterface
{
    public function build(string $type): StrategyInterface;
}
