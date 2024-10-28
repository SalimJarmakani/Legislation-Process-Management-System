<?php
require_once __DIR__ . '/../BaseController.php';
class HomeController extends BaseController
{

    public function index()
    {

        $isLoggedIn = isset($_COOKIE["LoggedIn"]) ? $_COOKIE["LoggedIn"] : false;


        //if user is not loggedIn 
        if (!isset($isLoggedIn) || !$isLoggedIn) header("Location: loginPage");

        $Role = isset($_SESSION["Role"]) ? $_SESSION["Role"] : "";
        //if user is already logged in redirect them to their appropriate Dashboard
        switch ($Role) {
            case 'MP':
                header("Location: MPDashboard");
                break;

            case 'Reviewer':
                header("Location: Rev-Dashboard");
                break;
            default:
                header("Location: loginPage");
        }
    }
}
