<?php

declare(strict_types=1);

namespace App\Proxy\Basket;

use App\Entity\Basket;
use App\Entity\Product;
use App\Entity\User;
use App\Facade\Basket\Api\FacadeInterface;
use App\Facade\Basket\Facade;
use App\App;
use App\Factory\BasketFactory;

class BasketProxy implements FacadeInterface
{
    private ?Facade $facade = null;

    public function __construct(private readonly BasketFactory $factory)
    {
    }

    public function add(User $user, Product $product): bool
    {
        $result = false;

        if($this->isAuthorized($user)) {
            $result = $this->loadFacade()->add($user, $product);
        }

        return $result;
    }

    public function getAll(User $user): array
    {
        $users = [];
        
        if ($this->isAuthorized($user)) {
            $users = $this->loadFacade()->getAll($user);
        }

        return $users;
    }
    
    public function deleteById(int $id): ?Basket
    {
        if ($this->isAuthorized(App::getAuthorizedUser())) {
            return $this->loadFacade()->deleteById($id);
        }

        return null;
    }
    

    public function get(User $user, Product $product): ?Basket
    {
        if ($this->isAuthorized($user)) {
            return $this->loadFacade()->get($user, $product);
        }

        return null;
    }
    
    public function getById(int $id): ?Basket
    {
        if ($this->isAuthorized(App::getAuthorizedUser())) {
            return $this->loadFacade()->getById($id);
        }

        return null;
    }
    

    private function isAuthorized(User $user): bool
    {
        return App::getAuthorizedUser() === $user;
    }

    private function loadFacade(): Facade
    {
        return $this->facade ??= new Facade($this->factory);
    }
}
