<?php

namespace App;

require 'vendor/autoload.php';

use Controller\HomeController;
use Router\Router;

header("Content-Type:application/json");

$router = new Router();
$router->get("/", [HomeController::class, 'index']);
$router->get("/about", [HomeController::class, 'about']);

echo $router->resolve();
