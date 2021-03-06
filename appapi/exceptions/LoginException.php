<?php
namespace appapi\exceptions;

use appapi\helpers\ErrorCode;

class LoginException extends Exception
{
    public function __construct($code = 301, $message = '')
    {
        if (!$message) {
            $message = ErrorCode::errMsg($code);
        }
        parent::__construct($message, $code);
    }
}
