<?php

namespace Controller;

class UserController
{
    public function showUserProfile($userId)
    {
        http_response_code(200);
        $response['code'] = "HTTP/1.1 200 OK";
        $response['message'] = "Showing user profile for ID: {$userId}";
        return json_encode($response);
    }
}
