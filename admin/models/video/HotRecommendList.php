<?php
namespace admin\models\video;

class HotRecommendList extends \common\models\video\HotRecommendList
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['video_id', 'display_order'], 'required'],
            [['recommend_id', 'video_id', 'display_order', 'created_at','updated_at'], 'integer'],
            [['display_order'], 'integer', 'min' => DISPLAY_ORDER_MIN, 'max' => DISPLAY_ORDER_MAX],
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
            'recommend_id' => '分类',
            'video_id' => '影片',
            'display_order' => '排序',
            'created_at' => 'Created At',
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     *  关联热门
     */
    public function getHot()
    {
        return $this->hasOne(HotRecommend::className(), ['recommend_id' => 'recommend_id']);
    }


    public function getVideo()
    {
        return $this->hasOne(Video::className(), ['id' => 'video_id']);
    }
}
