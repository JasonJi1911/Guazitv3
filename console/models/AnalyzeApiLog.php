<?php
namespace console\models;

class AnalyzeApiLog extends \common\models\analyze\AnalyzeApiLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'cost'], 'integer'],
            [['url'], 'string', 'max' => 256],
            [['body'], 'string', 'max' => 4096],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => '地址',
            'body' => '请求体',
            'cost' => '消耗时长',
            'created_at' => '创建时间',
        ];
    }
}
