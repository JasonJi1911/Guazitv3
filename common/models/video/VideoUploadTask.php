<?php

namespace common\models\video;

use Yii;

/**
 * This is the model class for table "{{%video_upload_task}}".
 *
 * @property string $id
 * @property string $file 文件地址
 * @property string $video_id 影视id
 * @property int $upload_type 上传类型 1新传 2续传
 * @property int $status 状态 0未处理 1已处理
 * @property string $import_chapters 入库剧集数
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 * @property string $deleted_at 删除时间
 */
class VideoUploadTask extends \xiang\db\ActiveRecord
{

    //上传的类型
    const UPLOAD_TEXT_NEW = 1;
    const UPLOAD_TEXT_UPDATE = 2;

    public static $uploadTypeMap = [
        self::UPLOAD_TEXT_NEW    => '新传剧集',
        self::UPLOAD_TEXT_UPDATE => '续传剧集',
    ];

    const STATUS_UNTREATED = 0; //未完成
    const STATUS_DONE      = 1; //已完成
    const STATUS_IN_HAND   = 2; //处理中

    public static $statusMap = [
        self::STATUS_UNTREATED => '未完成',
        self::STATUS_DONE      => '已完成',
        self::STATUS_IN_HAND   => '处理中',
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%video_upload_task}}';
    }


}
