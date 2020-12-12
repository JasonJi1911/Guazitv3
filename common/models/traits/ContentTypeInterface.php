<?php
/**
 * Created by PhpStorm.
 * Date: 19/6/10
 * Time: 下午9:09
 */
namespace common\models\traits;

use Yii;

/**
 * 内容类型 interface
 */
interface ContentTypeInterface
{
    const CONTENT_TYPE_NOVEL = 1;
    const CONTENT_TYPE_COMIC = 2;

    /**
     * @return mixed
     */
    public function getContentType();

    /**
     * 获取内容类型名称
     * @return string
     */
    public function getContentTypeText();

}
