<?php
namespace appapi\services;

use appapi\components\ParamsTrait;
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
