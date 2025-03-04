<?php

namespace Http;

class Request
{
    public function getServer($key = '')
    {
        $key = strtoupper($key);
        return isset($_SERVER[$key]) ? $this->clean($_SERVER[$key]) : $this->clean($_SERVER);
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
            return isset($request[$key]) ? $this->clean($request[$key]) : null;
        }
        return $request;
    }

    private function clean($data)
    {
        return trim(htmlspecialchars($data, ENT_COMPAT, 'UTF-8'));
    }
}
