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
        $access = $auth->authenticate($request_body);
        if ($access) {
            $data['access_token'] = $access;
            response($this->response, "HTTP/1.1 200 OK", 400, null, $data);
        } else {
            response($this->response, "HTTP/1.1 401 Unauthorized", 401, "Invalid Login Credentials");
        }
    }
}
