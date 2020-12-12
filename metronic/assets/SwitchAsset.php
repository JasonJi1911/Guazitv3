<?php

namespace metronic\assets;

use yii\web\AssetBundle;

/**
 * Metronic Switch
 */
class SwitchAsset extends AssetBundle
{
    public $sourcePath = '@metronic/static';
    public $css = [
        'global/plugins/bootstrap-switch/css/bootstrap-switch.min.css',
    ];
    public $js = [
        'global/plugins/bootstrap-switch/js/bootstrap-switch.min.js',
        'pages/scripts/components-switch.js'
    ];
    public $depends = [
        'metronic\assets\CommonAsset',
    ];
    public $publishOptions = [
        
    ];
}
