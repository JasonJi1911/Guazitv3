<?php

namespace common\models\video;

use Yii;

/**
 * This is the model class for table "{{%industry}}".
 *
 * @property int $id 自增id
 * @property string $industry_name 行业名称
 * @property int $display_order 排序
 * @property string $remark 备用
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class Industry extends \xiang\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%industry}}';
    }

}
