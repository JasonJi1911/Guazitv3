<?php
namespace common\models\traits;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * 位置Trait
 */
trait PositionTrait
{
    /**
     * @inheritdoc
     */
    public static function positionTexts()
    {
        return [
            self::POSITION_MAN_INDEX    => '男频首页',
            self::POSITION_FEMALE_INDEX => '女频首页',
            self::POSITION_DISCOVER     => '发现页',
        ];
    }

    /**
     * @inheritdoc
     */
    public function getPositionText()
    {
        return ArrayHelper::getValue(static::productTexts(), $this->product);
    }

}
