<?php

namespace admin\models\advert;

use common\models\video\City;

class AdvertYYTitle extends \common\models\advert\AdvertYYTitle
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'display_order'], 'required'],
            [['city_id', 'display_order', 'status','product', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['title'], 'string', 'min' => 0, 'max' => 32],
            [['city_id','product'],'default','value'=>0],
            [['platform'], 'string', 'max' => 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city_id'=>'城市',
            'title'=>'标题',
            'display_order' => '排序',
            'status'=> '状态',
            'product' => '展示渠道',
            'platform'=>'平台',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
    public function beforeSave($insert)
    {
        if ($this->city_id == null) {
            $this->city_id = 0;
        }

        return parent::beforeSave($insert);
    }

    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }
}