<?php
namespace admin\models;

use yii\helpers\ArrayHelper;

class Answer extends \common\models\Answer
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['answer'], 'required'],
            [['answer'], 'string'],
            [['title'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'title' => '问题标题',
            'type' => '问题类型',
            'answer' => '问题答案',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
            'deleted_at' => '删除时间',
        ];
    }

    public function getTypeLabel()
    {
        return ArrayHelper::getValue(self::$typeMap, $this->type);
    }
}
