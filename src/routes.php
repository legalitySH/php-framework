<?php

declare(strict_types=1);

require './vendor/autoload.php';

use App\Controller\BasketController;
use App\Controller\ProductController;
use App\Sort\Product\StrategyBuilder;
use Bramus\Router\Router;
use App\App;
use App\Controller\CookieController;

$router = new Router();


$router->get('/', function () {
    $controller = new ProductController();
    if (isset($_GET['sortingType']))
    {
        $controller->index((new StrategyBuilder())->build($_GET['sortingType']));

        return;
    }

    $controller->index();
});

$router->get('/basket', function () {
    $controller = new BasketController();
    $controller->index();
});

$router->get('/cookies-example', function () {

    $cacheClient = App::getCacheProvider();

    if ($cacheClient->has('/cookies-example')) {
        echo $cacheClient->get('/cookies-example');
    } else {
        $content = App::getTwigProvider()->render('cookies.twig', [
            'title' => 'Cookies example',
            'cookies' => (new CookieController())->getAllCookies()
        ]);
        $cacheClient->set('/cookies-example', $content, 15);
        echo $content;
    }
});

$router->post('/add-cookie', function () {
    $controller = new CookieController();
    $controller->createCookie(
        $_POST['cookieKey'],
        $_POST['cookieValue'],
        $_POST['cookieExpirationTime']
    );
    header('Content-Type: application/json');
    echo json_encode($_POST);
});

$router->get('/fetch-cookies', function () {
    $controller = new CookieController();
    header('Content-Type: application/json');
    echo json_encode($controller->getAllCookies());
});

$router->post('/remove-cookie', function () {
    $controller = new CookieController();
    $postedData = $_POST['delete-cookie'];
    $returnValue = $_SESSION[$postedData];
    $controller->remove($postedData);
    header('Content-Type: application/json');
    echo json_encode($postedData);
});

$router->get('/sessions-example', function () {

    $cacheClient = App::getCacheProvider();

    if ($cacheClient->has('/sessions-example')) {
        echo $cacheClient->get('/sessions-example');
    } else {
        ob_start();
        require __DIR__ . '/App/View/session.php';
        $contentBlock = ob_get_clean();
        $content = App::getTwigProvider()->render('sessions.twig', [
            'title' => 'Session example',
            'contentBlock' => $contentBlock
        ]);

        $cacheClient->set('/sessions-example', $content, 5);
        echo $content;
    }
});

$router->get('/session-status', function () {
    echo json_encode(['session_status' => $_SERVER]);
});

$router->post('/delete-from-basket', function () {
    $controller = new BasketController();
    header('Content-Type: application/json');
    echo json_encode([
        'status' => $controller->delete((int)$_POST['basket_id']) !== null,
        'id' => $_POST['basket_id']
    ]);
});

$router->post('/add-to-basket', function () {
    $controller = new BasketController();
    header('Content-Type: application/json');
    echo json_encode(['status' => $controller->add(App::getAuthorizedUser(),(int)$_POST['product_id'])]);
});

$router->run();
