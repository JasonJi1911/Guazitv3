<?php
namespace admin\models\apps;

class AppsMarketChannel extends \common\models\AppsMarketChannel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['key', 'name'], 'string', 'max' => 64],
            [['desc'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Key',
            'name' => '名称，oppo',
            'desc' => '描述',
        ];
    }
}
