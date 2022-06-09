<?php
namespace admin\models\advert;

use admin\models\advert\AdvertPosition;
use common\helpers\RedisKey;
use common\helpers\Tool;
use common\models\IpAddress;

class Advert extends \common\models\advert\Advert
{
    public $imageurl;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['position_id', 'ad_type','city_id', 'width', 'height', 'url_type', 'pv', 'click', 'status', 'created_at', 'updated_at', 'deleted_at', 'display_order'], 'integer'],
            [['title'], 'string', 'max' => 64],
            [['ad_key', 'ad_android_key'], 'string', 'max' => 128],
            [['skip_url'], 'string', 'max' => 256],
            [['url_type', 'title', 'skip_url','platform'], 'required'],
            [['city_id'],'default','value'=>0],
            [['platform'], 'string', 'max' => 2],
            [['imageurl'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'position_id' => '广告位置',
            'ad_type' => '广告类型',
            'title' => '标题',
            'image' => '广告图',
            'width' => 'Width',
            'height' => 'Height',
            'skip_url' => '跳转地址',
            'url_type' => '链接地址',
            'ad_key' => '广告类型',
            'ad_android_key' => 'Ad Android Key',
            'pv' => 'Pv量',
            'click' => '点击量',
            'status' => '状态',
            'city_id' => '所属城市',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'cityName' => '地域',
            'platform' => '平台',
            'display_order' => '排序'
        ];
    }


    /**
     * 关联广告位置
     */
    public function getAdvertPosition()
    {
        return $this->hasOne(AdvertPosition::className(), ['id' => 'position_id']);
    }


    public function beforeSave($insert)
    {
        if(!empty($this->imageurl) && strpos($this->imageurl, '.m3u8')!==false){
            $this->image = $this->imageurl;
        }
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        // 删除缓存
        Tool::clearCache(RedisKey::advertInfoKey($this->id));
        parent::afterSave($insert, $changedAttributes);
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

        return '--';
//        return $this->hasOne(IpAddress::className(), ['id' => 'city_id']);
    }
}