<?php

declare(strict_types=1);

require './vendor/autoload.php';

use Bramus\Router\Router;
use App\App;
use App\Controller\CookieController;
use App\Controller\SessionController;

$router = new Router();


$router->get('/', function () {
    echo App::getTwigProvider()->render('homepage.twig', ['title' => "Homepage"]);
});

$router->get('/cookies-example', function () {
    $controller = new CookieController();
    echo App::getTwigProvider()->render('cookies.twig', [
        'title' => 'Cookies example',
        'cookies' => $controller->getAllCookies()
    ]);
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
    ob_start();
    require __DIR__ . '/App/View/session.php';
    $contentBlock = ob_get_clean();

    echo App::getTwigProvider()->render('sessions.twig', [
        'title' => 'Session example',
        'contentBlock' => $contentBlock
    ]);
});

$router->post('/start-session', function () {
    SessionController::start();
    echo json_encode([
        'session_status' => $_SERVER
    ]);
});

$router->get('/session-status', function () {
    echo json_encode(['session_status' => $_SERVER]);
});

$router->post('/abort-session', function () {
    SessionController::abort();
    echo json_encode([
        'session_status' => $_SERVER
    ]);
});

$router->post('/set-input-data', function () {
    $controller = new SessionController();

    if (session_status() === PHP_SESSION_ACTIVE) {
        $_SESSION['inputData'] = $_POST['input-data'];
        echo json_encode(['status' => $_SESSION['inputData']]);
        return;
    }

    echo json_encode(['status' => 'Session not started']);
});

$router->get('/get-input-data', function () {
    echo json_encode(['data' => $_SESSION['inputData']]);
});

$router->run();
