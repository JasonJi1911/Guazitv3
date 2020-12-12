<?php

namespace admin\modules\api;

/**
 * mp module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'admin\modules\api\controllers';
    /**
     * @var string 模块名
     */
    public $name = 'api';


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
