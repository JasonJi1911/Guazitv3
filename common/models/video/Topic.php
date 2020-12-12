<?php

namespace common\models\video;

use common\behaviors\UploadBehavior;
use phpDocumentor\Reflection\Types\Self_;
use Yii;

/**
 * This is the model class for table "{{%topic}}".
 *
 * @property int $id
 * @property int $channel_id 频道id
 * @property string $name 名称
 * @property string $intro 简介
 * @property string $cover 封面地址
 * @property int $is_hot 是否热门 1是 0不是
 * @property int $video_num 专题作品数
 * @property int $total_views 总观看数
 * @property int $display_order 展示排序
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class Topic extends \xiang\db\ActiveRecord
{
    // 是否热门
    const IS_HOT_YES = 1;
    const IS_HOT_NO  = 0;

    public static $isHotMap = [
        self::IS_HOT_NO  => '否',
        self::IS_HOT_YES => '是',
    ];

    // 首页lable四种样式,
    const STYLE_1 = 1;
    const STYLE_2 = 2;
    const STYLE_3 = 3;
    const STYLE_4 = 4;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%topic}}';
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
                'cover' => [ //竖封面
                    'extensions' => UploadBehavior::$imageExtensions,
                    'maxSize'    => 10 * 1024 * 1024 , // 1M
                    'required'   => true,
                    'dir'        => 'video/topic/'. date('Ym'),
                ]
            ],
        ];

        return $behaviors;
    }
}
