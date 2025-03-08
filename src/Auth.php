<?php

namespace Auth;

use DataMapper\UserMapper;

class Auth
{
    private $data;
    public function authenticate($data)
    {
        $this->data = new UserMapper();
        $username = $data['username'];
        $password = $data['password'];
        $user = $this->data->fetchByUsername($username);
        if ($user) {
            $hash = $user->getPassword();
            return password_verify($password, $hash);
        }
    }
}
