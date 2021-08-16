<?php

namespace pc\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class NewIndexStyleAsset extends AssetBundle
{
    //?v=. PC_ASSETS_CSS_VERSION
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/css/newindex.css',
    ];
    public $js = [

    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
