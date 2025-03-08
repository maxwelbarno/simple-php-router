<?php

namespace UserController;

use Controller\Controller;
use DataMapper\UserMapper;
use Exceptions\CustomException;
use Model\User;

use function Helpers\response;

define("OK", "HTTP/1.1 200 OK");
define("NOT_FOUND", "HTTP/1.1 404 Not Found");

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
                response($this->response, "HTTP/1.1 201 Created", 201);
            } else {
                throw new CustomException("Error in Request Body");
            }
        } catch (CustomException $e) {
            response($this->response, "HTTP/1.1 400 Bad Request", 400, $e->getMessage());
        }
    }

    public function getUser($id)
    {
        try {
            $this->data = new UserMapper();
            $user = $this->data->fetchOne($id);
            if ($user) {
                $data = array_combine(["id","username", "password"], (array)$user);
                response($this->response, OK, 200, null, $data);
            } else {
                throw new CustomException("User with ID {$id} Not Found");
            }
        } catch (CustomException $e) {
            response($this->response, NOT_FOUND, 404, $e->getMessage());
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
                response($this->response, OK, 200, null, $list);
            } else {
                throw new CustomException("No User Found");
            }
        } catch (CustomException $e) {
            response($this->response, NOT_FOUND, 404, $e->getMessage());
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
                response($this->response, OK, 200);
            } else {
                throw new CustomException("User with ID {$id} Not Found");
            }
        } catch (CustomException $e) {
            response($this->response, NOT_FOUND, 404, $e->getMessage());
        }
    }

    public function deleteUser($id)
    {
        try {
            $this->data = new UserMapper();
            if ($this->data->fetchOne($id)) {
                $this->data->delete($id);
                response($this->response, OK, 200);
            } else {
                throw new CustomException("User with ID {$id} Not Found");
            }
        } catch (CustomException $e) {
            response($this->response, NOT_FOUND, 404, $e->getMessage());
        }
    }
}
