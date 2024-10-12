<?php

class User
{
    public $name;
    public $email;
    public $password;
    public $role;
    public function __construct($name, $email, $password = null)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }
}
