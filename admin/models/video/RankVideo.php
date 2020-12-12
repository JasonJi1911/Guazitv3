<?php
namespace admin\models\video;

use common\helpers\RedisKey;
use common\helpers\Tool;

class RankVideo extends \common\models\video\RankVideo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['video_id', 'display_order', 'rank_id'], 'required'],
            [['rank_id', 'video_id', 'period','display_order'], 'integer'],
            [['display_order'], 'integer', 'min' => DISPLAY_ORDER_MIN, 'max' => DISPLAY_ORDER_MAX],
            ['video_id', 'unique', 'targetAttribute' => ['video_id','rank_id'], 'message' => '该影视已经存在'],

        ];
    }


    public function beforeSave($insert)
    {

        if (!parent::beforeSave($insert)) {
            return false;
        }
        if (!$this->video_id) {
            $this->addError('video_id', '作品不能为空');
            return false;
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rank_id' => 'Rank ID',
            'video_id' => '影片',
            'period' => '榜单类型',
            'display_order' => '排序',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        self::clearCache();
    }

    /**
     * 删除排行相关的缓存
     */
    public static function clearCache()
    {
        // 清除缓存
        $key = RedisKey::videoRankList('', '', true);
        Tool::batchClearCache($key);
    }

    /**
     * 获取影片
     */
    public function getVideo()
    {
        return $this->hasOne(Video::className(), ['id' => 'video_id']);
    }

    public function getRank()
    {
        return $this->hasOne(Rank::className(), ['id' => 'rank_id']);
    }

    public static function find()
    {
        return parent::find()->orderBy('display_order desc, period asc');
    }
}
