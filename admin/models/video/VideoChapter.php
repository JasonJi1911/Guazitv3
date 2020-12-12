<?php
namespace admin\models\video;

use common\helpers\RedisKey;
use common\helpers\Tool;
use yii\helpers\ArrayHelper;

class VideoChapter extends \common\models\video\VideoChapter
{

    public static function find()
    {
        return parent::find()->addOrderBy(['display_order' => SORT_ASC]);

    }

    public $resource;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['total_views'], 'required'],
            [['video_id'], 'integer'],
            [['title'], 'string', 'max' => 64],
            [['resource'], 'safe'],
//            [['resource'], 'required'],
            [['title', 'display_order', 'duration_time', 'play_limit'], 'required'],
            [['display_order', 'total_views'], 'integer', 'min' => NUMBER_INPUT_MIN, 'max' => NUMBER_INPUT_MAX]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'video_id' => 'Video ID',
            'title' => '剧集标题',
            'resource_url' => 'Resource Url',
            'duration_time' => '时长',
            'total_views' => '浏览数',
            'play_limit' => '播放条件',
            'display_order' => '剧集序号',
            'limitLabel' => '播放条件',
            'resource' => '资源地址',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function beforeSave($insert)
    {
        // 处理视频时长的问题
        if ($this->duration_time) {
            $durationTime = preg_split('/[-|:|：]/', $this->duration_time);

            $hour   = isset($durationTime[count($durationTime) - 3]) ? $durationTime[count($durationTime) - 3] : 0;
            $minute = isset($durationTime[count($durationTime) - 2]) ? $durationTime[count($durationTime) - 2] : 0;
            $second = isset($durationTime[count($durationTime) - 1]) ? $durationTime[count($durationTime) - 1] : 0;
            $this->duration_time = $hour * 3600 + $minute * 60 + $second;
        }
        if ($this->resource) {
            $this->resource_url = $this->_formatSource($this->resource);
        }

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        // 修改影视播放限制
        $playLimit = self::find()->where(['video_id' => $this->video_id, 'deleted_at' => 0])->max('play_limit');
        // 查询剧集数
        $videoNum = self::find()->where(['video_id' => $this->video_id, 'deleted_at' => 0])->count();

        $video = Video::findOne(['id' => $this->video_id]);
        $video->play_limit = $playLimit;
        $video->episode_num = $videoNum;
        $video->save();

        // 删除影视redis
        Tool::clearCache(RedisKey::videoChapter($this->video_id));
        Tool::clearCache(RedisKey::videoInfoPrefix($this->video_id));

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * 关联影片
     */
    public function getVideo()
    {
        return $this->hasOne(Video::className(), ['id' => 'video_id']);
    }

    public function getlimitLabel()
    {
        return ArrayHelper::getValue(self::$playLimitMap, $this->play_limit);
    }

    /**
     * 资源格式化
     * @param $resource
     * @return array
     */
    private function _formatSource($resource)
    {
        if (!$resource) { // 没有返回空
            return $resource;
        }

        foreach ($resource as &$url) {
            if (strrchr($url, '.') == '.m3u8') {
                $file = Tool::httpGet($url);
                if ($file['errno']) { // 源资源有问题
                    continue;
                }
                $file['data'] = trim($file['data']); // 去除空格
                if ((strrchr($file['data'], '.') != '.m3u8')) { // 如果不是嵌套类型的文件跳过
                    continue;
                }

                $fileData = explode("\n", $file['data']); // 把内容换行切割
                $mimeType = array_pop($fileData);
                if (substr($mimeType, 0, 1) == '/') { // 第一个为/ 取绝对域名
                    $parseUrl = parse_url($url);
                    $url = $parseUrl['scheme'] . '://' . $parseUrl['host'] . $mimeType;
                } else { // 取相对域名
                    $url = substr($url, 0, strripos($url, '/') + 1) . $mimeType;
                }
            }
        }

        return json_encode($resource, JSON_UNESCAPED_UNICODE);
    }
}
