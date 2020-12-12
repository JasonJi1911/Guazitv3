<?php
namespace api\controllers;

use common\helpers\OssHelper;
use common\helpers\OssUrlHelper;

class UploadController extends BaseController
{
    public function actionImage()
    {
        $image = $this->getParamOrFail('image');
        $ossHelper = new OssHelper();
        $dir = 'upload/' . date('Ym');  //目录
        $ret = $ossHelper->uploadFileBaseToOss($image, $dir);
        return [
            'img' => $ret,
            'show_img' => OssUrlHelper::set($ret)->toUrl()
        ];
    }

    /**
     * 删除图片，权限太高，直接反空
     */
    public function actionDeleteImage()
    {
        return [];
    }
}
