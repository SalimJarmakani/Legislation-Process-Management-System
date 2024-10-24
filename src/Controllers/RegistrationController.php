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
    public function login($email, $password, $remember = false)
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
        if ($remember) {
            setcookie("LoggedIn", true, time() + (86400 * 30), "/");
            setcookie("Email", $user->getEmail(), time() + (86400 * 30), "/");
        } else {
            // Unset cookies if 'Remember Me' is not checked
            if (isset($_COOKIE["LoggedIn"])) {
                setcookie("LoggedIn", "", time() - 3600, "/"); // Expire the cookie by setting a past time
            }
            if (isset($_COOKIE["Email"])) {
                setcookie("Email", "", time() - 3600, "/"); // Expire the cookie by setting a past time
            }
        }

        switch (trim($user->getRole())) {
            case 'MP':
                header("Location: MPDashboard");
                break;
            case 'Reviewer':
                header("Location: Rev-Dashboard");
                break;
            case 'Administrator':
                header("Location: AdminDashboard");
                break;
            default:
                header("Location: notFound");
        }
    }

    public function logOut()
    {
        //destroy session
        session_destroy();

        //remove logged In cookie


        include "./Views/registration/loggedOut.php";
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
