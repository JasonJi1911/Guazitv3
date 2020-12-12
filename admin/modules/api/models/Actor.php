<?php

namespace admin\modules\api\models;

use Yii;

/**
 * This is the model class for table "{{%actor}}".
 *
 * @property int $actor_id 主演id
 * @property string $actor_name 主演名
 * @property string $avatar 头像
 * @property int $weight 权重 值越大越靠前
 * @property int $type 类型，1演员，2导演
 * @property int $area_id 地域
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class Actor extends \common\models\video\Actor
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%actor}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['weight', 'type', 'area_id', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['area_id'], 'required'],
            [['actor_name'], 'string', 'max' => 32],
            [['avatar'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'actor_id' => 'Actor ID',
            'actor_name' => 'Actor Name',
            'avatar' => 'Avatar',
            'weight' => 'Weight',
            'type' => 'Type',
            'area_id' => 'Area ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['upload']);
        return $behaviors;
    }
}
