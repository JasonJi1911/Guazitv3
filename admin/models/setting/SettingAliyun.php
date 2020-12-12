<?php
namespace admin\models\setting;

use common\helpers\RedisKey;
use common\helpers\Tool;
use yii\helpers\ArrayHelper;

class SettingAliyun extends \common\models\setting\SettingAliyun
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['access_key'], 'string', 'max' => 64],
            [['access_secret'], 'string', 'max' => 256],
            [['access_key', 'access_secret'], 'trim']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'access_key' => 'AccessKey ID',
            'access_secret' => 'Access Key Secret',
        ];
    }

    public function getTypeLabel()
    {
        return ArrayHelper::getValue(self::$typeMap, $this->type);
    }
}
