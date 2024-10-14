<?php
include "./Router.php";
$router = new Router();

$GLOBALS["BASE_URL"] = getBasePath();



$router->addRoute("registration", "index", RegistrationController::class, 'GET');
$router->addRoute("register", "register", RegistrationController::class, 'POST');
$router->addRoute("loginPage", "loginPage", RegistrationController::class, 'GET');
$router->addRoute("login", "login", RegistrationController::class, 'POST');
$router->addRoute("MPDashboard", "MPDashboard", DashBoardController::class, 'GET');
$router->addRoute("Bill/AddBill", "addBill", BillController::class, 'GET');
$router->addRoute("Bill/CreateBill", "createBill", BillController::class, 'POST');
$router->addRoute("Rev-Dashboard", "reviewDashboard", DashBoardController::class, 'GET');






return $router;
