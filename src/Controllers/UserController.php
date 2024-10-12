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

    public function addUser()
    {

        $this->render("user/add");
    }
    public function createUser()
    {

        $name = $_POST["name"];
        $email = $_POST["email"];


        $user = new User($name, $email, "43242");

        $this->render("user/create", ["user" => $user]);
    }

    public function createUser1($name, $email, $password)
    {

        $user = new User($name, $email, $password);

        $this->render("user/create", ["user" => $user]);
    }
}
