<?php
namespace api\models\video;

class Topic extends \common\models\video\Topic
{
    public function fields()
    {
        return [
            'topic_id' => 'id',
            'channel_id',
            'topic_name' => 'name',
            'intro',
            'cover' => function($model){
                return $model->cover->toUrl();
            },
            'is_hot',
            'total' =>'video_num',
            'play_num' => function(){
                return $this->total_views;
            },
            'display_order',
            'create_time' => function($model){
                return date('Y-m-d', $model->created_at);
            }
        ];
    }

    /**
     * {@inheritdoc}
     * @return \xiang\db\ActiveQuery the newly created [[ActiveQuery]] instance.
     */
    public static function find()
    {
        // todo 修改
        return parent::find()->where([self::tableName() . '.deleted_at' => 0])->orderBy(self::tableName() . '.display_order desc');
    }
}