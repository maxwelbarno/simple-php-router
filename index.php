<?php

namespace App;

require 'vendor/autoload.php';

use HomeController\HomeController;
use Http\Request;
use Http\Response;
use Router\Router;
use UserController\UserController;

$request = new Request();
$response = new Response();
$response->setHeader('Content-Type: application/json; charset=UTF-8');

$router = new Router($request->getUrl(), $request->getHttpMethod());
$router->get("/", [HomeController::class, 'index']);
$router->get("/about", [HomeController::class, 'about']);
$router->get('/users/{userId}', [UserController::class, 'showUserProfile']);
$router->get('/users', [UserController::class, 'getUsers']);

$router->dispatch();
$response->render();
