<?php

namespace Pictrify;

class BadRequestException extends HttpException
{
    public function __construct($reason = "", $message = "Bad Request", $code = 400)
    {
        parent::__construct($reason, $message, $code);
    }
}