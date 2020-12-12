<?php

namespace common\models;

use common\models\traits\SourceInterface;
use common\models\traits\SourceTrait;
use Yii;

/**
 * This is the model class for table "{{%feedback}}".
 *
 * @property int $id 自增ID
 * @property int $uid 用户ID
 * @property string $content 反馈内容
 * @property string $images 反馈截图，json格式
 * @property string $contact 联系方式
 * @property int $source 来源
 * @property string $reply 回复内容
 * @property int $admin_id 管理员ID
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class Feedback extends \xiang\db\ActiveRecord implements SourceInterface
{
    use SourceTrait;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%feedback}}';
    }
}
