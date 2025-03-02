<?php

namespace UserController;

use Controller\Controller;

class UserController extends Controller
{
    public function showUserProfile($userId)
    {
        $data['code'] = "HTTP/1.1 200 OK";
        $data['message'] = "Showing user profile for ID: {$userId}";
        $this->response->setStatus(200);
        $this->response->setContent($data);
    }
}
