<?php

namespace Controller;

class HomeController
{
    public function index()
    {
        http_response_code(200);
        $response['code'] = "HTTP/1.1 200 OK";
        $response['message'] = "welcome Home!";
        return json_encode($response);
    }

    public function about()
    {
        http_response_code(200);
        $response['code'] = "HTTP/1.1 200 OK";
        $response['message'] = "About Us!";
        return json_encode($response);
    }
}
