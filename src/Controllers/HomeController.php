<?php
require_once './BaseController.php';
class HomeController extends BaseController
{

    public function index()
    {

        $isLoggedIn = isset($_COOKIE["LoggedIn"]) ? $_COOKIE["LoggedIn"] : false;


        //if user is not loggedIn 
        if (!isset($isLoggedIn) || !$isLoggedIn) header("Location: loginPage");


        //if user is already logged in redirect them to their appropriate Dashboard
        switch ($_SESSION["Role"]) {
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
