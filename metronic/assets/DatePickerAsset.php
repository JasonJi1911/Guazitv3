<?php

namespace metronic\assets;

use yii\web\AssetBundle;

/**
 * Metronic Date Picker
 */
class DatePickerAsset extends AssetBundle
{
    public $sourcePath = '@metronic/static';
    public $css = [
        'global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css',
    ];
    public $js = [
        'global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
        // 'global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.zh-CN.min.js',
        'pages/scripts/components-date-time-pickers.min.js',
    ];
    public $depends = [
        'metronic\assets\CommonAsset',
    ];
}
