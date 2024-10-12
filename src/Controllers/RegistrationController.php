<?php

require_once './BaseController.php';
require_once './repositories/RegistrationRepository.php';

class RegistrationController extends BaseController
{
    private $repository;

    public function __construct()
    {
        $this->repository = new RegistrationRepository(); // Initialize repository
    }

    // Display the registration page
    public function index()
    {
        $this->render('registration/registration'); // Rendering the registration form
    }

    public function loginPage()
    {
        $this->render('registration/login');
    }
    public function login($email, $password)
    {

        $valid = $this->repository->validateCredentialsDB($email, $password);

        if (!$valid) {
            $this->render("Registration/login", ["error" => "Wrong Credentials!"]);
            return;
        }

        $role = $this->repository->getRoleByEmailDB($email);
        $_SESSION["Role"] = $role;
        header("Location: MPDashboard");
    }
    // Handle registration logic
    public function register($name, $email, $password, $role)
    {
        // Validate input
        if (empty($name) || empty($email) || empty($password) || empty($role)) {
            echo "All fields are required!";
            return;
        }

        // Check if the user already exists
        if ($this->repository->userExists($email)) {
            echo "Email is already registered!";
            return;
        }

        // Register the user
        $this->repository->registerUserDB($name, $email, $password, $role);

        include "./Views/registration/login.php";
    }
}
