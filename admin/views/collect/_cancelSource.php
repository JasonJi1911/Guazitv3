<?php
use admin\models\collect\Collect;
use metronic\grid\GridView;
use yii\helpers\Html;

$this->params['breadcrumbs'] = [];
$this->title = '视频采集';
$this->params['breadcrumbs'][] = "数据中心";
$this->params['breadcrumbs'][] = $this->title;
?>

<style type="text/css">
    .span-bold{
        font-weight:bold;
        color:#ff0000
    }

    .f-red{
        color: rgb(255, 0, 0);
    }

    .f-green{
        color: rgb(0, 128, 0);
    }
</style>
<br>
当前采集任务
<strong class="green">
    <?= $data['page']['page'] ?>
</strong>
/<span class="span-bold">
    <?= $data['page']['pagecount']?>
</span>
页 采集地址&nbsp;<?= $data['page']['url']?>
<br>
<?php foreach($messages as $k=>$v) :?>
    <?= ($k + 1) .'、'. $v['vod_name'] ?>
    <span class="<?= $v['color'] ?>"><?= $v['des'] ?></span>
    <?= $v['msg'] ?>
    <br>
<?php endforeach;?>

<?php if(intval($data['page']['page']) != intval($data['page']['pagecount'])) :?>
    <span class="span-bold">暂停1秒后继续  >>>  </span>
    <?=
    Html::a('如果您的浏览器没有自动跳转，请点击这里',
        [
            '/collect/cancel-all',
            'cjflag' => $param['cjflag'],
            'page' => (intval($data['page']['page']) + 1),
            'source' => $param['source'],
        ],
        ['class' => 'btn btn-outline btn-circle btn-xs green', 'id' => 'next-page']);
    ?>
    <br>
    <script></script>
    <script>
        setTimeout(
            function (){
                console.log($('#next-page').attr('href'));
                location.href=$('#next-page').attr('href');
            },1000);
    </script>
<?php else: ?>
    <span class="span-bold">采集完成  >>>  </span>
    <?=
    Html::a('返回列表页',
        [
            '/collect/index',
        ],
        ['class' => 'btn btn-outline btn-circle btn-xs green', 'id' => 'index-page']);
    ?>
<?php endif; ?>


