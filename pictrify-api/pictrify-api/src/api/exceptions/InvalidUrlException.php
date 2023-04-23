<?php

namespace Pictrify;

class InvalidUrlException extends HttpException
{
    public function __construct(string $reason = "The URL this request was sent to is not valid.",
                                string $message = "The requested resource was not found.",
                                int $code = 404)
    {
        parent::__construct($reason, $message, $code);
    }
}