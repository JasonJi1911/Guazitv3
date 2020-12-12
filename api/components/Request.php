<?php

namespace api\components;

use Yii;
use yii\web\Request as BaseRequest;
use common\models\traits\ProductInterface;
use common\models\traits\ProductTrait;

/**
 * 请求类
 */
class Request extends BaseRequest implements ProductInterface
{
    use ProductTrait;

    /**
     * @var array 请求参数
     */
    private $_bodyParams;

    /**
     * 返回全部请求参数
     */
    public function getBodyParams()
    {
        if ($this->_bodyParams === null) {
            $this->_bodyParams = json_decode($this->getRawBody(), true);
        }

        return $this->_bodyParams;
    }

    /**
     * 获取系统类型
     * @return string
     */
    public function getOsType()
    {
        return $this->post('osType');
    }

    /**
     * 获取产品线
     * @return integer
     */
    public function getProduct()
    {
        return $this->post('product');
    }
    
}
