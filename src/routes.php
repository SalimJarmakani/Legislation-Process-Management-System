<?php
include "./Router.php";
$router = new Router();

$GLOBALS["BASE_URL"] = getBasePath();


$router->addRoute("/", "index", HomeController::class);
$router->addRoute("user", "index", UserController::class);
$router->addRoute("user/profile", "getUser", UserController::class);
$router->addRoute("user/add", "addUser", UserController::class);
$router->addRoute("user/create", "createUser", UserController::class);
$router->addRoute("user/create1", "createUser1", UserController::class);

$router->addRoute("home", "home1", HomeController::class);

$router->addRoute("registration", "index", RegistrationController::class);
$router->addRoute("register", "register", RegistrationController::class);
$router->addRoute("loginPage", "loginPage", RegistrationController::class);
$router->addRoute("login", "login", RegistrationController::class);
$router->addRoute("MPDashboard", "MPDashboard", DashBoardController::class);
$router->addRoute("Bill/CreateBill", "newBill", BillController::class);



return $router;
