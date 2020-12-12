<?php
namespace admin\models;

class Announcement extends \common\models\Announcement
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product', 'status'], 'integer'],
            [['title'], 'string', 'max' => 25],
            [['title'], 'required'],
            [['content'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'title'      => '标题',
            'content'    => '内容',
            'product'    => '产品线',
            'status'     => '状态',
            'created_at' => 'Created At',
            'updated_at' => '修改时间',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function beforeSave($insert)
    {
        // TODO
        $this->product = 1;
        return parent::beforeSave($insert);
    }

    public static function currentProduct()
    {
        return array_keys(self::productTexts());
    }
}