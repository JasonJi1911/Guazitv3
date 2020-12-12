<?php

namespace common\models\setting;

use Yii;

/**
 * This is the model class for table "{{%setting_rules}}".
 *
 * @property int $id
 * @property string $coupon_intro 卡券说明
 * @property string $task_intro 任务说明
 * @property string $score_intro 积分说明
 */
class SettingRules extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%setting_rules}}';
    }

}
