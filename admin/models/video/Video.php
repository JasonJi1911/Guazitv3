<?php
namespace admin\models\video;

use common\helpers\RedisKey;
use common\helpers\Tool;
use yii\helpers\ArrayHelper;
use Yii;

class Video extends \common\models\video\Video
{
    public $actors;
    public $category;

    public $client;

    public function fields()
    {
        return ['id', 'title', 'source', 'cover' => 'thumb', 'description'];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['actors', 'category', 'client', ], 'safe'],
            [['channel_id','is_down', 'type', 'area', 'year', 'score', 'likes_num', 'status', 'is_finished', 'is_sensitive'], 'integer'],
            [['description', 'title', 'is_finished', 'is_down', 'score', 'total_views', 'total_favors', 'total_price', ], 'required'],
            [['category_ids', 'keywords', 'publish_clients',], 'string', 'max' => 128],
            [['title'], 'string', 'max' => 64],
            [['source'], 'string', 'max' => 32],
            [['description'], 'string', 'max' => 2048],

            [['total_views', 'total_favors', 'total_price'], 'integer', 'min' => NUMBER_INPUT_MIN, 'max' => NUMBER_INPUT_MAX],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'channel_id' => 'Channel ID',
            'category_ids' => 'Category Ids',
            'publish_clients' => '发布端',
            'title' => '名称',
            'source' => '作品来源',
            'type' => '视频类型',
            'area' => '地区',
            'year' => '年代',
            'description' => '作品简介',
            'keywords' => 'Keywords',
            'score' => '评分',
            'issue_date' => '上架日期',
            'cover' => '竖版封面',
            'episode_num' => 'Episode Num',
            'total_views' => '总浏览数',
            'total_favors' => '总收藏数',
            'likes_num' => 'Likes Num',
            'status' => '状态',
            'horizontal_cover' => '横板封面',
            'is_finished' => '是否完结',
            'is_sensitive' => '是否敏感',
            'is_down'    => '是否下载',
            'SensitivityText' => '是否敏感',
            'total_price' => '价格',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    /**
     * 获取小封面图
     * @return string
     */
    public function getThumb()
    {
        return $this->cover ? $this->cover->resize(self::ADMIN_COVER_WIDTH / 2, self::ADMIN_COVER_HEIGHT / 2)->toUrl()
            : '';
    }

    /**
     * @return \yii\db\ActiveQuery
     * 关联频道
     */
    public function getChannel()
    {
        return $this->hasOne(VideoChannel::className(), ['id' => 'channel_id']);
    }

    public function getFinishedStatusText()
    {
        return ArrayHelper::getValue(self::$finishedStatus, $this->is_finished);
    }

    public function getSensitivityText()
    {
        return ArrayHelper::getValue(self::$sensitivityMap, $this->is_sensitive);
    }

    /**
     * 获取演员
     */
    public function getActor()
    {
        return $this->hasMany(Actor::className(), ['actor_id' => 'actor_id'])
            ->viaTable(VideoActor::tableName(), ['video_id' => 'id']);
    }

    public function getAreas()
    {
        return $this->hasOne(VideoArea::className(), ['id' => 'area']);
    }

    public function getYears()
    {
        return $this->hasOne(VideoYear::className(), ['id' => 'year']);
    }

    public function beforeSave($insert)
    {
        if (is_array($this->category)) {
            $this->category_ids = implode(',', $this->category);
        }
        // TODO:: 视频的剧集问题
        if ($this->channel_id == 1) {
            $this->type = self::STATUS_SIMPLE;
        } else {
            $this->type = self::STATUS_CONTINUOUS;
        }

        if (is_array($this->client)) {
            $this->publish_clients = implode(',', $this->client);
        }

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        //如果有新的演员
        if ($this->actors) {
            //删除已有的演员信息
            VideoActor::deleteAll(['video_id' => $this->id]);
            $data = [];
            foreach ($this->actors as $actor) {
                $data[] = [
                    'video_id'  => $this->id,
                    'actor_id'   => $actor,
                    'created_at' => time()
                ];
            }
            Yii::$app->db->createCommand()->batchInsert(VideoActor::tableName(), ['video_id', 'actor_id', 'created_at'], $data)->execute();
        }

        if (!$insert) {
            // 删除该视频缓存
            Tool::clearCache(RedisKey::videoInfoPrefix($this->id));
            // 筛选页缓存
            Tool::batchClearCache(RedisKey::VIDEO_FILTER_LIST);
            // 推荐位缓存
            Tool::batchClearCache(RedisKey::recommendVideo(''));
            // 猜你喜欢缓存
            Tool::batchClearCache(sprintf(RedisKey::REFRESH_VIDEO, ''));
            // 排行榜
            Tool::batchClearCache(RedisKey::videoRankList('','',true));
        }
        
        // 如果此视频在排行中，需要清除排行缓存
        if (RankVideo::findOne(['video_id' => $this->id])) {
            RankVideo::clearCache();
        }

        return parent::afterSave($insert, $changedAttributes);
    }
}
