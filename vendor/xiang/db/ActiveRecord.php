<?php

namespace xiang\db;

use Yii;
use yii\behaviors\TimestampBehavior;
use xiang\behaviors\SoftDeleteBehavior;

/**
 * AR基类
 */
class ActiveRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = [
            // 时间戳
            'timestamp' => [
                'class' => TimestampBehavior::className()
            ],
        ];

        // 开启了软删除 并且有删除这个字段
        if (isset(static::getTableSchema()->columns['deleted_at'])) {
            $behaviors['softDelete'] = [
                'class' => SoftDeleteBehavior::className()
            ];
        }
        return $behaviors;
    }

    /**
     * {@inheritdoc}
     * @return ActiveQuery the newly created [[ActiveQuery]] instance.
     */
    public static function find()
    {
        return Yii::createObject(ActiveQuery::className(), [get_called_class()]);
    }

    /**
     * 查找或抛出异常
     * @param $condition
     * @return null|static
     * @throws NotFoundException
     */
    public static function findOrFail($condition)
    {
        if (($model = static::findOne($condition)) !== null) {
            return $model;
        }

        throw new NotFoundException('查找的模型不存在');
    }

    /**
     * @inheritdoc
     */
    protected function createRelationQuery($class, $link, $multiple)
    {
        if (strpos($class, '\\') === false) {
            $class = substr(static::className(), 0, strrpos(static::className(), '\\') + 1) . $class;
        }

        return parent::createRelationQuery($class, $link, $multiple);
    }
}
