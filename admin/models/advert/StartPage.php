<?php
namespace admin\models\advert;

use admin\models\video\Video;

class StartPage extends \common\models\advert\StartPage
{

    public $video_id; //书籍id
    public $web_url; //web_url

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['skip_type', 'video_id', 'status', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['title'], 'string', 'max' => 60],
            [['content'], 'string', 'max' => 256],
            [['web_url'], 'trim'],
            [['ad_key', 'ad_android_key'], 'string', 'max' => 128],
//            [['title', 'skip_type', 'video_id', 'web_url'], 'required']
            [['title', 'skip_type'], 'required']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'skip_type' => '跳转类型',
            'image' => '启动图',
            'content' => '内容',
            'ad_key' => 'ios广告Key',
            'ad_android_key' => 'Android广告Key',
            'status' => '状态',
            'video_id' => '作品',
            'web_url' => '链接',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function beforeSave($insert)
    {
        if (strpos($_SERVER['REQUEST_URI'], 'active') !== false) {
            if ($this->status == self::STATUS_ENABLED) {
                $where = [];
                if ($this->id) {
                    $where = ['<>', 'id', $this->id];
                }
                self::updateAll(['status' => self::STATUS_DISABLED], $where);
            }
        } else {
            //根据类型来操作
            switch ($this->skip_type) {
                case self::SKIP_TYPE_VIDEO : //书籍
                    $this->content = $this->video_id ? $this->video_id : '';
                    break;

                case self::SKIP_TYPE_WEB : //web_url
                case self::SKIP_TYPE_BROWSER:
                    $this->content = $this->web_url ? $this->web_url : '';
                    break;

                default :
                    break;
            }
        }

        return parent::beforeSave($insert);
    }


    /**
     * 关联书籍
     */
    public function getVideo()
    {
        return $this->hasOne(Video::className(), ['id' => 'video_id']);
    }
}
