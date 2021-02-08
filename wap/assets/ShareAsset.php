<?php

namespace wap\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * Main mp application asset bundle.
 */
class ShareAsset extends AssetBundle
{
    public $css = [
        '/css/sharedown.css'
    ];

    public $js = [
        'js/rem.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];

}
