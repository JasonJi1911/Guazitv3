<?php

namespace common\models;

use common\models\traits\ProductInterface;
use common\models\traits\ProductTrait;
use common\models\traits\StatusToggleInterface;
use common\models\traits\StatusToggleTrait;
use Yii;

/**
 * This is the model class for table "{{%announcement}}".
 *
 * @property int $id 公告ID
 * @property string $title 标题
 * @property string $content 内容
 * @property int $product 产品线 1app 2公众号
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class Announcement extends \xiang\db\ActiveRecord implements ProductInterface, StatusToggleInterface
{
    use ProductTrait,StatusToggleTrait;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%announcement}}';
    }


}
