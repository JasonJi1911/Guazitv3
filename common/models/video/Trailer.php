<?php

namespace common\models\video;

use common\models\traits\SchemeTrait;
use common\models\traits\SourceInterface;
use common\models\traits\SourceTrait;
use common\models\traits\StatusToggleInterface;
use common\models\traits\StatusToggleTrait;
use Yii;

/**
 * This is the model class for table "{{%trailer}}".
 *
 * @property int $id 序号id
 * @property int $video_id 视频id
 * @property int $trailer_title_id 预告标题id
 * @property string $title 标题
 * @property string $stitle 副标题
 * @property int $online_time 上线时间
 * @property int $display_order 排序
 * @property int $status 状态：1-显示，2-隐藏
 * @property int $created_at 创建时间
 * @property int $updated_at 修改时间
 * @property int $deleted_at 删除时间
 */
class Trailer extends \xiang\db\ActiveRecord implements StatusToggleInterface,SourceInterface
{
    use SourceTrait;
    use StatusToggleTrait;

    public static $statusMap = [
        self::STATUS_ENABLED  => '显示',
        self::STATUS_DISABLED => '隐藏',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%trailer}}';
    }


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();


        return $behaviors;
    }

}