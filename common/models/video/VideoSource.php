<?php

namespace common\models\video;

use common\behaviors\UploadBehavior;
use Yii;

/**
 * This is the model class for table "{{%video_source}}".
 *
 * @property int $id
 * @property string $name 源名称
 * @property string $icon icon图标
 * @property int $display_order 展示序号
 * @property string $player 播放器地址
 * @property int $play_limit 线路免费：0-免费；1-付费
 * @property int $created_at 创建时间
 * @property int $updated_at
 * @property int $deleted_at
 */
class VideoSource extends \yii\db\ActiveRecord
{

    const SOURCE_FREE  = 0; //免费线路
    const SOURCE_PAY = 1; //付费线路

    public static $playlimitMap = [
        self::SOURCE_FREE  => '免费',
        self::SOURCE_PAY => '付费'
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%video_source}}';
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
                'icon' => [ //竖封面
                    'extensions' => UploadBehavior::$imageExtensions,
                    'maxSize'    => 1024 * 1024 , // 1M
                    'required'   => true,
                    'dir'        => 'video/source_icon/'. date('Ym'),
                ]
            ],
        ];

        return $behaviors;
    }

}
