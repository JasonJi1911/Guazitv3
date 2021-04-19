<?php
namespace admin\models\video;

use admin\models\traits\ProductTrait;
use common\helpers\RedisKey;
use common\helpers\Tool;
use yii\helpers\ArrayHelper;
use common\models\IpAddress;

class Banner extends \common\models\video\Banner
{
    use ProductTrait;

    public $video_id;
    public $url;
    public $scheme;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            [[ 'status', 'display_order', 'action','title', 'video_id'], 'required'],
            [[ 'status', 'display_order', 'action','title',], 'required'],
            [['channel_id', 'status', 'display_order', 'action','product','city_id'], 'integer'],
            [['display_order'], 'integer', 'min' => DISPLAY_ORDER_MIN, 'max' => DISPLAY_ORDER_MAX],
            [['video_id', 'scheme', 'url','stitle'], 'string'],
            [['content'], 'string', 'max' => 256],
            [['title'], 'string', 'max' => 32],
            [['city_id','product'],'default','value'=>0]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'channel_id' => '频道',
            'title' => '标题',
            'stitle'=>'副标题',
            'image' => 'Image',
            'action' => '跳转类型',
            'video_id' => '作品',
            'content' => 'Content',
            'display_order' => '展示顺序',
            'product' => 'Banner展示渠道',
            'status' => '当前状态',
            'actionLabel' => '动作类型',
            'city_id'=>'所属城市',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'cityName' => '地域'
        ];
    }


    /**
     * @inheritdoc
     */
    public static function find()
    {
        $tvb = Banner::tableName();
        return parent::find()
            ->addOrderBy([$tvb . '.channel_id' => SORT_ASC, $tvb . '.display_order' => SORT_DESC, $tvb . '.updated_at' => SORT_DESC]);
    }

    public function beforeSave($insert)
    {

        //根据action来保存数据
        switch ($this->action) {
            case self::ACTION_VIDEO : //作品
                $this->content = $this->video_id ? $this->video_id   : 0;
                break;

            case self::ACTION_SCHEME : //APP内页面
                $this->content = $this->scheme ? $this->scheme : '';
                break;

            case self::ACTION_URL : //链接
            case self::ACTION_BROWSER_URL :
                $this->content = $this->url ? $this->url : '';
                break;

            default :
                $this->content = '';
                break;
        }

        if ($this->channel_id == null) {
            $this->channel_id = 0;
        }

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        // 清除缓存
        Tool::clearCache(RedisKey::videoBanner($this->channel_id));

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @return \yii\db\ActiveQuery
     *  关联频道
     */
    public function getChannel()
    {
        return $this->hasOne(VideoChannel::className(), ['id' => 'channel_id']);
    }

    public function getVideo()
    {
        return $this->hasOne(Video::className(),['id' => 'video_id']);
    }

    public function getActionLabel()
    {
        return ArrayHelper::getValue(self::$actionMap, $this->action);
    }

    /**
     * @return \yii\db\ActiveQuery
     * 关联城市
     */
    public function getCityName()
    {
        $cityArea = IpAddress::findOne($this->city_id);
        if ($cityArea) {
            return $cityArea->city;
        }

        return '全部';
//        return $this->hasOne(IpAddress::className(), ['id' => 'city_id']);
    }

}