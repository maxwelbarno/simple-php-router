<?php

namespace AuthController;

use Auth\Auth;
use Controller\Controller;

use function Helpers\response;

class AuthController extends Controller
{
    public function login()
    {
        $request_body = $this->request->getRequestBody();
        $auth = new Auth();
        if ($auth->authenticate($request_body)) {
            $data['code'] = "HTTP/1.1 200 OK";
            $data['message'] = "Login Success";
            response($this->response, $data, 200);
        } else {
            $data['code'] = "HTTP/1.1 401 Unauthorized";
            $data['message'] = "Invalid Login Credentials";
            response($this->response, $data, 401);
        }
    }
}
