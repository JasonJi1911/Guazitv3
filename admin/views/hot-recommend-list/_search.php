<?php
use metronic\widgets\InlineFilterForm;

use admin\models\video\HotRecommend;
use yii\helpers\ArrayHelper;
?>

<?php $form = InlineFilterForm::begin() ?>
<?= $form->field($searchModel, 'title')->label('影片标题') ?>
<?= InlineFilterForm::end() ?>