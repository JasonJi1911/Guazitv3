<?php

namespace common\models\analyze;

use Yii;

/**
 * This is the model class for table "{{%analyze_api_log}}".
 *
 * @property int $id
 * @property string $url 地址
 * @property string $body 请求体
 * @property string $cost 消耗时长
 * @property int $created_at 创建时间
 */
class AnalyzeApiLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%analyze_api_log}}';
    }
}
