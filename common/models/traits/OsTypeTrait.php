<?php
namespace common\models\traits;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * 产品线Trait
 */
trait OsTypeTrait
{

    public static $osTypes = [
        self::OS_TYPE_IOS       => 'iOS生产环境',
        self::OS_TYPE_ANDROID   => 'Android',
        self::OS_TYPE_IOS_DEV   => 'iOS开发环境',
    ];

    /**
     * @inheritdoc
     */
    public static function osTypeTexts()
    {
        return self::$osTypes;
    }

    /**
     * @inheritdoc
     */
    public function getOsTypeText()
    {
        return ArrayHelper::getValue(static::osTypeTexts(), $this->os_type);
    }

}
