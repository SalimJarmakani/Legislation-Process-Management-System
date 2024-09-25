<?php
include "./helpers.php";
$router = include "./routes.php";

$uri = $_SERVER['REQUEST_URI'];
$pathData = getPath($uri);
echo $pathData["route"];
$router->routeLink($pathData["route"], $pathData);
