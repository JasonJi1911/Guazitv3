<?php
namespace admin\models\video;

use common\helpers\Tool;
use yii\helpers\ArrayHelper;
use common\helpers\RedisKey;
use common\helpers\RedisStore;

class Actor extends \common\models\video\Actor
{

    public function fields()
    {
        return [
            'id' => 'actor_id',
            'full_name' => 'actor_name',
            'avatar' => function($model){
                return $model->avatar->toUrl();
            },
            'description' => function(){

                $filmNum = VideoActor::find()->where(['actor_id' => $this->actor_id])->count();

                return "热度值:$this->weight <br/>  作品数:$filmNum";
            },
            'weight',
            'type'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['actor_name', 'weight', 'area_id'], 'required'],
            [['type', 'area_id', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['actor_name'], 'string', 'max' => 32],
            [['weight'], 'integer', 'min' => NUMBER_INPUT_MIN, 'max' => NUMBER_INPUT_MAX]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'actor_id' => 'Actor ID',
            'actor_name' => '主演名',
            'avatar' => '头像',
            'weight' => '权重',
            'type' => '身份',
            'area_id' => 'Area ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'areaLabel' => '地域'
        ];
    }

    public function getActionLabel()
    {
        return ArrayHelper::getValue(self::$actionMap, $this->type);
    }

    /**
     * @return \yii\db\ActiveQuery
     *  关联视频演员表
     */
    public function getChannel()
    {
        return $this->hasOne(VideoActor::className(), ['id' => 'actor_id']);
    }

    public function getAreaList()
    {
        return ArrayHelper::map(ActorArea::find()->orderBy(['display_order' => SORT_DESC])->all(), 'id', 'area');
    }

    public function getAreaLabel()
    {
        $actorArea = ActorArea::findOne($this->area_id);
        if ($actorArea) {
            return $actorArea->area;
        }

        return '--';
    }

    public function afterSave($insert, $changedAttributes)
    {
        // 删除演员缓存信息
        Tool::clearCache(RedisKey::actorInfo($this->actor_id));
        Tool::batchClearCache(sprintf(RedisKey::AREA_ACTOR, ''));
        parent::afterSave($insert, $changedAttributes);
    }

}
