<?php

declare(strict_types=1);

namespace App\Controller;

use App\App;
use App\Entity\Product;
use App\Sort\Product\Api\StrategyInterface;
use App\Sort\Product\Sorter;
use App\Sort\Product\Strategy\SortByPriceDescendingStrategy;

class ProductController
{
    public function index(?StrategyInterface $sortStrategy = new SortByPriceDescendingStrategy()): void
    {
        echo App::getTwigProvider()->render('homepage.twig', [
            'products' => $this->getAllProducts($sortStrategy),
            'title' => 'Homepage'
        ]);
    }

    public function getAllProducts(?StrategyInterface $sortStrategy = new SortByPriceDescendingStrategy()): array
    {
       $sorter = new Sorter($sortStrategy);

       return $sorter->sort(App::getEntityManager()->getRepository(Product::class)->findAll());
    }
}
