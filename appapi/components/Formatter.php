<?php

namespace appapi\components;

use Yii;

class Formatter extends \yii\i18n\Formatter
{
    /**
     * @var string the text to be displayed when formatting a `null` value.
     */
    public $nullDisplay = '';
}
