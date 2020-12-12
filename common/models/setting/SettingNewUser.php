<?php

namespace common\models\setting;

use Yii;

/**
 * This is the model class for table "{{%setting_new_user}}".
 *
 * @property int $id
 * @property int $gold_num 金币数
 * @property int $gold_probability 概率
 * @property int $silver_num 银币数
 * @property int $silver_probability 概率
 * @property int $vip_num vip
 * @property int $vip_probability 概率
 */
class SettingNewUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%setting_new_user}}';
    }
}
