<?php

namespace common\models\setting;

use Yii;
use common\behaviors\UploadBehavior;

/**
 * This is the model class for table "{{%setting_share}}".
 *
 * @property string $id
 * @property string $title 标题
 * @property string $desc 描述
 * @property string $img 图片
 * @property string $link 链接
 * @property int $type 类型，1：公众号
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 */
class SettingShare extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%setting_share}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['upload'] = [
            'class'  => UploadBehavior::className(),
            'config' => [
                'img' => [
                    'extensions' => UploadBehavior::$imageExtensions,
                    'maxSize'    => 100 * 1024 , // 100K
                    'required'   => false,
                    'dir'        => 'img/'. date('Ym') .'/',
                ],
            ],
        ];

        return $behaviors;
    }

}
