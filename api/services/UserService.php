<?php
namespace api\services;

use api\exceptions\ApiException;
use api\helpers\ErrorCode;
use api\models\DeviceInfo;
use api\models\user\User;
use api\models\user\UserVip;
use Yii;


/**
 * Class UserService
 * @package api\services
 */
class UserService extends Service
{
    /**
     * 设置token
     * @param $token
     */
    public function setToken($token)
    {
        if ($token) {
            $this->model = $this->_getUser($token);
        }
    }

    /**
     * 查询用户,便于使用缓存
     * @param $token
     * @return null|static
     */
    private function _getUser($token)
    {
        return User::findByToken($token);
    }

    /**
     * 检测登录
     * @throws ApiException
     */
    public function checkLogin() {
        if (empty($this->model)) {
            throw new ApiException(ErrorCode::EC_USER_TOKEN_EXPIRE);
        }

        if ($this->model->status == User::STATUS_DISABLED) {
            throw new ApiException(ErrorCode::EC_USER_FORBIDDEN);
        }
    }

    /**
     * 获取用户vip状态
     * @param $uid
     * @return int
     */
    public function isVip($uid)
    {
        $userVip = UserVip::findOne(['uid' => $uid]);
        if (!$userVip || $userVip->end_time < time()) { //已经过期
            return 0;
        }
        return 1;
    }
}
