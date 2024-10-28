<?php
session_start();


include_once __DIR__ . "/helpers.php";
$router = include __DIR__ . "/routes.php";

$uri = $_SERVER['REQUEST_URI'];
$pathData = getPath($uri);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $router->routeLink($pathData["route"], $_POST);
} else {
    $router->routeLink($pathData["route"], $_GET);
}
