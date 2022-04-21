<?php

namespace admin\models\advert;

class AdvertYY extends \common\models\advert\AdvertYY
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['yy_id', 'display_order', 'status', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['title'], 'string', 'min' => 0, 'max' => 100],
            [['url'], 'string', 'min' => 0, 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'yy_id'=>'模块',
            'title'=>'广告标题',
            'url'=>'广告跳转链接',
            'display_order' => '排序',
            'status'=> '状态',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
//    public function beforeSave($insert)
//    {
//        return parent::beforeSave($insert);
//    }
//
//    public function afterSave($insert, $changedAttributes)
//    {
//        parent::afterSave($insert, $changedAttributes);
//    }

    /**
     * 关联预告位
     */
    public function getAdvertyyTitle()
    {
        return $this->hasOne(AdvertYYTitle::className(), ['id' => 'yy_id']);
    }

}