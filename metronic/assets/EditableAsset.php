<?php
/**
 * Created by PhpStorm.
 * User: hejinlong
 * Date: 2018/5/6
 * Time: 上午2:35
 */

namespace metronic\assets;

use yii\web\AssetBundle;

/**
 * Metronic Date Picker
 */
class EditableAsset extends AssetBundle
{
    public $sourcePath = '@metronic/static';
    public $css = [
        'global/plugins/editable/css/bootstrap-editable.css',
    ];
    public $js = [
        'global/plugins/editable/js/bootstrap-editable.js',
    ];
    public $depends = [
        'metronic\assets\CommonAsset',
    ];
}
