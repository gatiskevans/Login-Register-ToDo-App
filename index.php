<?php

require 'vendor/autoload.php';

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', 'ToDoController@showTasks');
    $r->addRoute('GET', '/todo', 'ToDoController@showTasks');
    $r->addRoute('GET', '/add', 'ToDoController@showAddTask');
    $r->addRoute('POST', '/add', 'ToDoController@addTask');
    $r->addRoute('POST', '/todo/{id}', 'ToDoController@deleteTask');

    $r->addRoute('GET', '/login', 'UserController@loginView');
    $r->addRoute('POST', '/welcome', 'UserController@login');
    $r->addRoute('GET', '/register', 'UserController@registerView');
    $r->addRoute('POST', '/registered', 'UserController@confirmation');
    $r->addRoute('GET', '/users', 'UserController@showUsers');
});

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
        $controller->$method($vars);
        break;
}