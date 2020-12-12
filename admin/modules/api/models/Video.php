<?php
namespace admin\modules\api\models;

class Video extends \common\models\video\Video
{
    public $channelName; // 频道名称
    public $catName; // 分类名
    public $areaName; // 地区
    public $yearName; // 年份
    public $actorName; // 演员

    public function rules()
    {
        return [
            [['channel_id', 'category_ids', 'title',], 'required'],
            [['area', 'year','score', 'issue_date', 'total_views', 'total_favors', 'likes_num', 'total_price'], 'integer'],

            [['type', 'status', 'is_finished', 'is_sensitive'], 'in', 'range' => [1, 2]],
            [['play_limit'], 'in', 'range' => [1, 2, 3]],
            [['is_down'], 'in', 'range' => [0, 1]],

            [['type'], 'default', 'value' => 1],

            [['cover', 'horizontal_cover'], 'string', 'max' => 256],
            [['title',], 'string', 'max' => 128],
            [['source',], 'string', 'max' => 32],
            [['description', 'actorName',], 'string','max' => 2048]
        ];
    }


    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['upload']);
        return $behaviors;
    }
}

