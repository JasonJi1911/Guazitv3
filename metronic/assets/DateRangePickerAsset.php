<?php

namespace metronic\assets;

use yii\web\AssetBundle;

/**
 * Metronic DateRange Picker
 */
class DateRangePickerAsset extends AssetBundle
{
    public $sourcePath = '@metronic/static';
    public $css = [
        'global/plugins/bootstrap-daterangepicker/daterangepicker.min.css',
    ];
    public $js = [
        'global/plugins/moment.min.js',
        'global/plugins/bootstrap-daterangepicker/daterangepicker.min.js',
        'pages/scripts/components-date-time-pickers.min.js',
    ];
    public $depends = [
        'metronic\assets\CommonAsset',
    ];
}
