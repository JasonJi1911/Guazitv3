<?php

namespace common\models\user;

use Yii;

/**
 * This is the model class for table "sf_user_message".
 *
 * @property string $id
 * @property string $uid
 * @property int $type 消息类型，1：系统消息
 * @property string $content
 * @property int $status
 * @property string $created_at
 */
class UserMessage extends \yii\db\ActiveRecord
{
    const TYPE_MESSAGE = 1;
    const TYPE_FEEDBACK_REPLY   = 8;

    public static $messageMap = [
        self::TYPE_MESSAGE => '系统消息',
        self::TYPE_FEEDBACK_REPLY   => '反馈回复',
    ];

    const STATUS_NO = 0; // 未读
    const STATUS_YES = 1; // 已读

    // 类型模板文案
    public static $type_template = [
        self::TYPE_FEEDBACK_REPLY   => '您反馈的问题%s收到回复啦，快去我的->帮助与反馈->我的反馈中查看吧！',
    ];



    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_message}}';
    }


    /**
     * 发送消息通知
     * @param int $uid
     * @param int $messageType
     * @param string $messageContent
     * @return bool
     */
    public static function sendMessageNotice($uid, $messageType, $messageContent)
    {
        $model = new self();
        $model->uid = $uid;
        $model->content = $messageContent;
        $model->type = $messageType;
        $model->save();
        return true;
    }


}
