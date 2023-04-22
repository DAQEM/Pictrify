<?php

namespace Pictrify;

class NotFoundException extends HttpException
{
    public function __construct($reason = "", $message = "Not Found", $code = 404)
    {
        parent::__construct($reason, $message, $code);
    }
}