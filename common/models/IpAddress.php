<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%ip_address}}".
 *
 * @property int $id
 * @property string $ip ip地址
 * @property string $area 国家或地区
 * @property string $province 省份
 * @property string $city 城市
 * @property int $created_at 创建时间
 */
class IpAddress extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%ip_address}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at'], 'integer'],
            [['ip'], 'string', 'max' => 15],
            [['area'], 'string', 'max' => 32],
            [['province', 'city'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip' => 'ip地址',
            'area' => '国家或地区',
            'province' => '省份',
            'city' => '城市',
            'created_at' => '创建时间',
        ];
    }
}
