<?php

namespace common\models\video;

use Yii;

/**
 * This is the model class for table "{{%video_aduser}}".
 *
 * @property int $id 自增id
 * @property string $type 企业类型-公司 / 个人
 * @property string $realname 联系人姓名
 * @property string $telephone 手机号
 * @property string $country 国家
 * @property string $address 地址
 * @property string $industry 行业
 * @property string $wechatNO 微信号
 * @property string $email 邮箱
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class VideoAduser extends \xiang\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%video_aduser}}';
    }

}
