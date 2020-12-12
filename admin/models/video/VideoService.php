<?php
namespace admin\models\video;

use Yii;
use common\helpers\phpexcel\Excel;
use common\helpers\Tool;
use yii\helpers\ArrayHelper;

class VideoService
{
    private $fileName     = null;
    private $videoId      = null;


    public function __construct($fileName,$videoId)
    {
        $this->fileName = $fileName;
        $this->videoId  = $videoId;
    }


    /**
     * 处理Excel文件
     * @return array
     */
    public function handleExcel()
    {
//        var_dump($this->fileName);die();
        $data = Excel::readExcel($this->fileName);
        array_shift($data);
        if (empty($data)) {
            return [];
        }

        $source = VideoSource::find()->select('id')->column();

        $chapterDate = [];
        //入库
        foreach ($data as  &$value) {
            $list = [];
            foreach ($source as $key => $item) {
                $list[$item]= $value[5+$key];
            }

            $chapterDate[] = [
                'video_id' => $this->videoId,
                'title'    => $value[0],
                'resource_url' => json_encode($list),
                'duration_time' => Tool::strToSecond($value[2]),
                'total_views' => intval($value[3]),
                'display_order' => intval($value[1]),
                'play_limit'  => intval($value[4]),
            ];

        }

        Yii::$app->db->createCommand()
            ->batchInsert(VideoChapter::tableName(), ['video_id', 'title', 'resource_url', 'duration_time', 'total_views', 'display_order',  'play_limit'], $chapterDate)
            ->execute();

    }

}