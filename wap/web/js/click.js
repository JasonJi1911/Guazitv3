var clickEve = function (e) {
    var click = {};
    var screen_height = $(window).height(); //屏幕高度
    var screen_width = $(window).width(); //屏幕宽度
    var clock = 0; //动画锁
    //设置变量初始值
    var setting = {
        'turn_type': 'vertical',
        'font_size': localStorage.getItem('font-size') ? localStorage.getItem('font-size') : 20
    };
    //背景色
    var bg_color = '';
    var color = '#111111';
    if( $.cookie('daynight') == 'true'){
        $('.day_night').attr('data-daynight','true')
        $('#read_in').css({
            background:'url(/images/read_page_bg_7.png)'
        })
        $('#read-body').css({
            color:'#9c9fa4'
        })
    }else{
        if ($.cookie('bg_color')) {
            bg_color = $.cookie('bg_color');
            color  = $.cookie('color');
            $('#read_in').css({
                background:"url('"+bg_color+"')"
            })
            $('#read-body').css({
                color:color,
            })
        }else{
           
            $('#read_in').css({
                background:""
            })
            $('#read-body').css({
                color:color,
            })
        
        }
    }
    

    // 竖直移动
    var verMove = function (action) {
        var line_height = parseInt($('.read-body').css('font-size'));
        if (action == 'last') {
            //跳到上一章
            if ($(window).scrollTop() == 0) {
                // jumpChapter('last');
                return;
            }
            if (clock != 0) {
                return;
            }
            clock++;
            $("body,html").animate({scrollTop: $(window).scrollTop() - screen_height + line_height}, 350).promise().done(function () {
                clock--;
            });
        } else {
            //跳到下一章
            if (($(window).scrollTop() + screen_height) >= $('#content p:last').position().top + '1.2rem') {
                jumpChapter('next');
                return;
            }
            if (clock != 0) {
                return;
            }
            clock++;
            $("body,html").animate({scrollTop: $(window).scrollTop() + screen_height - line_height}, 350).promise().done(function () {
                clock--;
            });
        }
    }

    // 水平移动
    var horMove = function (action) {
        var read_section = $('#read-body');
        var read_width = read_section.width(); //阅读内容宽度

        if (action == 'last') {
            //需要移动的像素 已经偏移量+屏幕宽度+一个边界
            var move_left = parseInt(read_section.attr('data-left')) - (screen_width - read_width) / 2 - read_width;
            if (move_left < 0) {
                jumpChapter('last');
            }
        } else {
            if ($('#content p:last').position().left < screen_width) {
                jumpChapter('next');
            }
            var move_left = parseInt(read_section.attr('data-left')) + (screen_width - read_width) / 2 + read_width; //需要移动的像素 已经偏移量+屏幕宽度+一个边界
        }

        read_section.css("transform", "translateX(-"+move_left+"px)");

        read_section.attr('data-left', move_left); //修改已经移动过的距离
    }

    //跳转章节
    var jumpChapter = function (type) {
        if (type == 'last') {
            var chapter_id = $('.pre').attr('chapter_id');
        } else {
            var chapter_id = $('.next').attr('chapter_id');
        }
        if (chapter_id == 0) {
            alert('没有了');
            return;
        }
        window.location.href = '/book/read?chapter_id=' + chapter_id;
    }
    
    //切换字体
    var changeFontSize = function (type) {
        var font_size = parseInt($.trim($('.font-size').text()));
        if (type == 'small') {
            if (font_size < 17) {
                return;
            }
            font_size--;
        } else {
            if (font_size > 23) {
                return;
            }
            font_size++;
        }
        
        $('.font-size').text(font_size);
        $('#content').css({'font-size': font_size});
        setVal('font_size', font_size);
    }

    //设置初始化
    var initSetting = function () {
        $.each(setting, function(item, val) {
            var set_val = $.trim(localStorage.getItem(item));
            if (set_val != '') {
                setting[item] = set_val;
            }
        })

        //设置字体
        $('.font-size').text(setting.font_size);
        $('#content').css({'font-size': setting.font_size+'px'});
        //设置背景色
        $('.set-bjcolor li').removeClass('active');
        $('.set-bjcolor li div').each(function () {
            if ($(this).attr('color-type') == bg_color) {
                $(this).parent('li').addClass('active');
            }
        })
        //设置场景
        if (bg_color == '#383d42') { //夜间
            changeMode('sun');
        }
        //设置翻页
        // turnType(setting.turn_type);
    }
    
    //设置翻页类型
    // var turnType = function (type) {
    //     $('.lrturningul li div').removeClass('actiov');
    //     if (type == 'vertical') {
    //         $('.vertical').find('div').addClass('actiov');
    //         $('html body').css({'height': 'auto'});
    //         $('#read_in').css({'position': 'relative'});
    //         $('.read-main').css({'min-height': 'calc(100vh - 44px)', 'text-align': 'justify', 'overflow': 'hidden'})
    //     } else {
    //         $('.horizontal').find('div').addClass('actiov');
    //         $('#read_in').css({'position': 'fixed', 'top': 0, 'left': 0, 'width': '100%', 'height': '100%'});
    //         $('.read-main').css({'min-height': '100%', 'height': '100%', 'line-height': '1.8', 'text-align': 'justify', 'overflow': 'hidden'});
    //         $('.read-body').css({'min-height': 'inherit', 'height': '100%', 'columns': 'calc(100vw - 32px) 1', 'column-gap': '16px', 'overflow': 'visible', 'transition-duration': '0.5s'});
    //     }
    // }

    //修改设置变量
    var setVal = function (key, val) {
        localStorage.setItem(key, val);
    }

    //翻页
    var turnPage = function (e) {
        //显示隐藏
        if (!$('.readtop-box').hasClass('hide') && e != '') {
            if ($(e.target).parents('.set-area').is('.set-area')) {
                return;
            }
            $('#mask').addClass('hide');
            $('.readtop-box').addClass('hide');
            $('.readbottom-box').addClass('hide');
            return;
        }

        e = e || window.event;
        click.relative_x = e.clientX || e.clientX + document.body.scrollLeft; //相对点击横坐标
        click.relative_y = e.clientY || e.clientY + document.body.scrollTop; //相对点击纵坐标
        $('.set-box').addClass('hide');
        // if (setting.turn_type == 'horizontal') {
        //     if (click.relative_x < screen_width * 0.3) {
        //         horMove('last');
        //     } else if (click.relative_x > screen_width * 0.7) {
        //         horMove('next');
        //     } else {
        //         if ($('.readtop-box').hasClass('hide')) {
        //             $('#mask').removeClass('hide');
        //             $('.readtop-box').removeClass('hide');
        //             $('.readbottom-box').removeClass('hide');
        //         }
        //     }
        // } else {
            if (click.relative_y < screen_height * 0.3) {
                verMove('last');
            } else if (click.relative_y > screen_height * 0.7) {
                verMove('next');
            } else {
                if ($(e.target).attr("class") == 'advert-img') {
                    return false;
                }

                if ($('.readtop-box').hasClass('hide')) {
                    $('#mask').removeClass('hide');
                    $('.readtop-box').removeClass('hide');
                    $('.readbottom-box').removeClass('hide');
                }
            }
        // }
    }

    //修改场景
    var changeMode = function (type) {
        if (type == 'sun') {
            $.cookie('bg_color', '#383d42', {expires: 365});
            $('.sun').removeClass('hide');
            $('.moon').addClass('hide');
            $('.mode-text').text('日间');
        } else {
            $.cookie('bg_color', '#fec', {expires: 365});
            $('.sun').addClass('hide');
            $('.moon').removeClass('hide');
            $('.mode-text').text('夜间');
        }
    }

    //设置背景色
    var setBc = function () {
        $.each(setting, function(item, val) {
            var set_val = $.trim(localStorage.getItem(item));
            if (set_val != '') {
                setting[item] = set_val;
            }
        })
        $('#read_in').css({'background-color': setting.skin});
    }

    return {
        init: function () {
            initSetting();
        },
        turnPage: function (e) {
            turnPage(e);
        },
        changeFontSize: function (type) {
            changeFontSize(type);
        },
        changeMode: function (type) {
            changeMode(type);
        },
        // turnType: function (type) {
        //     turnType(type)
        // },
        horMov: function (type) {
            horMove(type);
        }
    }
}();
