<?php

namespace Controller;

class Controller
{
    public $request;
    public $response;

    public function __construct()
    {
        $this->request = $GLOBALS['request'];
        $this->response = $GLOBALS['response'];
    }
}
