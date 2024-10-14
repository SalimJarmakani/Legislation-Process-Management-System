<?php
session_start();

include_once "./helpers.php";
$router = include "./routes.php";

$uri = $_SERVER['REQUEST_URI'];
$pathData = getPath($uri);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $router->routeLink($pathData["route"], $_POST);
} else {
    $router->routeLink($pathData["route"], $_GET);
}
