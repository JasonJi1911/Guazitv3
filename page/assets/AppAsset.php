<?php

namespace page\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $css = [
        'css/index.css',
    ];
    public $js = [
        'js/common.js?v=1.0',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
