<?php
$router = include "./routes.php";

$router->addRoute("/", 'index', UserController::class);
$router->routeLink("/");
