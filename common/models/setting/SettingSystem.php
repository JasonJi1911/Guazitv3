<?php

namespace common\models\setting;

use common\models\traits\SwitchToggleInterface;
use common\models\traits\SwitchToggleTrait;
use Yii;

/**
 * This is the model class for table "{{%setting_system}}".
 *
 * @property int $id
 * @property string $site_name 网站名称
 * @property string $area_limit 地区限制 ,拼接
 * @property string $currency_unit 货币名称
 * @property string $currency_coupon
 * @property int $ad_switch 广告开关
 * @property int $comment_switch 评论开关
 * @property int $remove_ad_score 积分去广告
 * @property int $coupon_expire_time
 * @property int $play_ad_time 播放影片广告时间
 */
class SettingSystem extends \yii\db\ActiveRecord implements SwitchToggleInterface
{
    use SwitchToggleTrait;

    //是否开启评论审核
    const COMMENT_REVIEW_ON  = 1; //开启
    const COMMENT_REVIEW_OFF = 2; //关闭
    // 是否开启三方支付
    const THIRD_PAY_ON = 1; // 开启
    const THIRD_PAY_OFF = 2; // 关闭

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%setting_system}}';
    }
}
