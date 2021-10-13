<?php

use App\View;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require 'vendor/autoload.php';

session_start();

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', 'ToDoController@showTasks');
    $r->addRoute('GET', '/todo', 'ToDoController@showTasks');
    $r->addRoute('GET', '/add', 'ToDoController@showAddTask');
    $r->addRoute('POST', '/add', 'ToDoController@addTask');
    $r->addRoute('POST', '/todo/{id}', 'ToDoController@deleteTask');

    $r->addRoute('GET', '/login', 'AuthController@loginView');
    $r->addRoute('POST', '/login', 'AuthController@login');
    $r->addRoute('GET', '/success', 'AuthController@loginSuccess');

    $r->addRoute('GET', '/logout', 'AuthController@logout');

    $r->addRoute('GET', '/register', 'AuthController@registerView');
    $r->addRoute('POST', '/register', 'AuthController@register');
    $r->addRoute('GET', '/registered', 'AuthController@confirmationView');
});

$loader = new FilesystemLoader('app/Views');
$templateEngine = new Environment($loader, []);
$templateEngine->addGlobal('session', $_SESSION);

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        // ... call $handler with $vars

        [$controller, $method] = explode('@', $handler);
        $controller = "App\\Controllers\\" . $controller;
        $controller = new $controller;
        $response = $controller->$method($vars);

        if ($response instanceof View) {
            echo $templateEngine->render($response->getTemplate(), $response->getVariables());
        }

        break;
}

unset($_SESSION['_errors']);