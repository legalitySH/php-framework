<?php

declare(strict_types=1);

namespace App\Cache;

use DateInterval;
use Psr\SimpleCache\CacheInterface;

class CacheProvider implements CacheInterface
{
    public function __construct(private CacheInterface $cacheService)
    {
    }

    public function getCacheService(): CacheInterface
    {
        return $this->cacheService;
    }

    public function setCacheService(CacheInterface $cacheService): void
    {
        $this->cacheService = $cacheService;
    }


    public function get(string $key, mixed $default = null): mixed
    {
        return $this->cacheService->get($key, $default);
    }

    public function set(string $key, mixed $value, DateInterval|int|null $ttl = null): bool
    {
        return $this->cacheService->set($key, $value, $ttl);
    }

    public function delete(string $key): bool
    {
        return $this->cacheService->delete($key);
    }

    public function clear(): bool
    {
        return $this->cacheService->clear();
    }

    public function getMultiple(iterable $keys, mixed $default = null): iterable
    {
        return $this->cacheService->getMultiple($keys, $default);
    }

    public function setMultiple(iterable $values, \DateInterval|int|null $ttl = null): bool
    {
        return $this->cacheService->setMultiple($values, $ttl);
    }

    public function deleteMultiple(iterable $keys): bool
    {
        return $this->cacheService->deleteMultiple($keys);
    }

    public function has(string $key): bool
    {
        return $this->cacheService->has($key);
    }
}
