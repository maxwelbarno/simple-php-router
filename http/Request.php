<?php

namespace Http;

use function Helpers\clean;

class Request
{
    public function getServer($key = '')
    {
        $key = strtoupper($key);
        return isset($_SERVER[$key]) ? clean($_SERVER[$key]) : clean($_SERVER);
    }

    public function getHttpMethod()
    {
        return strtoupper($this->getServer('REQUEST_METHOD'));
    }

    public function getUrl()
    {
        $url = $this->getServer('REQUEST_URI');
        return trim($url, '/') ?? '/';
    }

    public function getRequestBody($key = '')
    {
        $post_data = file_get_contents("php://input");
        $request = json_decode($post_data, true);
        if ($key != '') {
            return isset($request[$key]) ? clean($request[$key]) : null;
        }
        return $request;
    }
}
