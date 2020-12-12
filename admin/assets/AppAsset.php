<?php

namespace admin\assets;

use yii\web\AssetBundle;

/**
 * Main admin application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $css = [
        'css/main.css?v=' . CSS_FILE_VERSION,
    ];
    public $js = [
        'js/main.js?v=' . JS_FILE_VERSION,
        'js/remove-emoji.js?v=' . JS_FILE_VERSION, // 禁止填写表情
        'js/repeat-submit.js?v=' . JS_FILE_VERSION, // 防止重复提交
        'js/go-page.js?v=' . JS_FILE_VERSION, // 页面跳转问题
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'metronic\assets\CommonAsset',
    ];
}
