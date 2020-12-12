<?php

namespace metronic\assets;

use yii\web\AssetBundle;

/**
 * Metronic Toastr
 */
class ToastrAsset extends AssetBundle
{
    public $sourcePath = '@metronic/static';
    public $css = [
        'global/plugins/bootstrap-toastr/toastr.min.css',
    ];
    public $js = [
        'global/plugins/bootstrap-toastr/toastr.min.js',
    ];
    public $depends = [
        'metronic\assets\CommonAsset',
    ];
}
