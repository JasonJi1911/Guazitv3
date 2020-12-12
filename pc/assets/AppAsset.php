<?php

namespace pc\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/css/video.css?v=' . PC_ASSETS_CSS_VERSION,
        '/css/video-js.min.css',
        '/css/swiper.min.css',
        '/css/iconfont.css'
    ];
    public $js = [
        'js/function.js?v=1',
        'js/focus.js',
        'js/carousel.js',
        'js/swiper.min.js',
        'js/video/video.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'metronic\assets\CommonAsset',
    ];
}

