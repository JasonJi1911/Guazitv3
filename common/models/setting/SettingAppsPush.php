<?php

namespace common\models\setting;

use Yii;

/**
 * This is the model class for table "{{%apps_push}}".
 *
 * @property int $id
 * @property int $app_id
 * @property string $ios_app_key
 * @property string $ios_app_secret
 * @property string $android_app_key
 * @property string $android_app_secret
 * @property int $created_at
 * @property int $updated_at
 */
class SettingAppsPush extends \xiang\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%setting_apps_push}}';
    }
}
