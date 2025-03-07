<?php

namespace Model;

class User
{
    private $id;
    private $username;
    private $password;

    public function __construct($data)
    {
        $this->id = $data['id'];
        $this->username = $data['username'];
        $this->password = $data['password'];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }
}
