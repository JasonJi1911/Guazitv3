<?php
/**
 * api异常处理类
 */

namespace api\exceptions;


use api\helpers\ErrorCode;

class ApiException extends Exception
{
    protected $data = [];
    public function __construct($code, $message = null, $data = [])
    {
        if (empty($message)) {
            $message = ErrorCode::errMsg($code);
        }
        $this->data = $data;

        $argv = func_get_args();

        if (!empty($argv[3])) {
            array_splice($argv, 0, 3, $message);
            $message = call_user_func_array('sprintf', $argv);
        }

        parent::__construct($message, $code);
    }

    /**
     * 获取传入的数据
     * @return array
     */
    public function getData() {
        return $this->data;
    }
}
