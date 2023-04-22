<?php

namespace Pictrify;

use Exception;

class HttpException extends Exception
{
    protected string $reason;

    public function __construct($reason = "", $message = "Internal Server Error", $code = 500)
    {
        parent::__construct($message, $code);
        $this->reason = $reason;
    }

    public function getReason(): string
    {
        return $this->reason;
    }
}