<?php

namespace Pictrify;

class ForbiddenException extends HttpException
{
    public function __construct($reason = "", $message = "Forbidden", $code = 403)
    {
        parent::__construct($reason, $message, $code);
    }
}