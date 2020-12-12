<?php
namespace common\models\traits;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * 来源Trait
 */
trait SourceTrait
{
    /**
     * @var array 来源数组
     */
    public static $sources = [
//        self::SOURCE_PC          => 'PC',
//        self::SOURCE_WAP         => 'Wap',
        self::SOURCE_ANDROID_APP => 'Android',
        self::SOURCE_IOS_APP     => 'iOS',
//        self::SOURCE_MP          => '公众号',
//        self::SOURCE_MINI_APP    => '小程序',
    ];

    /**
     * 获取来源
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * 获取来源名称
     * @return string
     */
    public function getSourceText()
    {
        return ArrayHelper::getValue(static::$sources, $this->getSource());
    }
}
