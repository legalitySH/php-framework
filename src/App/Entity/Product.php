<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\Table;
use Exception;

#[Entity(repositoryClass: ProductRepository::class)]
#[Table(name: 'products')]
class Product
{
    #[Id]
    #[Column(type: Types::INTEGER)]
    #[GeneratedValue(strategy: "AUTO")]
    private int $id;

    #[Column(name: 'product_name', type: Types::TEXT)]
    private string $productName;

    #[Column(name: 'created_at', type: Types::DATETIME_MUTABLE)]
    private \DateTime $createdAt;


    #[Column(type: Types::FLOAT)]
    private float $cost;

    #[ManyToOne(targetEntity: Category::class)]
    #[JoinColumn(name: 'category_id', referencedColumnName: 'id')]
    private Category $category;

    #[PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new \DateTime();
    }

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function setProductName(string $product_name): void
    {
        $this->productName = $product_name;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    public function getCost(): float
    {
        return $this->cost;
    }

    public function setCost(float $cost): void
    {
        if ($cost < 0) {
            throw new \InvalidArgumentException('Cost cannot be negative');
        }
        $this->cost = $cost;
    }
}
