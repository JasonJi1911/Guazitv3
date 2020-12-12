<?php
namespace admin\models;
use yii\helpers\ArrayHelper;

class Domain extends \common\models\Domain
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'content'], 'required'],
            [['type', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['content'], 'string', 'max' => 128],
            [['content'], 'url', 'message' => '该内容不是一个正确得域名']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => '域名内容',
            'type' => '类型',
            'TypeMapLabel' => '类型',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }


    public function getTypeMapLabel()
    {
        return ArrayHelper::getValue(self::$typeMap, $this->type);
    }
}
