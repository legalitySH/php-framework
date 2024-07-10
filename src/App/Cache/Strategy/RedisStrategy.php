<?php

declare(strict_types=1);

namespace App\Cache\Strategy;

use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;
use Predis\Client;

class RedisStrategy implements CacheInterface
{
    function __construct(private readonly Client $client)
    {
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->client->get($key) ?? $default;
    }

    public function set(string $key, mixed $value, \DateInterval|int|null $ttl = null): bool
    {
        try {
            if ($ttl === null) {
                $this->client->set($key, $value);
            } else {
                $this->client->setex($key, $ttl, $value);
            }

            return true;
        } catch (InvalidArgumentException $e) {
            return false;
        }
    }

    public function delete(string $key): bool
    {
        try {
            $this->client->del($key);
            return true;
        } catch (InvalidArgumentException $e) {
            return false;
        }
    }

    public function clear(): bool
    {
        return (bool)$this->client->flushall();
    }

    public function getMultiple(iterable $keys, mixed $default = null): iterable
    {
        $values = [];

        foreach ($keys as $key) {
            $values[$key] = unserialize($this->get($key, $default));
        }

        return $values;
    }

    public function setMultiple(iterable $values, \DateInterval|int|null $ttl = null): bool
    {
        foreach ($values as $key => $value) {
            $this->set($key, serialize($value), $ttl);
        }

        return true;
    }

    public function deleteMultiple(iterable $keys): bool
    {
        foreach ($keys as $key) {
            $this->delete($key);
        }

        return true;
    }

    public function has(string $key): bool
    {
        return (bool)$this->client->exists($key);
    }
}
