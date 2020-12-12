<?php
namespace api\models\user;

use common\helpers\Tool;

class User extends \common\models\user\User
{
    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'uid',

            'nickname', // 昵称

            'status',

            'mobile',

            'user_token',

            'gender',  //性别

            'avatar' => function() { //头像
                return $this->avatar->resize(100, 100)->toUrl();
            },

        ];
    }

    /**
     * 通过token获取用户
     * @param string $token
     * @return User
     */
    public static function findByToken($token)
    {
        return static::findOne(['user_token' => $token]);
    }

    /*
     * 更新cookie
     */
    public function updateCookie()
    {
        $this->setScenario('update_token');

        //如果token为空才更新
        if (empty($this->user_token)) {
            $this->user_token = Tool::getRandKey();
        }
        $this->save();
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['update_token'] = ['user_token'];
        return $scenarios;
    }
}
