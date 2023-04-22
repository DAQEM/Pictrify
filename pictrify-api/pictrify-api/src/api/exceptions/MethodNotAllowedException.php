<?php

namespace Pictrify;

class MethodNotAllowedException extends HttpException
{
    public function __construct($reason = "", $message = "Method Not Allowed", $code = 405)
    {
        parent::__construct($reason, $message, $code);
    }
}