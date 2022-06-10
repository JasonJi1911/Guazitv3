<?php
namespace appapi\controllers;

use appapi\logic\AdvertLogic;

class AdvertController extends BaseController
{
    /**
     * 广告点击统计
     */
    public function actionClick()
    {
        $advertId = $this->getParamOrFail('advert_id');

        $advertLogic = new AdvertLogic();
        $advertLogic->click($advertId);
        return [];
    }

    /**
     * 去广告
     * @return bool
     * @throws \appapi\exceptions\ApiException
     */
    public function actionRemoveAd()
    {
        $advertLogic = new AdvertLogic();
        return $advertLogic->removeAd();
    }
}