<?php

namespace appapi\exceptions;

use Yii;
use appapi\helpers\ErrorCode;
use yii\base\UserException;

class Exception extends UserException
{
    public function __construct($message = null, $code = null)
    {
        if ($code === null) {
            $code = ErrorCode::EC_UNKNOWN;
        }
        if (!$message) {
            $message = ErrorCode::errMsg($code);
        }

        parent::__construct($message, $code);
    }
}
