<?php

declare(strict_types=1);

namespace App\Test\Resource\Fixture;

use App\Factory\CategoryFactory;
use App\Test\Tools\FakerProviderTrait;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CategoryFixture implements FixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        foreach (range(5, 10) as $i) {
            $category = (new CategoryFactory())->create('Category ' . $i);
            $manager->persist($category);
        }

        $manager->flush();
    }
}
