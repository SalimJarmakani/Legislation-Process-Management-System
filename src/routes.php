<?php
include "./Router.php";
$router = new Router();

$GLOBALS["BASE_URL"] = getBasePath();


$router->addRoute("/", "index", HomeController::class);
$router->addRoute("user", "index", UserController::class);
$router->addRoute("user/profile", "getUser", UserController::class);
$router->addRoute("user/add", "addUser", UserController::class);
$router->addRoute("user/create", "createUser", UserController::class);
return $router;
