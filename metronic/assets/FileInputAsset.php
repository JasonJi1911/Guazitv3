<?php

namespace metronic\assets;

use yii\web\AssetBundle;

/**
 * Metronic File Input
 */
class FileInputAsset extends AssetBundle
{
    public $sourcePath = '@metronic/static';
    public $css = [
        'global/plugins/bootstrap-fileinput/bootstrap-fileinput.css',
    ];
    public $js = [
        'global/plugins/bootstrap-fileinput/bootstrap-fileinput.js',
    ];
    public $depends = [
        'metronic\assets\CommonAsset',
    ];
}
