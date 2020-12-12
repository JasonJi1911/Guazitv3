<?php
namespace admin\models\setting;

class SettingShare extends \common\models\setting\SettingShare
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'created_at', 'updated_at', 'deleted_at',], 'integer'],
            [['title', 'desc', 'link'], 'string', 'max' => 256],
            [['img'], 'string']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'desc' => '描述',
            'img' => '图片',
            'link' => '链接跳转',
            'type' => 'Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    /**
     * 获取小封面图
     * @return string
     */
    public function getThumb()
    {
        return $this->img ? $this->img->resize(40, 40)->toUrl()
            : '';
    }
}