<?php

declare(strict_types=1);

namespace App\Test\Tools;

use Faker\Factory;
use Faker\Generator;

trait FakerProviderTrait
{
    protected function getFaker(): Generator
    {
        return Factory::create();
    }
}
