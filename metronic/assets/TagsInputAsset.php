<?php

namespace metronic\assets;

use yii\web\AssetBundle;

/**
 * Metronic TagsInput
 */
class TagsInputAsset extends AssetBundle
{
    public $sourcePath = '@metronic/static';
    public $css = [
        'global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css',
    ];
    public $js = [
        'global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js',
    ];
    public $depends = [
        'metronic\assets\CommonAsset',
    ];
}
