<?php

namespace metronic\assets;

use yii\web\AssetBundle;

/**
 * 批量操作
 */
class BatchActionsAsset extends AssetBundle
{
    public $sourcePath = '@metronic/static';
    public $css = [
    ];
    public $js = [
        'pages/scripts/batch-actions.js',
    ];
    public $depends = [
        'metronic\assets\ToastrAsset',
    ];
}
