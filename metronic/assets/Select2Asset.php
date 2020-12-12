<?php

namespace metronic\assets;

use yii\web\AssetBundle;

/**
 * Metronic Select2
 */
class Select2Asset extends AssetBundle
{
    public $sourcePath = '@metronic/static';
    public $css = [
        'global/plugins/select2/css/select2.min.css',
        'global/plugins/select2/css/select2-bootstrap.min.css',
    ];
    public $js = [
        'global/plugins/select2/js/select2.full.min.js',
        'pages/scripts/components-select2.js',
    ];
    public $depends = [
        'metronic\assets\CommonAsset',
    ];
}
