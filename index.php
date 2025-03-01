<?php

namespace App;

require 'vendor/autoload.php';

use Controller\HomeController;
use Controller\UserController;
use Router\Router;

header("Content-Type:application/json");

$router = new Router();
$router->get("/", [HomeController::class, 'index']);
$router->get("/about", [HomeController::class, 'about']);
$router->get('/users/{userId}', [UserController::class, 'showUserProfile']);

echo $router->dispatch();
