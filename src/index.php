<?php
include_once "./helpers.php";
$router = include "./routes.php";

$uri = $_SERVER['REQUEST_URI'];
$pathData = getPath($uri);
$router->routeLink($pathData["route"], $pathData);
