<?php
require_once "./DB/DB.php";

class RegistrationRepository
{
    private $filePath;

    private $dbContext;

    public function __construct($filePath = './localData/users.json')
    {
        $this->filePath = $filePath;

        $this->dbContext = DB::getInstance();
    }

    // Load all users from the JSON file
    private function loadUsers()
    {
        if (file_exists($this->filePath)) {
            return json_decode(file_get_contents($this->filePath), true);
        }
        return [];
    }

    // Save updated users back to the JSON file
    private function saveUsers($users)
    {
        file_put_contents($this->filePath, json_encode($users, JSON_PRETTY_PRINT));
    }

    // Check if a user with the given email already exists
    public function userExists($email)
    {
        $users = $this->loadUsers();

        if (!isset($users) || empty($users)) return false;

        foreach ($users as $user) {
            if ($user['email'] === $email) {
                return true;
            }
        }
        return false;
    }

    public function getRoleByEmail($email)
    {

        $users = $this->loadUsers();

        foreach ($users as $user) {
            if ($user['email'] === $email) {
                return $user["role"];
            }
        }

        return "noRole";
    }

    public function getRoleByEmailDB($email)
    {
        // Prepare the SQL query to select the role based on the email
        $sql = "SELECT role FROM user WHERE email = :email LIMIT 1";

        // Execute the query using the query method from the DB class
        $user = $this->dbContext->query($sql, ['email' => $email], true);

        // Check if a user was found and return the role
        if (!empty($user)) {
            // Since query returns an array, access the first element
            return $user[0]['role'];
        }

        return "noRole"; // Return a default value if no user found
    }

    // Register a new user by adding them to the JSON file
    public function registerUser($name, $email, $password)
    {
        $users = $this->loadUsers();

        // Add new user data to the array
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $users[] = [
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword
        ];

        // Save updated users array to the JSON file
        $this->saveUsers($users);
    }

    public function registerUserDB($name, $email, $password, $role = 'user')
    {
        try {
            // Hash the password before storing it in the database
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Prepare the SQL query to insert the new user
            $sql = "INSERT INTO user (username, email, password_hash, role) VALUES (:username, :email, :password_hash, :role)";

            // Prepare the statement using the PDO instance

            $user = [
                'username' => $name,
                'email' => $email,
                'password_hash' => $hashedPassword,
                'role' => $role
            ];
            $execute = $this->dbContext->query($sql, $user);

            if ($execute) echo "User successfully registered!";
        } catch (PDOException $e) {
            // Handle any errors
            echo "Error registering user: " . $e->getMessage();
        }
    }

    public function validateCredentials($email, $password)
    {
        $users = $this->loadUsers();

        foreach ($users as $user) {
            // Check if name matches and if the password matches the hashed password
            if ($user['email'] === $email && password_verify($password, $user['password'])) {
                return true;
            }
        }

        return false;
    }

    public function validateCredentialsDB($email, $password)
    {
        // Prepare the SQL query to select the user's hashed password based on the email
        $sql = "SELECT password_hash FROM user WHERE email = :email LIMIT 1";

        // Execute the query using the query method from the DB class
        $user = $this->dbContext->query($sql, ['email' => $email], true);

        // Check if a user was found and verify the password
        if (!empty($user)) {
            // Since query returns an array, access the first element
            $hashedPassword = $user[0]['password_hash'];

            // Verify the password
            if (password_verify($password, $hashedPassword)) {
                return true; // Credentials are valid
            }
        }

        return false; // Invalid credentials
    }
}
