<?php

namespace App;

require 'vendor/autoload.php';

use Dotenv\Dotenv;
use HomeController\HomeController;
use Http\Request;
use Http\Response;
use Router\Router;
use UserController\UserController;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$request = new Request();
$response = new Response();
$response->setHeader('Content-Type: application/json; charset=UTF-8');

$router = new Router($request->getUrl(), $request->getHttpMethod());
$router->get("/", [HomeController::class, 'index']);
$router->get('/users/{id}', [UserController::class, 'getUser']);
$router->get('/users', [UserController::class, 'getUsers']);
$router->post('/users', [UserController::class, 'createUser']);
$router->put('/users/{id}', [UserController::class, 'updateUser']);
$router->delete('/users/{id}', [UserController::class, 'deleteUser']);

$router->dispatch();
$response->render();
