<?php

namespace HomeController;

use Controller\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $data['code'] = "HTTP/1.1 200 OK";
        $data['message'] = "welcome Home!";
        $this->response->setStatus(200);
        $this->response->setContent($data);
    }

    public function about()
    {
        $data['code'] = "HTTP/1.1 200 OK";
        $data['message'] = "About Us!";
        $this->response->setStatus(200);
        $this->response->setContent($data);
    }
}
