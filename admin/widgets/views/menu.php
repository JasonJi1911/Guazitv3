<?php
$js = <<<JS
    $('.page-sidebar-menu a').on('click',function(){
        sessionStorage.setItem('scrollTop', $('.page-sidebar-wrapper').scrollTop());
        
    });

    $('.page-sidebar-menu > li > a').on('click',function(){
        setTimeout(() => {
            $('.page-content').css({'min-height': '100%'});
        }, 300);

    });

    var scrollTop = sessionStorage.getItem('scrollTop');
    $('.page-sidebar-wrapper').scrollTop(scrollTop);
    
JS;
use admin\models\Role;
use yii\helpers\Url;
$this->registerJs($js);
?>
<ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
    <li class="sidebar-toggler-wrapper hide">
        <div class="sidebar-toggler">
            <span></span>
        </div>
    </li>
    
    <li class="nav-item <?= Yii::$app->controller->id == 'site' ? 'active' : '' ?> start">
        <a class="nav-link nav-toggle" href="/">
            <i class="icon-home"></i>
            <span class="title">首页</span>
            <span class="selected"></span>
        </a>
    </li>
    <?php foreach ($menus as $menu1): ?>
        <?php if ($menu1['children']): ?>
        <li class="heading"><h3 class="uppercase"><?= $menu1['name'] ?></h3></li>
        
            <?php foreach ($menu1['children'] as $menu2): ?>
                <?php if (!empty($menu2['children']) && isset($menu2['class'])): ?>
                    <li class="nav-item <?= $menu2['class'] ?>">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="<?= $menu2['icon'] ?>"></i>
                            <span class="title"><?= $menu2['name'] ?></span>
                            <span class="selected"></span>
                            <span class="arrow <?= $menu2['class'] ?>"></span>
                        </a>
                        <ul class="sub-menu" style="display:<?= $menu2['class'] ? 'block' : 'none' ?>">
                            <?php foreach ($menu2['children'] as $menu3): ?>
                                <li class="nav-item <?= $menu3['class'] ?>">
                                    <a href="<?= Url::to(array_merge(['/' . $menu3['route']], $menu3['params'])) ?>" class="nav-link">
                                        <i bclass="<?= $menu3['icon'] ?>"></i>
                                        <span class="title"><?= $menu3['name'] ?></span>
                                        <span class="selected"></span>
                                    </a>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </li>
                <?php elseif (isset($menu2['route'])):?>
                    <li class="nav-item <?= $menu2['class'] ?>">
                        <a href="<?= Url::to(array_merge(['/' . $menu2['route']], $menu2['params']))?>" class="nav-link nav-toggle">
                            <i class="<?= $menu2['icon'] ?>"></i>
                            <span class="title"><?= $menu2['name'] ?></span>
                            <span class="selected"></span>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endforeach ?>
            
        <?php endif ?>

    <?php endforeach ?>
</ul>
