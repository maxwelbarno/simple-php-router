<?php

namespace UserController;

use Controller\Controller;
use Exceptions\CustomException;
use Model\User;

use function Helpers\getResponse;

class UserController extends Controller
{
    private $user;

    public function createUser()
    {
        $request_body = $this->request->getRequestBody();
        $this->user = new User();
        $res = $this->user->create($request_body);
        if ($res) {
            $data['code'] = "HTTP/1.1 201 Created";
            getResponse($this->response, $data, 201);
        }
    }

    public function getUser($id)
    {
        try {
            $this->user = new User();
            $user = $this->user->findById($id);
            if ($user) {
                $data['code'] = "HTTP/1.1 200 OK";
                $data["data"] = $user;
                getResponse($this->response, $data, 200);
            } else {
                throw new CustomException("User with ID {$id} Not Found");
            }
        } catch (CustomException $e) {
            $data['code'] = "HTTP/1.1 404 Not Found";
            $data["message"] = $e->getMessage();
            getResponse($this->response, $data, 404);
        }
    }

    public function getUsers()
    {
        $this->user = new User();
        $users = $this->user->findAll();
        $data['code'] = "HTTP/1.1 200 OK";
        $data["data"] = $users;

        getResponse($this->response, $data, 200);
    }

    public function updateUser($id)
    {
        try {
            $request_body = $this->request->getRequestBody();
            $this->user = new User();
            if ($this->user->findById($id)) {
                $this->user->update($request_body, $id);
                $data['code'] = "HTTP/1.1 200 OK";
                getResponse($this->response, $data, 200);
            } else {
                throw new CustomException("User with ID {$id} Not Found");
            }
        } catch (CustomException $e) {
            $data['code'] = "HTTP/1.1 404 Not Found";
            $data["message"] = $e->getMessage();
            getResponse($this->response, $data, 404);
        }
    }

    public function deleteUser($id)
    {
        try {
            $this->user = new User();
            if ($this->user->findById($id)) {
                $this->user->delete($id);
                $data['code'] = "HTTP/1.1 200 OK";
                getResponse($this->response, $data, 200);
            } else {
                throw new CustomException("User with ID {$id} Not Found");
            }
        } catch (CustomException $e) {
            $data['code'] = "HTTP/1.1 404 Not Found";
            $data["message"] = $e->getMessage();
            getResponse($this->response, $data, 404);
        }
    }
}
