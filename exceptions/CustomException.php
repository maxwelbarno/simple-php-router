<?php

namespace Exceptions;

use Exception;

class CustomException extends Exception
{
    public function __construct(string $message = '', int $code = 422)
    {
        parent::__construct($message, $code);
        $this->message = "$message";
        $this->code = $code;
    }

    public function render()
    {
        header('Content-Type: application/json; charset=UTF-8');
        http_response_code(500);
        echo json_encode(["code" => 500, "message" => $this->message]);
        exit();
    }
}
