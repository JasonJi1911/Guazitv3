<?php

use yii\helpers\Html;
use metronic\grid\GridView;
use admin\models\advert\Advert;
use admin\models\advert\AdvertPosition;

$this->params['breadcrumbs'] = [];
$this->title = '广告列表';
$this->params['breadcrumbs'][] = ['url' => '/advert/auto-click', 'label' => '广告流量控制'];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="note note-info">
    <p>广告在前端显示为带链接图片</p>
    <p>外部跳转意为在APP浏览器内跳转</p>
</div>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'metronic\grid\SerialColumn'],
        [
            'attribute' => 'position_id',
            'value' => function($model) {
                if (!$model->advertPosition) {
                    return '--';
                }
                return AdvertPosition::$positionMap[$model->advertPosition->position];
            }
        ],
        'title',
      /*  [
            'attribute' => 'ad_type',
            'value' => function ($model) {
                return Advert::$adTypes[$model->ad_type];
            }
        ],*/
        [
            'attribute' => 'image',
            'format' => 'raw',
            'value' => function($model){
                if ($model->ad_type == Advert::AD_TYPE_WEB) {
                    if (strpos($model->image, '.mp4') !== false)
                        return '<video src="'.$model->image.'" width="200px" height="100px" alt=""></video>';
                        
                    return Html::img($model->image->resize(200, 100), ['width' => '200px', 'height' => '100px']);
                }
                return '--';
            }
        ],
        [
            'attribute' => 'skip_url',
            'format' => 'raw',
            'value' => function($model) {
                if ($model->ad_type == Advert::AD_TYPE_WEB) {
                    return $model->skip_url;
                }
                return '--';
            }
        ],
        [
            'attribute' => 'url_type',
            'format' => 'raw',
            'value' => function($model) {
                if ($model->ad_type == Advert::AD_TYPE_WEB) {
                    return Advert::$urlTypes[$model->url_type];
                }
                return '--';
            }
        ],
      /*  [
            'label' => '苹果广告key',
            'value' => function ($model) {
                return $model->ad_key ? $model->ad_key : '--';
            }
        ],
        [
            'label' => '安卓广告key',
            'value' => function ($model) {
                return $model->ad_android_key ? $model->ad_android_key : '--';
            }
        ],*/
        'pv',
        'click',
        'cityName',
        [
            'class' => 'metronic\grid\ActionColumn',
            'template' => '{run}',
            'buttons' => [
                'run' => function ($url, $model) {
                    return Html::a('<i class="fa fa-plus">自动</i>', ['advert/run-click'],
                        ['class' => 'btn btn-outline btn-circle btn-xs red autoclick', 'data-adid' => $model->id, 'data-url' => $model->skip_url]);
                },
                'stop' => function ($url, $model) {
                    return Html::a('<i class="fa fa-plus">停止</i>', ['advert/run-click'],
                        ['class' => 'btn btn-outline btn-circle btn-xs red stopclick', 'data-adid' => $model->id, 'data-url' => $model->skip_url]);
                }
            ]
        ],
    ],
]); ?>

<script src="/js/jquery.js"></script>
<script>
    let wechattimer = "";
    let index = 0;
    var arrIndex = {};
    
    function randomNum(minNum,maxNum){ 
        switch(arguments.length){ 
            case 1: 
                return parseInt(Math.random()*minNum+1,10); 
            break; 
            case 2: 
                return parseInt(Math.random()*(maxNum-minNum+1)+minNum,10); 
            break; 
                default: 
                    return 0; 
                break; 
        } 
    } 
    $(".autoclick").click(function(){
        var action = $(this).attr("href");
        var adUrl = $(this).attr("data-url");
        var advert_id = $(this).attr("data-adid");
        // alert(adUrl);
        // alert(advert_id);
        
        arrIndex["adUrl"] = adUrl;
        arrIndex["advert_id"] = advert_id;
        
        // console.log(randomNum(1000, 60000));
        
        $.get(action, arrIndex, function(response) {
            console.log(response);
        });
        clearInterval(wechattimer);
        wechattimer = setInterval(function() {
                if(index > 300)
                    clearInterval(wechattimer);
                    
				$.get(action, arrIndex ,function(response) {
					
				});
				index++;
			}, 60);
        return false;
    });
    
    $(".stopclick").click(function(){
        clearInterval(wechattimer);
        return false;
    });
</script>