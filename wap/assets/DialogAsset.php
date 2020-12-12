<?php
namespace wap\assets;

use yii\web\AssetBundle;

class  DialogAsset extends AssetBundle
{
    public $css = [
        '/css/sweetalert.css'
    ];

    public $js = [
        '/js/sweetalert.min.js', 
        '/js/show_dialog.js'
    ];

    public $depends = [
        'mp\assets\AppAsset',
    ];
}
