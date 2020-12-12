<?php
namespace api\services;

use api\components\ParamsTrait;
use Yii;

class CommonService extends Service
{
    use ParamsTrait;
    
    public function init()
    {
        parent::init();
        
        $this->initRequest(Yii::$app->request);
    }
}
