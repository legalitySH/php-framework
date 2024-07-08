<?php

declare(strict_types=1);

namespace App\Controller;

class CookieController
{
    public function getAllCookies(): array
    {
        return $_COOKIE;
    }

    public function createCookie(?string $key, ?string $value, ?string $expirationTime): void
    {
        setcookie($key, $value, time() + intval($expirationTime));
    }

    public function remove(?string $key): void
    {
        setcookie($key, '', time() - 3600);
    }
}
