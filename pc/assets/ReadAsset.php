<?php

namespace pc\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class ReadAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/common.css',
        'css/layer.css'
    ];
    public $js = [
        // 'js/jquery.js',
        // 'js/jquery.cookie.js',
        // 'js/layer.js',
        // 'js/public.js',
        // 'js/tool.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
