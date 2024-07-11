<?php

declare(strict_types=1);

require __DIR__ . '/../../bootstrap.php';

use Example\Hydrator\UtilClasses\Address;
use Example\Hydrator\UtilClasses\People;
use Laminas\Hydrator\ClassMethodsHydrator;
use Laminas\Hydrator\Strategy\HydratorStrategy;


$data = [
    'id' => 1,
    'name' => 'Alex',
    'address' => [
        'city' => 'Minsk',
        'street' => 'Kovalevskaya',
        'number' => 15
    ]
];

$userHydrator = new ClassMethodsHydrator();
$addressHydrator = new ClassMethodsHydrator();

$userHydrator->addStrategy('address', new HydratorStrategy($addressHydrator, Address::class));
$user = $userHydrator->hydrate($data, new People());

print_r($user->getName());
print_r($user->getAddress());
print_r($user->getAddress()->getCity());
