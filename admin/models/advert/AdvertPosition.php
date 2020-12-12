<?php
namespace admin\models\advert;

class AdvertPosition extends \common\models\advert\AdvertPosition
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['position', 'status', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'position' => 'Position',
            'status' => '状态',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
}