<?php

namespace metronic\assets;

use yii\web\AssetBundle;

/**
 * Metronic Summer Note
 */
class SummerNoteAsset extends AssetBundle
{
    public $sourcePath = '@metronic/static';
    public $css = [
        'global/plugins/bootstrap-summernote/summernote.css',
    ];
    public $js = [
        'global/plugins/bootstrap-summernote/summernote.min.js',
        'pages/scripts/components-editors.js',
    ];
    public $depends = [
        'metronic\assets\CommonAsset',
    ];
}
