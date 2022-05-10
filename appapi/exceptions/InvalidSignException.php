<?php

namespace apinew\exceptions;

use apinew\helpers\ErrorCode;

class InvalidSignException extends Exception
{
    public function __construct($message = null)
    {
        parent::__construct($message, ErrorCode::EC_SIGN_INVALID);
    }
}
