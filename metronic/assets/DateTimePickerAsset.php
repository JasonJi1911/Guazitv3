<?php

namespace metronic\assets;

use yii\web\AssetBundle;

/**
 * Metronic Datetime Picker
 */
class DateTimePickerAsset extends AssetBundle
{
    public $sourcePath = '@metronic/static';
    public $css = [
        'global/plugins/bootstrap-datetime-picker/css/bootstrap-datetimepicker.min.css',
    ];
    public $js = [
        'global/plugins/moment.min.js',
        'global/plugins/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js',
        // 'global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.zh-CN.min.js',
        'pages/scripts/components-date-time-pickers.min.js',
    ];
    public $depends = [
        'metronic\assets\CommonAsset',
    ];
}
