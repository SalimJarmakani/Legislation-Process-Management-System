<?php
include_once "./Router.php";
$router = new Router();

$GLOBALS["BASE_URL"] = getBasePath();


$router->addRoute("/", "index", HomeController::class, "GET");
$router->addRoute("registration", "index", RegistrationController::class, 'GET');
$router->addRoute("register", "register", RegistrationController::class, 'POST');
$router->addRoute("loginPage", "loginPage", RegistrationController::class, 'GET');
$router->addRoute("login", "login", RegistrationController::class, 'POST');
$router->addRoute("MPDashboard", "MPDashboard", DashBoardController::class, 'GET');
$router->addRoute("Bill/AddBill", "addBill", BillController::class, 'GET');
$router->addRoute("Bill/CreateBill", "createBill", BillController::class, 'POST');
$router->addRoute("Rev-Dashboard", "reviewDashboard", DashBoardController::class, 'GET');
$router->addRoute("LogOut", "logOut", RegistrationController::class, 'GET');
$router->addRoute("AdminDashboard", "adminDashboard", DashBoardController::class, "GET");
$router->addRoute("Bill/startBillVoting", "startBillVoting", BillController::class, 'POST');
$router->addRoute("Bill/Review", "reviewBill", BillController::class, "GET");
$router->addRoute("Bill/AddAmendment", "addAmendment", BillController::class, 'POST');
$router->addRoute("Bill/Voting", "voting", BillController::class, "GET");
$router->addRoute("Bill/SubmitVote", "submitVote", BillController::class, "POST");
$router->addRoute("Bill", "viewBill", BillController::class, "GET");
$router->addRoute("Bill/EditBill", "editBill", BillController::class, "GET");
$router->addRoute("Bill/UpdateBill", "updateBill", BillController::class, "POST");
$router->addRoute("Bill/BillAdmin", "billAdmin", BillController::class, "GET");
$router->addRoute("Bill/EndVoting", "endVotingSession", BillController::class, "POST");
return $router;
