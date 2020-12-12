<?php

namespace metronic\assets;

use yii\web\AssetBundle;

/**
 * Metronic Common
 */
class CommonAsset extends AssetBundle
{
    public $sourcePath = '@metronic/static';
    public $css = [
        'global/plugins/font-awesome/css/font-awesome.min.css',
        'global/plugins/simple-line-icons/simple-line-icons.min.css',
        'global/plugins/bootstrap/css/bootstrap.min.css',
        'global/plugins/bootstrap-switch/css/bootstrap-switch.min.css',
        'global/css/components-rounded.min.css',
        'global/css/plugins.min.css',
        'global/css/fonts.css',

        'layouts/layout/css/layout.min.css',
        'layouts/layout/css/themes/darkblue.min.css',
        'layouts/layout/css/custom.min.css',
    ];
    public $js = [
        'global/plugins/bootstrap/js/bootstrap.min.js',
        'global/plugins/js.cookie.min.js',
        'global/plugins/jquery-slimscroll/jquery.slimscroll.min.js',
        'global/plugins/jquery.blockui.min.js',
        'global/plugins/bootstrap-switch/js/bootstrap-switch.min.js',
        'global/scripts/app.min.js',
        
        'layouts/layout/scripts/layout.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
