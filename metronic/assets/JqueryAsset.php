<?php

namespace yii\web;

use Yii;

class JqueryAsset extends AssetBundle
{
    public $sourcePath = '@metronic/static';
    public $js = [
        'global/plugins/jquery.min.js',
    ];
}

