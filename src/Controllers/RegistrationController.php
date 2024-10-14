<?php

require_once './BaseController.php';
require_once './repositories/RegistrationRepository.php';
require_once './repositories/UserRepository.php';


class RegistrationController extends BaseController
{
    private $repository;
    private $userRepository;

    public function __construct()
    {
        $this->repository = new RegistrationRepository(); // Initialize repository
        $this->userRepository = new UserRepository();
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

        $user = $this->userRepository->getUserByEmail($email);

        if ($user == null) header("Location: notFound");
        $_SESSION["Role"] = $user->getRole();
        $_SESSION["Email"] = $user->getEmail();
        $_SESSION["Id"] = $user->getId();

        switch ($user->getRole()) {
            case 'MP':
                header("Location: MPDashboard");
                break;

            case 'Reviewer':
                header("Location: Rev-Dashboard");
                break;
            default:
                header("Location: notFound");
        }
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
