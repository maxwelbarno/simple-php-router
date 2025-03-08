<?php

namespace UserController;

use Controller\Controller;
use DataMapper\UserMapper;
use Exceptions\CustomException;
use Model\User;

use function Helpers\response;

class UserController extends Controller
{
    private $data;

    public function createUser()
    {
        try {
            $request_body = $this->request->getRequestBody();
            $user = new User(($request_body));
            $this->data = new UserMapper();
            $res = $this->data->save($user);
            if ($res) {
                $data['code'] = "HTTP/1.1 201 Created";
                response($this->response, $data, 201);
            } else {
                throw new CustomException("Error in Request Body");
            }
        } catch (CustomException $e) {
            $data['code'] = "HTTP/1.1 400 Bad Request";
            $data["message"] = $e->getMessage();
            response($this->response, $data, 400);
        }
    }

    public function getUser($id)
    {
        try {
            $this->data = new UserMapper();
            $user = $this->data->fetchOne($id);
            if ($user) {
                $data['code'] = "HTTP/1.1 200 OK";
                $data["data"] = array_combine(["id","username", "password"], (array)$user);
                response($this->response, $data, 200);
            } else {
                throw new CustomException("User with ID {$id} Not Found");
            }
        } catch (CustomException $e) {
            $data['code'] = "HTTP/1.1 404 Not Found";
            $data["message"] = $e->getMessage();
            response($this->response, $data, 404);
        }
    }

    public function getUsers()
    {
        try {
            $this->data = new UserMapper();
            $users = $this->data->fetchAll();
            if ($users) {
                $list = [];
                foreach ($users as $user) {
                    $list[] = array_combine(["id","username", "password"], (array)$user);
                }
                $data['code'] = "HTTP/1.1 200 OK";
                $data["data"] = $list;
                response($this->response, $data, 200);
            } else {
                throw new CustomException("No User Found");
            }
        } catch (CustomException $e) {
            $data['code'] = "HTTP/1.1 404 Not Found";
            $data["message"] = $e->getMessage();
            response($this->response, $data, 404);
        }
    }

    public function updateUser($id)
    {
        try {
            $request_body = $this->request->getRequestBody();
            $user = new User(($request_body));
            $this->data = new UserMapper();
            if ($this->data->fetchOne($id)) {
                $this->data->update($user, $id);
                $data['code'] = "HTTP/1.1 200 OK";
                response($this->response, $data, 200);
            } else {
                throw new CustomException("User with ID {$id} Not Found");
            }
        } catch (CustomException $e) {
            $data['code'] = "HTTP/1.1 404 Not Found";
            $data["message"] = $e->getMessage();
            response($this->response, $data, 404);
        }
    }

    public function deleteUser($id)
    {
        try {
            $this->data = new UserMapper();
            if ($this->data->fetchOne($id)) {
                $this->data->delete($id);
                $data['code'] = "HTTP/1.1 200 OK";
                response($this->response, $data, 200);
            } else {
                throw new CustomException("User with ID {$id} Not Found");
            }
        } catch (CustomException $e) {
            $data['code'] = "HTTP/1.1 404 Not Found";
            $data["message"] = $e->getMessage();
            response($this->response, $data, 404);
        }
    }
}
