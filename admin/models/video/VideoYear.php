<?php
namespace admin\models\video;

use common\helpers\RedisKey;
use common\helpers\Tool;

class VideoYear extends \common\models\video\VideoYear
{
    public function getVideo()
    {
        return $this->hasMany(Video::className(), ['year' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['year', 'display_order'], 'required'],
            [['created_at', 'display_order'], 'integer'],
            [['year'], 'string', 'max' => 32],
            [['description'], 'string', 'max' => 64],
            [['display_order'], 'integer', 'min' => DISPLAY_ORDER_MIN, 'max' => DISPLAY_ORDER_MAX],
            [['year'], 'trim']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'year' => '年代',
            'description' => '描述',
            'display_order' => '排序',
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
        Tool::clearCache(RedisKey::videoYear());
        parent::afterSave($insert, $changedAttributes);
    }
}
