<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Exception\ORMException;

class ProductRepository extends EntityRepository
{
}
