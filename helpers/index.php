<?php

namespace Helpers;

function response($response, $status, $code, $message = null, $data = null)
{
    $content["status"] = $status;
    $content["data"] = $data;
    $content["message"] = $message;
    $response->setStatus($code);
    $response->setContent(array_filter($content));
}

function clean($data)
{
        return trim(htmlspecialchars($data, ENT_COMPAT, 'UTF-8'));
}
