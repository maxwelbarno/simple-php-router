<?php

namespace Auth;

use DataMapper\UserMapper;
use JWT\Jwt;

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
            $payload = [
                "sub" => $user->getId(),
                "username" => $user->getUsername(),
                "exp" => time() + 20
            ];
            $secret_key = $_ENV['SECRET_KEY'];
            $jwt = new Jwt($secret_key);
            $access_token = $jwt->encode($payload);
            $hash = $user->getPassword();
            if (password_verify($password, $hash)) {
                return $access_token;
            }
            return null;
        }
    }
}
