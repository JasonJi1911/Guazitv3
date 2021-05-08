<?php
use yii\helpers\Url;
use pc\assets\StyleSpring;

$this->title = '瓜子TV - 澳新华人在线视频分享平台,海量高清视频在线观看';
StyleSpring::register($this);

$js = <<<JS
$(function(){
    $().ready(function() {
        $('.editor-review ul li').click(function() {
            var index = $(this).index();
            $(this).addClass('active').siblings().removeClass('active');
            $(this).parents('.Findparent').find('.togparents .hidenlink').eq($(this).index()).addClass('active').siblings()
                .removeClass('active');
            $('.announcement-sd ul li').attr('style', 'display:none');
            $('.announcement-sd ul li').eq(index).attr('style', 'display:block');
        })

    });
    
    $(".activity-sxlist ul li").click(function() {
        $(this).addClass('active-1').siblings().removeClass('active-1');
    });
    
    function Show_Hidden(obj) {
        if (obj.style.display == "block") {
            obj.style.display = 'none';
        } else {
            obj.style.display = 'block';
        }
    };
    window.onload = function() {
        var olink = document.getElementById("link");
        var odiv = document.getElementById("thediv");
        olink.onclick = function() {
            Show_Hidden(odiv);
            $("#link").parent().toggleClass("div_w");
            return false;
        }
    };
    
    var arrIndex = {};
    var progress = false; // 是否正在请求中
    var isFlag = true;
    $(document).on('click', '.cate-list-li', function() {
        var type = $(this).attr('data-type');
        var value = $(this).attr('data-value');
        
        //追加筛选参数
        arrIndex[type] = value;
        arrIndex['page_num']= 1;
        arrIndex['keyword'] = $('#keywords').val();
        $(this).parent().addClass('active-1').siblings().removeClass('active-1');
        
        console.log(arrIndex);
        $(".spinner").fadeIn();
        //发送请求，获取数据
        $.get('/video/refresh-cate', arrIndex, function(s) {
            refreshCate(s.data.search_box);
        });
        //发送请求，获取数据
        $.get('/video/refresh-video', arrIndex, function(s) {
            $('.vcontent').html(s); // 更新内容
            $('#vcount').html($("#parcount").val()); //刷新影片数
            $('.modal-paging').attr('data-page', 1); //刷新ye数
            $('.modal-paging').attr('data-pages', $("#parpages").val()); //刷新ye数
            $(".spinner").fadeOut();
        });
    });
    
    //刷新筛选条件
    function refreshCate(list) {
        var content = '';
        for(var i=0;i<list.length; i++) {
            if(list[i]['label'] == '排序')
                continue
                
            content += "<div class='activity-sxlist clearfix'>" + 
                            "<div class='tabel'>" + list[i]['label'] + "：</div>" +
                             "<ul class='clearfix'>";
            var selectFlag = false;
            
            for(var j=0;j<list[i]['list'].length; j++) {
                if(list[i]['list'][j]['checked'] == 1) {
                    selectFlag = true;
                }
            }

           for(var k=0;k<list[i]['list'].length;k++) {
              if(list[i]['list'][k]['checked'] == 1) {
                  if(list[i]['field'] == 'channel_id')
                  {
                       content += "<input type='hidden' id='channel-id' value='"+list[i]['list'][k]['value']+"'>";
                  }
                  content += "<li class='active-1' " +
                            "data-value='"+list[i]['list'][k]['value']+"'" +
                             " data-type='"+list[i]['field']+"'>" +
                             "<a class='cate-list-li'" +
                                  "data-value='"+list[i]['list'][k]['value']+"'" +
                                 " data-type='"+list[i]['field']+"'>" +
                                  ""+list[i]['list'][k]['display']+"</a></li>";
                  continue;
              }
              content += "<li class='' " +
                            "data-value='"+list[i]['list'][k]['value']+"'" +
                             " data-type='"+list[i]['field']+"'>" +
                             "<a class='cate-list-li'" +
                                  "data-value='"+list[i]['list'][k]['value']+"'" +
                                 " data-type='"+list[i]['field']+"'>" +
                                  ""+list[i]['list'][k]['display']+"</a></li>";
            }

            content +="</ul>" +
                       "</div>";
        }
        
        $('#thediv').html(content);
    }
    
    //下拉加载更多
    $(window).scroll(function () {
        if (($(window).scrollTop()+488) >= $(document).height() - $(window).height()) {
            if(isFlag) {
                    arrIndex['keyword'] = $('#keywords').val();
                    var arrScroll = arrIndex;
                    var pages = $('.modal-paging').attr('data-pages') || 1;
                    var page  = $('.modal-paging').attr('data-page') || 1;
                    var url = $('.modal-paging').attr('data-url');
                    
                     if (parseInt(page) < parseInt(pages) && !progress) {
                        progress = true;
                        page++;
                        var params = {};
                        arrScroll['page_num'] = page;
                        params = arrScroll;
                        $(".spinner").fadeIn();
                        $.get(url, params, function(res) {
                            if(res) {
                                 $("#parpage").remove();
                                 $("#parpages").remove();
                                 $("#parcount").remove();
                                 $('.vcontent').append(res); // 更新内容
                                 $('.modal-paging').attr('data-pages', $("#parpages").val()); //刷新ye数
                                 $('.modal-paging').attr('data-page', $("#parpage").val()); //刷新ye数
                                 $(".spinner").fadeOut();
                            }
                             progress = false;
                        });
                     } else if (page == pages) {
                         progress = false;
                     }
                isFlag = false;
            }
        }else {
            isFlag = true;
        }
    });
    
    $(".sort").click(function (){
        $(".sort").each(function (){
            $(this).removeClass("div_w");
        });
        $(this).addClass("div_w");
    });
    
    $(".viitem").click(function (){
        $(this).find('a')[0].click();
    });
});
JS;

$this->registerJs($js);
?>
    <style>
        .cate-list-li:hover{
            cursor: pointer;
        }

        .spinner {
            /* margin: 100px auto; */
            width: 200px;
            height: 60px;
            text-align: center;
            font-size: 10px;
            top: 50%;
            left: 50%;
            position: fixed;
            display: none;
        }

        .spinner .ani {
            background-color: #FF556E;
            height: 100%;
            width: 6px;
            display: inline-block;

            -webkit-animation: stretchdelay 1.2s infinite ease-in-out;
            animation: stretchdelay 1.2s infinite ease-in-out;
        }

        .spinner .rect2 {
            -webkit-animation-delay: -1.1s;
            animation-delay: -1.1s;
        }

        .spinner .rect3 {
            -webkit-animation-delay: -1.0s;
            animation-delay: -1.0s;
        }

        .spinner .rect4 {
            -webkit-animation-delay: -0.9s;
            animation-delay: -0.9s;
        }

        .spinner .rect5 {
            -webkit-animation-delay: -0.8s;
            animation-delay: -0.8s;
        }

        @-webkit-keyframes stretchdelay {
            0%, 40%, 100% { -webkit-transform: scaleY(0.4) }
            20% { -webkit-transform: scaleY(1.0) }
        }

        @keyframes stretchdelay {
            0%, 40%, 100% {
                transform: scaleY(0.4);
                -webkit-transform: scaleY(0.4);
            }  20% {
                   transform: scaleY(1.0);
                   -webkit-transform: scaleY(1.0);
               }
        }
    </style>
    <div class="header-header">
        <div class="activity-item">
            <div class="active-item">
                <ul class="clearfix">
                    <?php foreach ($info['search_box'] as $cates): ?>
                        <?php if($cates['label'] == '排序') : ?>
                            <?php foreach ($cates['list'] as $key => $catet): ?>
                                <?php if($cates['field'] == 'channel_id' && $catet['checked'] == 1) : ?>
                                    <input type="hidden" id="channel-id" value="<?= $catet['value']?>">
                                <?php endif;?>
                                <li class="sort <?= $catet['checked'] == 1 ? 'div_w' : ''?>"
                                    data-value="<?= $catet['value']?>"
                                    data-type="<?= $cates['field']?>">
                                    <a class="cate-list-li" data-value="<?= $catet['value']?>" data-type="<?= $cates['field']?>"><?= $catet['display']?></a>
                                </li>
                            <?php endforeach;?>
                        <?php endif;?>
                    <?php endforeach;?>
                    <li class=""><a href="javascript:void(0);" id="link">高级筛选</a></li>
                </ul>
            </div>
            <div class="xiansyica" id="thediv" style="display:none">
                <?php foreach ($info['search_box'] as $cates): ?>
                    <?php if($cates['label'] != '排序') : ?>
                        <div class="activity-sxlist clearfix">
                            <div class="tabel"><?= $cates['label']?>：</div>
                            <ul class="clearfix">
                                <?php foreach ($cates['list'] as $key => $cate): ?>
                                    <?php if($cates['field'] == 'channel_id' && $cate['checked'] == 1) : ?>
                                        <input type="hidden" id="channel-id" value="<?= $cate['value']?>">
                                    <?php endif;?>
                                    <li class="<?= $cate['checked'] == 1 ? 'active-1' : ''?>"
                                        data-value="<?= $cate['value']?>"
                                        data-type="<?= $cates['field']?>">
                                        <a class="cate-list-li"
                                           data-value="<?= $cate['value']?>"
                                           data-type="<?= $cates['field']?>">
                                            <?= $cate['display']?></a></li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    <?php endif;?>
                <?php endforeach;?>
            </div>
        </div>
        <div class="bottom-grid clearfix">
            <div class="modal-paging"
                 data-pages="<?= $info['total_page']?>"
                 data-page="<?= $info['current_page']?>"
                 data-url="/video/refresh-video">
                <div class="text">
                    <p><?= empty($keyword)?'':'搜索“<span>'.$keyword.'</span>”，' ?>共找到约<span id="vcount"><?= $info['total_count']?></span>个视频</p>
                </div>
                <div class="vcontent">
                    <?php foreach ($info['list'] as $list): ?>
                        <?php
                        $firstChap = $list['chapters'][0];
                        ?>
                        <?php if($list['channel_id'] == '2') { ?>
                            <div class="accordion-divider clearfix">
                                <a class="img fl" style="display: block"
                                   href="<?= Url::to(['detail', 'video_id' => $firstChap['video_id'], 'chapter_id' => $firstChap['chapter_id'], 'source_id' => $firstChap['source_id']])?>">
                                    <img src="<?= $list['cover']?>">
                                    <span><?= $list['flag']?></span>
                                    <div class="zhezhao"></div>
                                </a>
                                <div class="text-span fl">
                                    <a href="<?= Url::to(['detail', 'video_id' => $firstChap['video_id'], 'chapter_id' => $firstChap['chapter_id'], 'source_id' => $firstChap['source_id']])?>">
                                        <h2><?= $list['video_name']?> <span> <?= $list['year']?></span></h2>
                                    </a>
                                    <p><span>主演:</span>
                                        <?= str_replace("演员:","",$list['artist']);?>
                                        <span> 导演: </span> <?= str_replace("导演:","",$list['director']);?>
                                    </p>
                                    <p><span>简介:</span><?= $list['intro'] ?></p>
                                    <ul class="clearfix">
                                        <?php foreach ($list['chapters'] as $key => $chap): ?>
                                            <?php if($key < 19) { ?>
                                                <li class="viitem"><a href="<?= Url::to(['detail', 'video_id' => $chap['video_id'], 'chapter_id' => $chap['chapter_id'], 'source_id' => $chap['source_id']])?>">
                                                        <?= $key+1 ?>
                                                    </a>
                                                </li>
                                            <?php } else { ?>
                                                <li class="viitem"><a href="<?= Url::to(['detail', 'video_id' => $list['chapters'][0]['video_id'], 'chapter_id' => $list['chapters'][0]['chapter_id'], 'source_id' => $list['chapters'][0]['source_id']])?>">
                                                        更多
                                                    </a>
                                                </li>
                                                <?php break; } ?>
                                        <?php endforeach;?>
                                    </ul>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="accordion-divider clearfix">
                                <a class="img fl" style="display: block"
                                   href="<?= Url::to(['detail', 'video_id' => $firstChap['video_id'], 'chapter_id' => $firstChap['chapter_id'], 'source_id' => $firstChap['source_id']])?>">
                                    <img src="<?= $list['cover']?>">
                                    <span><?= $list['flag']?></span>
                                    <div class="zhezhao"></div>
                                </a>
                                <div class="text-span fl">
                                    <a href="<?= Url::to(['detail', 'video_id' => $firstChap['video_id'], 'chapter_id' => $firstChap['chapter_id'], 'source_id' => $firstChap['source_id']])?>">
                                        <h2><?= $list['video_name']?> <span> <?= $list['year']?></span></h2>
                                    </a>
                                    <p><span>主演:</span>
                                        <?= str_replace("演员:","",$list['artist']);?>
                                        <span> 导演: </span> <?= str_replace("导演:","",$list['director']);?>
                                    </p>
                                    <p><span>简介:</span><?= $list['intro']?></p>
                                    <div class="bottom-grid-poa">
                                        <ul>
                                            <?php foreach ($list['chapters'] as $key => $chap): ?>
                                                <?php if($key < 3) { ?>
                                                    <li class="viitem"><a href="<?= Url::to(['detail', 'video_id' => $chap['video_id'], 'chapter_id' => $chap['chapter_id'], 'source_id' => $chap['source_id']])?>"
                                                                          title="<?= $chap['title'] ?>">
                                                            <?= $chap['title'] ?>
                                                        </a>
                                                    </li>
                                                <?php } else { ?>
                                                    <li class="viitem"><a href="<?= Url::to(['detail', 'video_id' => $list['chapters'][0]['video_id'], 'chapter_id' => $list['chapters'][0]['chapter_id'], 'source_id' => $list['chapters'][0]['source_id']])?>">
                                                            查看更多
                                                        </a>
                                                    </li>
                                                    <?php break; } ?>
                                            <?php endforeach;?>
                                            <!--                                    <li class=""><a href="###">2021-01-02：第4期下：欧阳超立论惊呆杨</a></li>-->
                                            <!--                                    <li><a href="###">2021-01-02：第4期下：欧阳超立论惊呆杨</a><span>新</span></li>-->
                                            <!--                                    <li><a href="###">2021-01-02：第4期下：欧阳超立论惊呆杨</a></li>-->
                                            <!--                                    <li><a href="###">查看更多</a></li>-->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php endforeach;?>
                </div>
            </div>
            <div class="main-gallery fl">
                <h2>搜索风云榜</h2>
                <div class="editor-review">
                    <ul class="clearfix">
                        <?php foreach ($hotword['tab'] as $key => $tab): ?>
                            <?php if ($key != 0) {?>
                                <li class="<?= $key == 1 ? 'active' : ''?>"><a href="###"><?= $tab['title']?></a></li>
                            <?php } ?>
                        <?php endforeach;?>
                    </ul>
                </div>
                <div class="announcement-sd">
                    <ul>
                        <?php foreach ($hotword['tab'] as $key => $tab): ?>
                            <?php if ($key != 0) {?>
                                <li style="display: <?= $key == 1 ? 'block' : 'none'?>;">
                                    <?php foreach ($tab['list'] as $key1 => $list): ?>
                                        <div class="div_qw"><span><?= $key1+1?></span>
                                            <p><?= $list['video_name']?></p>
                                            <span><img src="/images/NewVideo/result7.jpg"></span>
                                        </div>
                                        <a href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>"
                                            class="div_top clearfix <?= $key1 == 0 ? '' : 'w1600'?>" style="display: block">
                                            <div class="img_as fl">
                                                <img src="<?= $list['cover']?>">
                                                <span><?= $list['flag']?></span>
                                            </div>
                                            <div class="div_text fl">
                                                <span><?= $list['video_name']?></span>
                                                <p><?= $list['artist']?></p>
                                                <!--                                    <p>李斯、赵姬 </p>-->
                                            </div>
                                        </a>
                                    <?php endforeach;?>
                                </li>
                            <?php } ?>
                        <?php endforeach;?>
                    </ul>
                </div>
            </div>
        </div>
    </div>


<div class="spinner">
    <div class="spintitle"> Loading</div>
    <div class="rect1 ani"></div>
    <div class="rect2 ani"></div>
    <div class="rect3 ani"></div>
    <div class="rect4 ani"></div>
    <div class="rect5 ani"></div>
</div>
