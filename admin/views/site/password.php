<?php

use yii\helpers\Html;
use metronic\widgets\ActiveForm;

$this->title = '更新密码';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="portlet light">

    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject bold uppercase"><?= Html::encode($this->title) ?></span>
        </div>
    </div>

    <div class="portlet-body">
        <div class="row">
            <div class="col-md-12">
                <?php

                $form = ActiveForm::begin();

                echo $form->field($model, 'oldPassword')->passwordInput();
                echo $form->field($model, 'newPassword')->passwordInput();
                echo $form->field($model, 'newPassword_repeat')->passwordInput();

                ActiveForm::end();

                ?>

                </div>
        </div>
    </div>
</div>
