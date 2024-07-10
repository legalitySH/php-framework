<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Exception\ORMException;

class CategoryRepository extends EntityRepository
{
    public function find(mixed $id, int|null|LockMode $lockMode = null, int|null $lockVersion = null): ?User
    {
        try {
            return $this->getEntityManager()->find(Category::class, $id);
        } catch (ORMException $e) {
            echo $e->getMessage();
        }
        return null;
    }
}
