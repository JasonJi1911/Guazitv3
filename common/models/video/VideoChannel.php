<?php

namespace common\models\video;

use common\behaviors\UploadBehavior;
use common\models\traits\StatusToggleInterface;
use common\models\traits\StatusToggleTrait;
use Yii;

/**
 * This is the model class for table "{{%video_channel}}".
 *
 * @property int $id 频道id
 * @property string $channel_name 频道名
 * @property string $icon 频道icon
 * @property string $description 描述
 * @property string $areas 地区 多地区以,拼接
 * @property int $display_order 展示排序
 * @property int $is_kingkong 是否首页推荐
 * @property int $status 状态 1上线 2下线
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class VideoChannel extends \xiang\db\ActiveRecord implements StatusToggleInterface
{
    use StatusToggleTrait;


    // 是否首页常量
    const STATUS_KINGKONG_YES = 1;
    const STATUS_KINGKONG_NO  = 0;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%video_channel}}';
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
                    'maxSize'    => 10 * 1024 * 1024 , // 10M
                    'required'   => true,
                    'dir'        => 'video/channel/'. date('Ym'),
                ]
            ],
        ];

        return $behaviors;
    }

}
