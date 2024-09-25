<?php

require_once './BaseController.php';
include './Models/User.php';

class UserController extends BaseController
{
    public function index()
    {
        $users = [
            new User('John Doe', 'john.doe@ceo.com'),
            new User('Jane Doe', 'Jane.doe@ceo.com')
        ];

        $this->render('user/index', ['users' => $users]);
    }

    public function getUser($data)
    {

        $this->render("user/profile", ["id" => $_GET["id"]]);
    }
}
