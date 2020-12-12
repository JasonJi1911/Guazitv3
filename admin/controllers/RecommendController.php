<?php
namespace admin\controllers;

use admin\models\video\Recommend;
use yii\helpers\Html;

class RecommendController extends BaseController
{
    public $name = '推荐位';

    public $modelClass = 'admin\models\video\Recommend';
    public $searchModelClass = 'admin\models\video\search\RecommendSearch';


    public function actionCategory($channelId)
    {
        $recommend = new Recommend();
        $category = $recommend->getCategory($channelId);
        echo Html::tag('option',Html::encode('全部'),array('value'=>''));
        foreach ($category as $key => $value) {
            echo Html::tag('option',Html::encode($value),array('value'=>$key));
        }
    }

    public function actionArea($channelId)
    {
        $recommend = new Recommend();
        $area= $recommend->getArea($channelId);
        echo Html::tag('option',Html::encode('全部'),array('value'=>''));
        foreach ($area as $key => $value) {
            echo Html::tag('option',Html::encode($value),array('value'=>$key));
        }
    }
}