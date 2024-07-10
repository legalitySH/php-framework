<?php

declare(strict_types=1);

namespace App\Test\Resource\Fixture;

use App\Factory\ProductFactory;
use App\Test\Tools\FakerProviderTrait;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;
use App\App;

class ProductFixture implements FixtureInterface
{
    use FakerProviderTrait;

    public function load(ObjectManager $manager): void
    {
        $factory = new ProductFactory();

        foreach (range(1, 10) as $i) {
            $categories = App::getEntityManager()->getRepository(Category::class)->findAll();
            $category = $categories[array_rand($categories)];

            $product = $factory->create(
                'Product ' . $i,
                $this->getFaker()->randomFloat(2, 10, 100),
                $category
            );

            $manager->persist($product);
        }

        $manager->flush();
    }
}
