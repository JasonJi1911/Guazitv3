<?php

namespace appapi\exceptions;

use appapi\helpers\ErrorCode;

class InvalidSignException extends Exception
{
    public function __construct($message = null)
    {
        parent::__construct($message, ErrorCode::EC_SIGN_INVALID);
    }
}
