<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CategoryRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: CategoryRepository::class)]
#[Table(name: 'categories')]
class Category
{
    #[Id]
    #[Column(type: Types::INTEGER)]
    #[GeneratedValue(strategy: "AUTO")]
    private int $id;

    #[Column(type: Types::TEXT, unique: true)]
    private string $name;

    #[Column(name: 'created_at', type: Types::DATETIME_MUTABLE)]
    private DateTime $createdAt;

    #[PrePersist]
    public function setAtCreatedValue(): void
    {
        $this->createdAt = new DateTime();
    }

    public function __construct()
    {
        $this->createdAt = new DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
