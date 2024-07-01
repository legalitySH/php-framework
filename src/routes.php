<?php

declare(strict_types=1);

require './vendor/autoload.php';

use Bramus\Router\Router;

$router = new Router();

$router->get('/users/(\d+)', function (int $id) {
    echo "User ID: $id";
});

$router->get('/', function () {
    $userController = new \App\Controller\UserController();
    require './App/View/homepage.php';
});

$router->set404(function () {
    header('HTTP/1.1 404 Not Found');
    echo '404, route not found';
});

$router->get('/update', function () {
    $userController = new \App\Controller\UserController();
    echo json_encode($userController->getAll());
});

$router->post('/remove', function () {
    $userController = $userController = new \App\Controller\UserController();
    $userController->remove($_POST['id']);
});

$router->post('/add', function () {
    $userController = $userController = new \App\Controller\UserController();
    $userController->add($_POST['login']);
});

$router->run();


