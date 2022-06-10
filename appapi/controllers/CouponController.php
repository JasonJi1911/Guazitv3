<?php
namespace appapi\controllers;

use appapi\dao\UserDao;
use Yii;

class CouponController extends BaseController
{
    //已使用观影券
    public function actionUsed()
    {
        $userCoupon = new UserDao();
        return $userCoupon->userCoupon();
    }

    //我的观影券
    public function actionList()
    {
        $userList = new UserDao();
        return $userList->userList();
    }
}
