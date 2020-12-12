<?php
namespace admin\models\user;

class SignLog extends \common\models\user\SignLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'date', 'year_month', 'sign_days', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['trade_no'], 'string', 'max' => 32],
            [['uid', 'date'], 'unique', 'targetAttribute' => ['uid', 'date']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'trade_no' => 'Trade No',
            'date' => 'Date',
            'year_month' => 'Year Month',
            'sign_days' => 'Sign Days',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
}
