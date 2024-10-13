<?php

require_once './BaseController.php';
include './Models/User.php';

class UserController extends BaseController
{

    public function getUser($data)
    {

        $this->render("user/profile", ["id" => $_GET["id"]]);
    }

    public function addUser()
    {

        $this->render("user/add");
    }
}
