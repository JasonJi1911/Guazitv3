<?php
namespace admin\models\setting;

class SettingAppsPush extends \common\models\setting\SettingAppsPush
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['app_id'], 'required'],
            [['app_id', 'created_at', 'updated_at'], 'integer'],
            [['ios_app_key', 'ios_app_secret', 'android_app_key', 'android_app_secret'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'app_id' => 'App ID',
            'ios_app_key' => 'Ios App Key',
            'ios_app_secret' => 'Ios App Secret',
            'android_app_key' => 'Android App Key',
            'android_app_secret' => 'Android App Secret',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
