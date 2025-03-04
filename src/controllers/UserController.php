<?php

namespace UserController;

use Controller\Controller;
use Model\User;

class UserController extends Controller
{
    private $user;

    public function showUserProfile($userId)
    {
        $data['code'] = "HTTP/1.1 200 OK";
        $data['message'] = "Showing user profile for ID: {$userId}";
        $this->response->setStatus(200);
        $this->response->setContent($data);
    }

    public function getUsers()
    {
        $this->user = new User();
        $users = $this->user->findAll();
        $data['code'] = "HTTP/1.1 200 OK";
        $data["data"] = $users;
        $this->response->setStatus(200);
        $this->response->setContent($data);
    }
}
