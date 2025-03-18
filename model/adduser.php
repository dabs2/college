<?php

namespace College\Ddcollege\Model;

class adduser
{
    private $user;

    public function __construct()
    {
        $this->user = new database();
    }

    public function adduser($username, $password, $type)
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        return $this->user->insert("users", ['username' =>
            $username, 'password' => $hashedPassword, 'user_role' => $type]);
    }
}