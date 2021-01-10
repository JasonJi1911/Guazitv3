<?php

namespace wap\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * Main mp application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $css = [
        '/css/site.css?v='.WAP_ASSETS_CSS_VERSION,
        '/css/video/swiper.min.css',
        '/css/video/video.css?v='.WAP_ASSETS_CSS_VERSION,
        '/css/video/video-js.min.css',
        '/css/video/DPlayer.min.css'
    ];

    public $js = [
        '/js/jquery.min.js',
        '/js/video/fastclick.min.js',
        'js/video/video.min.js',
        'js/video/hls.min.js',
        'js/video/DPlayer.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];

}
