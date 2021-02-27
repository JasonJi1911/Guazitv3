<?php

namespace pc\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class StyleMap extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/css/map.css?v='. PC_ASSETS_CSS_VERSION,
    ];
    public $js = [

    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
