<?php

namespace pc\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class StyleInAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/css/style_in.css?v=' . PC_ASSETS_CSS_VERSION,
        '/css/DPlayer.min.css'
    ];
    public $js = [
        'js/hls.min.js',
        'js/DPlayer.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
