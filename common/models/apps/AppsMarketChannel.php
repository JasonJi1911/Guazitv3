<?php

namespace common\models\apps;

use Yii;

/**
 * This is the model class for table "{{%apps_market_channel}}".
 *
 * @property int $id
 * @property string $key
 * @property string $name 名称，oppo
 * @property string $desc 描述
 */
class AppsMarketChannel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%apps_market_channel}}';
    }
}
