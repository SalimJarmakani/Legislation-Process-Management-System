<?php

class User
{
    // Attributes
    private $id;
    private $username;
    private $password_hash;
    private $role;
    private $email;
    private $created_time;
    private $updated_time;

    // Constructor
    public function __construct($id, $username, $password_hash, $role, $email, $created_time, $updated_time)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password_hash = $password_hash;
        $this->role = $role;
        $this->email = $email;
        $this->created_time = $created_time;
        $this->updated_time = $updated_time;
    }

    // Static method to create a user from an associative array
    public static function GenerateUser(array $data)
    {
        return new self(
            $data['id'],
            $data['username'],
            $data['password_hash'],
            $data['role'],
            $data['email'],
            $data['created_time'],
            $data['updated_time']
        );
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPasswordHash()
    {
        return $this->password_hash;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getCreatedTime()
    {
        return $this->created_time;
    }

    public function getUpdatedTime()
    {
        return $this->updated_time;
    }

    // Setters
    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setPasswordHash($password_hash)
    {
        $this->password_hash = $password_hash;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setUpdatedTime($updated_time)
    {
        $this->updated_time = $updated_time;
    }
}
