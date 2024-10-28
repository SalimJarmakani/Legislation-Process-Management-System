<?php

require_once __DIR__ . '/../BaseController.php';
include __DIR__ . '/../Models/User.php';

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
