<?php
include "./Router.php";

$router = new Router();

$router->addRoute('/', 'index', UserController::class,);


return $router;
