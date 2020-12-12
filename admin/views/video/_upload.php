<?php

use yii\helpers\Html;
use admin\models\video\VideoUploadTask;
//use admin\models\BookUploadTask;
use metronic\widgets\ActiveForm;
if (Yii::$app->session->getFlash('updated')) {
    \metronic\assets\ToastrAsset::register($this);
    $this->registerJs('toastr.success("保存成功", "", {timeOut: 1000});');
}

\metronic\assets\DateRangePickerAsset::register($this);

$this->title = '上传影视剧集';
$this->params['breadcrumbs'][] = ['url' => ['/video/index'], 'label' => '影视管理'];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="portlet light">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject bold uppercase"><?= Html::encode($this->title) ?></span>
        </div>
        <div class="actions">
            <?= Html::button('返回', ['class' => 'btn default', 'onclick' => 'history.back()'])?>
        </div>
    </div>

    <div class="note note-info">
        <p>
            上传作品时，程序会后台上传读取，异步上传处理剧集会根据剧集大小有一定的时间延迟，可稍后在<?= Html::a('剧集管理','/video/index')?>中查看剧集是否完整，上传文件只支持上传excel文件<br/>
            上传剧集分为<font color="red">新传</font>和<font color="red">续传</font>两种模式，新传模式会<font style="color: red;">清理掉已有剧集</font>，续传模式会<font color="red">保留影视已有剧集</font>，请选择正确的上传模式； <br />
            excel文件格式为固定格式，可<a href="/demo.xlsx" download="demo.xlsx">点击下载</a>查看模板；<br />
            要严格按照excel文件格式上传，多填或者漏填会造成入库时的数据溢出或者应数据遗漏造成的上传失败<br/>
            <font color="red">如果后台新增来源，则需要在excel文件中新增资源地址</font>
        </p>
    </div>
    
    <div class="book-form">

        <?php $form = ActiveForm::begin() ?>

        <?= $form->field($model, 'upload_type')->radioList(VideoUploadTask::$uploadTypeMap, ['value' => VideoUploadTask::UPLOAD_TEXT_NEW]) ?>

        <?= $form->field($model, 'upload_file')->imageUpload(['width' => 150, 'height' => 35, 'file_type' => 2])->label('文件<span class="required">*</span>') ?>

        <?php ActiveForm::end() ?>

    </div>


</div>
