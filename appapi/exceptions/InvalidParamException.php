<?php

namespace appapi\exceptions;

use appapi\helpers\ErrorCode;

class InvalidParamException extends Exception
{
    public function __construct($param, $message = null)
    {
        $code    = ErrorCode::EC_PARAM_INVALID;
        $message = sprintf($message ?: ErrorCode::errMsg($code), $param);

        parent::__construct($message, $code);
    }
}
