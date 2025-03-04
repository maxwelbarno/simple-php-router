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

    public function createUser()
    {
        $request_body = $this->request->getRequestBody();
        $this->user = new User();
        $res = $this->user->create($request_body);
        if ($res) {
            $data['code'] = "HTTP/1.1 201 Created";
            $this->response->setContent($data);
        }
    }

    public function updateUser($id)
    {
        $request_body = $this->request->getRequestBody();
        $this->user = new User();
        $res = $this->user->update($request_body, $id);
        if ($res) {
            $data['code'] = "HTTP/1.1 200 OK";
            $this->response->setStatus(200);
            $this->response->setContent($data);
        } else {
            $data['code'] = "HTTP/1.1 400 Bad Request";
            $this->response->setStatus(400);
            $this->response->setContent($data);
        }
    }
}
