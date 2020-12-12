<?php

namespace metronic\assets;

use yii\web\AssetBundle;

/**
 * Metronic JSTree
 */
class JSTreeAsset extends AssetBundle
{
    public $sourcePath = '@metronic/static';
    public $css = [
        'global/plugins/jstree/dist/themes/default/style.min.css',
    ];
    public $js = [
        'global/plugins/jstree/dist/jstree.min.js',
    ];
    public $depends = [
        'metronic\assets\CommonAsset',
    ];
}
