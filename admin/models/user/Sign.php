<?php
namespace admin\models\user;

class Sign extends \common\models\user\Sign
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['day', 'score', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'day' => 'Day',
            'score' => 'Score',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
