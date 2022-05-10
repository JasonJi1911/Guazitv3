<?php
namespace apinew\services;

use apinew\components\ParamsTrait;
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
