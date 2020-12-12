<?php

namespace common\models\setting;

use Yii;

/**
 * This is the model class for table "{{%setting_mp_info}}".
 *
 * @property int $id
 * @property int $white_ip_list
 * @property int $lead_down_switch
 * @property int $service_info
 * @property int $pay_tips_txt
 * @property int $force_chapter_num
 */
class SettingMpInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%setting_mp_info}}';
    }
}
