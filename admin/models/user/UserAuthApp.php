<?php
namespace admin\models\user;

class UserAuthApp extends \common\models\user\UserAuthApp
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'type', 'app_id', 'created_at', 'updated_at'], 'integer'],
            [['openid'], 'required'],
            [['openid', 'unionid'], 'string', 'max' => 64],
            [['name'], 'string', 'max' => 256],
            [['avatar'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => '用户uid',
            'openid' => '用户唯一标识',
            'unionid' => '联合唯一标识',
            'name' => '用户名称',
            'avatar' => '头像',
            'type' => '类型，1：微信，2 qq',
            'app_id' => 'app id',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }
}
