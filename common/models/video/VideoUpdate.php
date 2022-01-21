<?php

namespace common\models\video;

use common\models\traits\SchemeTrait;
use common\models\traits\SourceInterface;
use common\models\traits\SourceTrait;
use common\models\traits\StatusToggleInterface;
use common\models\traits\StatusToggleTrait;
use Yii;

/**
 * This is the model class for table "{{%video_update}}".
 *
 * @property int $id 序号id
 * @property int $video_id 视频id
 * @property int $video_update_title_id 更新标题id
 * @property int $week 更新时间
 * @property string $title 标题
 * @property string $stitle 副标题
 * @property int $display_order 排序
 * @property int $status 状态：1-显示，2-隐藏
 * @property int $created_at 创建时间
 * @property int $updated_at 修改时间
 * @property int $deleted_at 删除时间
 */
class VideoUpdate extends \xiang\db\ActiveRecord implements StatusToggleInterface,SourceInterface
{
    use SourceTrait;
    use StatusToggleTrait;

    //更新时间
    const WEEEK_MON = 1; //周一
    const WEEEK_TUE = 2; //周二
    const WEEEK_WED = 3; //周三
    const WEEEK_THU = 4; //周四
    const WEEEK_FRI = 5; //周四
    const WEEEK_SAT = 6; //周六
    const WEEEK_SUN = 7; //周日
    public static $weekTypes = [
        self::WEEEK_MON => '周一',
        self::WEEEK_TUE => '周二',
        self::WEEEK_WED => '周三',
        self::WEEEK_THU => '周四',
        self::WEEEK_FRI => '周四',
        self::WEEEK_SAT => '周六',
        self::WEEEK_SUN => '周日'
    ];

    public static $statusMap = [
        self::STATUS_ENABLED  => '显示',
        self::STATUS_DISABLED => '隐藏',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%video_update}}';
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
