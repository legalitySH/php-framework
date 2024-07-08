<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\User;
use DateTime;

class UserFactory
{
    public static function create(string $login, string $mail, DateTime $registrationTime): User
    {
        $newUser = new User();
        $newUser->setLogin($login);
        $newUser->setMail($mail);
        $newUser->setRegistrationTime($registrationTime);

        return $newUser;
    }
}
