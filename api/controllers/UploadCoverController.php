<?php
namespace api\controllers;

use yii\web\Controller;
use common\helpers\OssHelper;
use common\helpers\OssUrlHelper;

class UploadCoverController extends Controller
{
    public function actionCover()
    {
        $image = $this->getParamOrFail('image');
        //$ossHelper = new OssHelper();
        $dir = 'video/cover' . date('Ymd');  //目录
        $ret = $ossHelper->uploadFileBaseToOss($image, $dir);
        echo [
            'img' => $ret,
            'show_img' => OssUrlHelper::set($ret)->toUrl()
        ];
    }
}