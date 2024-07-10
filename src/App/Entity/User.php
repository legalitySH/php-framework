<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: UserRepository::class)]
#[Table(name: 'users')]
class User
{
    #[Id]
    #[Column(type: Types::INTEGER)]
    #[GeneratedValue(strategy: "AUTO")]
    private int $id;

    #[Column(type: Types::TEXT)]
    private string $login;

    #[Column(type: Types::TEXT, nullable: true)]
    private ?string $mail;

    public function getMail(): string
    {
        return $this->mail;
    }

    public function setMail(string $mail): void
    {
        $this->mail = $mail;
    }

    #[Column(name: 'registration_time', type: Types::DATETIME_MUTABLE)]
    private DateTime $registrationTime;

    public function getId(): int
    {
        return $this->id;
    }


    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    public function getRegistrationTime(): DateTime
    {
        return $this->registrationTime;
    }

    public function setRegistrationTime(DateTime $registrationTime): void
    {
        $this->registrationTime = $registrationTime;
    }
}
