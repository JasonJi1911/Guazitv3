<?php
namespace admin\models\apps;

class PushPassageway extends \common\models\apps\PushPassageway
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['p_key', 'app_key'], 'required'],
            [['status', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['name', 'app_key', 'app_secret'], 'string', 'max' => 32],
            [['p_key', 'app_id'], 'string', 'max' => 16],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'p_key' => 'P Key',
            'app_id' => 'App ID',
            'app_key' => 'App Key',
            'app_secret' => 'App Secret',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
}