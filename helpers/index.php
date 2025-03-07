<?php

namespace Helpers;

function response($response, $data, $code)
{
    $response->setStatus($code);
    $response->setContent($data);
}

function clean($data)
{
        return trim(htmlspecialchars($data, ENT_COMPAT, 'UTF-8'));
}
