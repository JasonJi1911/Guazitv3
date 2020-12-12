<?php
namespace admin\models\video;

use common\helpers\RedisKey;
use common\helpers\Tool;

class VideoArea extends \common\models\video\VideoArea
{
    public function getVideo()
    {
        return $this->hasMany(Video::className(), ['area' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['area', 'display_order'], 'required'],
            [['display_order', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['area'], 'string', 'max' => 32],
            [['description'], 'string', 'max' => 64],
            [['area'], 'trim'],
            [['display_order'], 'integer', 'min' => DISPLAY_ORDER_MIN, 'max' => DISPLAY_ORDER_MAX],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'area' => '地区',
            'description' => '描述',
            'display_order' => '展示排序',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function beforeSave($insert)
    {
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        Tool::clearCache(RedisKey::videoArea());
        parent::afterSave($insert, $changedAttributes);
    }
}
