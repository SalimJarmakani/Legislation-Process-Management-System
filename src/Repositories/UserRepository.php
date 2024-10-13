<?php
require_once "./DB/DB.php";

class UserRepository
{
    private $filePath;

    private $dbContext;

    public function __construct($filePath = './localData/users.json')
    {
        $this->filePath = $filePath;

        $this->dbContext = DB::getInstance();
    }

    public function getUserByEmail($email)
    {

        $sqlQuery = "SELECT * FROM user WHERE email = :email LIMIT 1";

        $userData = $this->dbContext->query($sqlQuery, ['email' => $email], true);

        if (!empty($userData)) {
            //use User class method to generate user class from the data
            $user = User::GenerateUser($userData[0]);

            return $user;
        } else return null;
    }
}
