<?php
use common\helpers\Tool;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use admin\models\video\VideoChannel;
use metronic\assets\DateRangePickerAsset;

DateRangePickerAsset::register($this);

$this->render('../base/_filters');

?>

<div class="portlet light">
    <div class="portlet-title">
        在架影视作品数:<?= $searchModel->countNum()?>;
        <?= $this->render('../statistic/statistic_nav')?>
    </div>

    <div class="portlet-body">
        <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-12">
                <div class="info-box info-block">
                    <div class="home-block-left">
                    </div>
                    <div class="home-block-right">
                        <div class="sum_pay_by_time" style="color: #a9c6e0">
                            <span>播放影视部数</span>
                            <div style="color: #a9c6e0;">
                                <span>
                                     <?= $searchModel->videoNum()?>
                                </span>
                            </div>
                        </div>
                        <ul>
                            <li>
                                <div>今天: <?= $searchModel->videoNum(date('Y-m-d'), 1)?></div>
                                <div>昨天: <?= $searchModel->videoNum(date('Y-m-d', strtotime('-1 days')), 1)?></div>
                                <div>7&nbsp;天: <?= $searchModel->videoNum(date('Y-m-d', strtotime('-6 days')), 7)?></div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <div class="info-box info-block">
                    <div class="home-block-left" style="background-color: #a5b96e">
                    </div>
                    <div class="home-block-right">
                        <div class="sum_pay_by_time" style="color: #a5b96e">
                            <span>影视访问人数</span>
                            <div style="color: #a5b96e;">
                                <span>
                                     <?= $searchModel->visitNum()?>
                                </span>
                            </div>
                        </div>
                        <ul>
                            <li>
                                <div>今天: <?= $searchModel->visitNum(date('Y-m-d'), 1)?></div>
                                <div>昨天: <?= $searchModel->visitNum(date('Y-m-d', strtotime('-1 days')), 1)?></div>
                                <div>7&nbsp;天: <?= $searchModel->visitNum(date('Y-m-d', strtotime('-6 days')), 7)?></div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <div class="info-box info-block">
                    <div class="home-block-left" style="background-color: #c1b6ae">
                    </div>
                    <div class="home-block-right">
                        <div class="sum_pay_by_time" style="color: #c1b6ae">
                            <span>影视播放次数</span>
                            <div style="color: #c1b6ae;">
                                <span>
                                     <?= $searchModel->playNum()?>
                                </span>
                            </div>
                        </div>
                        <ul>
                            <li>
                                <div>今天: <?= $searchModel->playNum(date('Y-m-d'), 1)?></div>
                                <div>昨天: <?= $searchModel->playNum(date('Y-m-d', strtotime('-1 days')), 1)?></div>
                                <div>7&nbsp;天: <?= $searchModel->playNum(date('Y-m-d', strtotime('-6 days')), 7)?></div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <div class="info-box info-block">
                    <div class="home-block-left" style="background-color: #e2aa95">
                    </div>
                    <div class="home-block-right">
                        <div class="sum_pay_by_time" style="color: #fb9f7b">
                            <span>付款影视部数</span>
                            <div style="color: #e2aa95;">
                                <span>
                                     <?= $searchModel->payVideoNum()?>
                                </span>
                            </div>
                        </div>
                        <ul>
                            <li>
                                <div>今天: <?= $searchModel->payVideoNum(date('Ymd'), 1)?></div>
                                <div>昨天: <?= $searchModel->payVideoNum(date('Ymd', strtotime('-1 days')), 1)?></div>
                                <div>7&nbsp;天: <?= $searchModel->payVideoNum(date('Ymd', strtotime('-6 days')), 7)?></div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<form class="form-horizontal filter-form" >
    <div class="form-group">
        <label class="control-label col-md-1">搜索:</label>
        <div class="col-md-7">
            <?= Html::activeTextInput($searchModel, 'title', ['class' => 'form-control', 'placeholder' => '影视名称', 'style' => 'width:50%; float:left; margin-right:5px;']) ?>
            <button class="btn btn-primary">搜索</button>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-1">频道:</label>
        <div class="col-md-11">
            <?= printFilters($searchModel, 'channel', ArrayHelper::map(VideoChannel::findAll(['status' => VideoChannel::STATUS_ENABLED]), 'id', 'channel_name')) ?>
            <?= Html::activeHiddenInput($searchModel, 'sort') ?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-1">排序:</label>
        <div class="col-md-11">
            <?= printFilters($searchModel, 'sort', $searchModel::$sorts) ?>
            <?= Html::activeHiddenInput($searchModel, 'sort') ?>
        </div>
    </div>
</form>




