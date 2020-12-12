<?php

namespace common\models\setting;

use common\models\traits\SwitchToggleInterface;
use common\models\traits\SwitchToggleTrait;
use Yii;

/**
 * This is the model class for table "{{%setting_vip_power}}".
 *
 * @property int $id
 * @property int $vip_read_all 全站读开关
 */
class SettingVipPower extends \yii\db\ActiveRecord implements SwitchToggleInterface
{
    use SwitchToggleTrait;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%setting_vip_power}}';
    }
}
