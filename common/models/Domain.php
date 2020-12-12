<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%domain}}".
 *
 * @property int $id
 * @property string $content 域名内容
 * @property int $type 类型，1：分享域名
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 */
class Domain extends \xiang\db\ActiveRecord
{
    const TYPE_PAGE = 1; // 页面
    const TYPE_API  = 2; // 接口

    public static $typeMap = [
       self::TYPE_PAGE => '分享域名',
       self::TYPE_API  => '接口'
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%domain}}';
    }
}
