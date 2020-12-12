<?php
namespace admin\controllers;

use admin\models\stat\search\VideoStatSearch;
use Yii;

class VideoStatController extends BaseController
{
    public $name = '作品统计';

    public $modelClass = 'admin\models\stat\VideoStat';
    public $searchModelClass = 'admin\models\stat\search\VideoStatSearch';

    /**
     * @inheritdoc
     */
    public function actionButtons()
    {
        return [];
    }

}