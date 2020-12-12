/**
 * Created by wzb on 2018/8/2.
 */
$(function () {

    $('.float_wrap .inner li').on('click',function(){
        $('.float_wrap .inner li a').removeClass('active');
        $(this).find('a').addClass('active');
        $('.layer_box').hide();
        var index = $(this).index();
        if( index == 0 ){
            $('.catalog').fadeIn();
        }else if( index == 1 ){
            $('.set_up').fadeIn();
        }else if( index == 2 ){
            $('.phone_read').fadeIn();
        }else if( index == 3 ){
            //加入书架
            // alert('加入书架')
            // if (that.uid == 0) {
                showMsg('请先登录');
            //     return;
            // }
        }
    });

    $('.theme li').on('click',function(){
        $('.theme li').removeClass('active');
        $(this).addClass('active');
        $('#vue-box').attr('class', $(this).find('span').attr('class')+'_box');
        localStorage.setItem(
            'theme', $(this).find('span').attr('class')+'_box'
        )
    });
    $('.font li').on('click',function(){
        $('.font li a').removeClass('active');
        $(this).find('a').addClass('active');
        $('.entry').attr('class','entry');

        $('.entry').addClass($(this).attr('data-font'));
        localStorage.setItem(
            'font',$(this).attr('data-font')
        )
    });


    var size = parseInt(localStorage.getItem('size'))?  parseInt(localStorage.getItem('size')):16;
    $('.size li').eq(1).find('span').text(size);
    $('.content .entry').attr({'style':'font-size:'+size+'px'});


    var font = localStorage.getItem('font')? localStorage.getItem('font') : 'content_yh';
    $('.font li').each(function(){
        if($(this).attr('data-font') == font){
            $(this).find('a').addClass('active');
            $('.content .entry').addClass(font);
        }
    });
   
    var theme = localStorage.getItem('theme') ? localStorage.getItem('theme') : 'white_box';
    $('.theme li').each(function(){
       
        if($(this).find('span').attr('class')+'_box' == theme){
            $(this).addClass('active');
            $('#vue-box').attr({'class': theme});
            // $('.content .entry').addClass(theme);
        }
    })


    $('.size li').on('click',function(){
        if($(this).index() == 2){
            if(size >=40){
                return;
            }
            size +=1;
            $('.size li').eq(1).find('span').text(size);
        }else if($(this).index() == 0){
            if(size <= 12){
                return;
            }
            size -=1;
            $('.size li').eq(1).find('span').text(size);
        }
        $('.entry').attr({'style':'font-size:'+size+'px'});
        localStorage.setItem(
            'size', size
        )
    });

    $('.close').on('click',function(){
        $('.float_wrap .inner li a').removeClass('active');
        $('.layer_box').hide();
    });

    $('.page_box li').eq(1).on('click',function(){
        $('.float_wrap inner li').eq(0).addClass('active');
        $('.catalog').fadeIn();
    });
    //搜索框回车
	$('#keyword').bind('keypress', function (event) {
	    if (event.keyCode == "13") {
	    	search();
	    }
    });
    
    $('#reset').on('click',function(){
        $('.theme li').removeClass('active');
        $('.theme li').eq(0).addClass('active');
        $('#vue-box').attr({'class': 'white_box'});
        localStorage.setItem(
            'theme', 'white_box'
        )

        $('.font li a').removeClass('active');
        $('.font li').eq(0).find('a').addClass('active');
        localStorage.setItem(
            'font','content_yh'
        )
        $('.content .entry').addClass('content_yh');
        $('.size li').eq(1).find('span').text(16);
        localStorage.setItem(
            'size', 16
        )
        $('.entry').attr({'style':16});
    });

    // 我的书架页面显示/隐藏删除按钮
    $('#user_books_box li').hover(function(){
        $(this).find('.delete').show();
    },function(){
        $(this).find('.delete').hide();
    });

    // 显示修改密码下拉
    $('#show_edit_menu').hover(function(){
        $('#show_edit_menu_d').show();
    },function(){
        $('#show_edit_menu_d').hide();
    });
    
    //记住密码

	// var remember_pass = $.cookie('remember_pass');
    // if (remember_pass){
    // 	remember_pass = JSON.parse(remember_pass);
    // 	$('#phone_num').val(remember_pass.phoneNum);
    // 	$('#phone_pass').val(remember_pass.pass);
    // 	$("#phone_remember_pass").prop("checked",true);
    // }
});



function httpRequest(url, data, successFunc, errorFunc, type_header) {
    var data = data || "{}";
    var successFunc = successFunc || null;
    var errorFunc = errorFunc || null;
    if (!url || url === '#') {
        return false;
    }

    var type_header = type_header;
    if (type_header == 1) {
        type_header = 'application/json';
    } else {
        type_header = 'application/x-www-form-urlencoded';
    }

    // 显示加载
    is_loading = showLoading()
    if(!is_loading && url == loading_url){
    	return false;//如果在加载 并且url 是上一个一样的
    }
    loading_url = url;
    var header_cont = {
        'content-type': type_header
    };

    $.ajax({
        url: url,
        data: data,
        type:"get",
        header: header_cont,
        crossDomain: true,
        xhrFields: {
            withCredentials: true
        },
        success: function (res) {
            hideLoading()
            if (res.status == 'error') {
                var apimsg = res.msg;
                if (apimsg == '用户余额不足' || apimsg == '您已经添加过了') {
                    return true;
                }
                if (apimsg == '没有登录' || apimsg == '该用户不存在或已被禁用') {
                    apimsg = '您还未登陆，请先登录'
                }

                if(apimsg == '您还未登陆，请先登录'){
                    //登录
                }
                layer.msg(apimsg, {icon: 5});
            } else {
                var data = res.data;
                try { successFunc(data); } catch (e) { }
            }
        },
        error: function (err) {
	          hideLoading();
	    	 var res = confirm('网络错误，请重试');
	         if (res) {
	           httpRequest(url, data, successFunc, errorFunc, type_header);
	         } else{
	           console.log('用户点击取消')
	         }
        },//请求失败
    })
}




var loading = false;
var loading_url = '';
function hideLoading(){
	loading = false;
	layer.closeAll('loading');
}
function showLoading(){
	layer.load();
	if(loading) return false;
	loading = true;
	return true;
}

function showMsg(content){
    layer.msg(content, {icon: 6});
}

function go_search(){
    if($('#keyword').val() == ''){
        $('#keyword').val($('#default_search').val());
    }
    search();
}
function search(){
	window.open('/s/'+$('#keyword').val()+'/');
}
//Ajax 请求 json post
function AjaxJson(url,data,successFunc,errorFunc){
    var data = data || "{}";
    successFunc = successFunc || null;
    errorFunc = errorFunc || null;
    if(!url || url==='#')
        return false;

    $.ajax({
        type: 'POST',
        url: url,
        data:data,
        dataType: 'json',
        success: function(data) {
            try{ successFunc(data); }catch(e){}
        },
        error: function(xhr, type) {
            try{ errorFunc(data); }catch(e){}
            console.log("页面动态加载不成功，请与管理员联系");
        },
    })
    //阻止冒泡
    return false;
}

// ajax删除数据
var delete_url = '/My/ajax_del_book_shelf.html';
function delete_fun(id){
    if(delete_url.length < 3){
        layer.msg('链接地址不对，无法删除', {icon: 5});
    }
    AjaxJson(delete_url,{id:id},function(res){
        if(res.status == 1){
            layer.msg(res.msg, {icon: 6});
            $("#delete_id_"+id).remove();
        }else{
            layer.msg(res.msg, {icon: 5});
        }
    })
}

var is_login_lay_type = 0;
function show_login_type(type){
    if(type == 1){
        is_login_lay_type = 1;
        $('.show_ver_login').show();
        $('.show_pass_login').hide();
    }else{
        is_login_lay_type = 0;
        $('.show_ver_login').hide();
        $('.show_pass_login').show();
    }
    $('#show_login_lay').show();
}

// 显示/隐藏 忘记密码
function show_forget_pass($type){
    if($type == 1){
        $('#show_login_lay').show();
        $('#show_forget_pass').hide();
    }else{
        $('#show_login_lay').hide();
        $('#show_login_dx_lay').hide();
        $('#show_forget_pass').show();
    }
}

// 显示/隐藏 注册
function show_reg_lay($type){
    if($type == 1){
        $('#show_login_lay').show();
        $('#show_reg_lay').hide();
    }else{
        $('#show_login_lay').hide();
        $('#show_login_dx_lay').hide();
        $('#show_reg_lay').show();
    }
}

var phoneNam = /^1\d{10}$/;
var is_reg_on = false;
//手机登陆
function phone_login(){
    if(is_reg_on){
        return false;
    }
    is_reg_on = true;
    var phoneVal = $('#phone_num').val();
    if(!phoneNam.test(phoneVal)){
        is_reg_on = false;
        layer.msg('请输入正确的手机号码');
        return false;
    }

    var is_remember_pass = false;
    if(is_login_lay_type == 1){
        // 短信登陆
        var cy_yzm = $('#phone_ver_dx').val();
        if(!cy_yzm){
            is_reg_on = false;
            layer.msg('请填写验证码');
            return false;
        }
        var login_url = "/Login/phone_ver_login";
        var login_data = {phoneNum:phoneVal,verifyCode:cy_yzm};
    }else{
        // 密码登陆
        var pass = $('#phone_pass').val();
        if(pass.length < 1){
            layer.msg('请输入密码');
            is_reg_on = false;
            return false;
        }
        if(pass.length < 6 || pass.length > 20){
            layer.msg('密码长度范围在6~20位字符');
            is_reg_on = false;
            return false;
        }
        var login_url = "/Login/phone_login";
        var login_data = {phoneNum:phoneVal,pass:pass};
        var is_remember_pass = $("#phone_remember_pass").is(":checked");
    }

    var callback = window.location.href;
    AjaxJson(login_url,login_data,function(data){
        is_reg_on = false;
        if(data.status == 1){
            layer.msg(data.msg);
            if(is_remember_pass){
            	//记住密码
	    	    $.cookie('remember_pass', JSON.stringify(login_data), { expires: 30 });
            }else{
            	$.cookie('remember_pass',null);
            }
            setTimeout(function(){
                window.location.reload();
            },1000)
        }else{
            layer.msg(data.msg);
        }
    });
}

// 手机号码注册
function phone_reg(){
    if(is_reg_on){
        return false;
    }
    is_reg_on = true;
    var phoneVal = $('#phone_reg').val();
    if(!phoneNam.test(phoneVal)){
        is_reg_on = false;
        layer.msg('请输入正确的手机号码');
        return false;
    }
    var cy_yzm = $('#phone_reg_ver').val();
    if(!cy_yzm){
        is_reg_on = false;
        layer.msg('请填写验证码');
        return false;
    }
    /*var nick = $('#phone_reg_nick').val();
    if(!nick){
        is_reg_on = false;
        layer.msg('请填写呢称');
        return false;
    }*/
    var pass = $('#phone_reg_pass').val();
    /*var pass_t = $('#phone_reg_pass_two').val();*/
    if(pass.length < 1){
        layer.msg('请输入密码');
        is_reg_on = false;
        return false;
    }
    if(pass.length < 6 || pass.length > 20){
        layer.msg('密码长度范围在6~20位字符');
        is_reg_on = false;
        return false;
    }
    /*if(nick.length > 14){
    	layer.msg('昵称长度不能超过14个字符');
    	is_reg_on = false;
    	return false;
    }*/
    /*if(pass !== pass_t){
        layer.msg('两次密码不一致');
        is_reg_on = false;
        return false;
    }*/

    var callback = window.location.href;
    AjaxJson("/Login/phone_reg",{phoneNum:phoneVal,verifyCode:cy_yzm,pass:pass},function(data){
        is_reg_on = false;
        if(data.status == 'success'){
            window.location.href=data.data;
        }else{
            layer.msg(data.msg);
        }
    });
}

// 获取注册手机验证码
var cy_yzm_num = 0;
function get_vercode(obj,type){
    if(cy_yzm_num > 0){
        return false;
    }
    var id_box = $(obj).find('.cy_yzm_btn');

    var phoneVal =  $(obj).find('.phone_num').val();
    if(!phoneNam.test(phoneVal)){
        layer.msg('请输入正确的手机号码');
        return false;
    }
    AjaxJson("/Login/phone_verifyCode",{phoneNum:phoneVal,type:type},function(data){
        if(data.status == 1){
            cy_yzm_num = 60;
            id_box.css({'background':'#ccc'}).html('已发送'+cy_yzm_num);
            var settime_num = setInterval(function(){
                cy_yzm_num--;
                if(parseInt(cy_yzm_num) > 0){
                    id_box.css({'background':'#ccc'}).html('已发送'+cy_yzm_num);
                }else{
                    id_box.css({'background':'#4890da'}).html('获取验证码');
                    clearInterval(settime_num);
                }
            },1000);
        }else{
            layer.msg(data.msg);
        }
    });
}

// 忘记密码
function phone_pass_rest(){
    if(is_reg_on){
        return false;
    }
    is_reg_on = true;
    var phoneVal = $('#phone_rest_num').val();
    if(!phoneNam.test(phoneVal)){
        is_reg_on = false;
        layer.msg('请输入正确的手机号码');
        return false;
    }
    var pass = $('#phone_rest_pass').val();
    /*var pass_t = $('#phone_rest_passt').val();*/
    if(pass.length < 1){
        layer.msg('请输入密码');
        is_reg_on = false;
        return false;
    }
    if(pass.length < 6 || pass.length > 20){
        layer.msg('密码长度范围在6~20位字符');
        is_reg_on = false;
        return false;
    }
    /*if(pass !== pass_t){
        layer.msg('两次密码不一致');
        is_reg_on = false;
        return false;
    }*/
    var cy_yzm = $('#phone_rest_ver').val();
    if(!cy_yzm){
        layer.msg('请输入验证码');
        is_reg_on = false;
        return false;
    }
    var callback = window.location.href;
    AjaxJson("/Login/phone_rest_pass",{phoneNum:phoneVal,verifyCode:cy_yzm,pass:pass},function(data){
        is_reg_on = false;
        if(data.status == 1){
            layer.msg(data.msg);
            setTimeout(function(){
                window.location.reload();
            },1000)
        }else{
            layer.msg(data.msg);
        }
    });
}


// 修改密码
function edit_pass(){
    if(is_reg_on){
        return false;
    }
    is_reg_on = true;
    var pass_old = $('#edit_pass_old').val();
    var pass = $('#edit_pass_new').val();
    /*var pass_t = $('#edit_pass_newt').val();*/
    if(pass_old.length < 1){
        layer.msg('请输入原始密码');
        is_reg_on = false;
        return false;
    }
    if(pass.length < 1){
        layer.msg('请输入密码');
        is_reg_on = false;
        return false;
    }
    if(pass.length < 6 || pass.length > 20){
        layer.msg('密码长度范围在6~20位字符');
        is_reg_on = false;
        return false;
    }
    /*if(pass !== pass_t){
        layer.msg('两次密码不一致');
        is_reg_on = false;
        return false;
    }*/
    if(pass == pass_old){
        layer.msg('原始密码不能和新密码密码一致');
        is_reg_on = false;
        return false;
    }

    var callback = window.location.href;
    AjaxJson("/Login/edit_pass",{pass_old:pass_old,pass:pass},function(data){
        is_reg_on = false;
        if(data.status == 1){
            layer.msg(data.msg);
            setTimeout(function(){
                window.location.reload();
            },1000)
        }else{
            layer.msg(data.msg);
        }
    });
}


// 绑定手机号码
function bind_phone(obj){
    if(is_reg_on){
        return false;
    }
    is_reg_on = true;
    var phoneVal = $(obj).find('.phone_num').val();

    if(!phoneNam.test(phoneVal)){
        is_reg_on = false;
        layer.msg('请输入正确的手机号码');
        return false;
    }
    var cy_yzm = $(obj).find('.phone_bd_num_vel').val();
    if(!cy_yzm){
        layer.msg('请输入验证码');
        is_reg_on = false;
        return false;
    }
    var pass = $(obj).find('.phone_bd_pass').val();
    if(pass.length < 1){
        layer.msg('请输入密码');
        is_reg_on = false;
        return false;
    }
    if(pass.length < 6 || pass.length > 20){
        layer.msg('密码长度范围在6~20位字符');
        is_reg_on = false;
        return false;
    }
    var callback = window.location.href;
    AjaxJson("/Login/bindPhone",{phoneNum:phoneVal,verifyCode:cy_yzm,pass:pass},function(data){
        is_reg_on = false;
        if(data.status == 1){
            layer.msg(data.msg);
            setTimeout(function(){
                window.location.reload();
            },1000)
        }else{
            layer.msg(data.msg);
        }
    });
}


// 意见反馈
var feeback_opinion = '产品建议';
function tab_feedback(obj,opinion){
    feeback_opinion = opinion;
    $(obj).parents('ul').find('a').removeClass('active');
    $(obj).addClass('active');
}
// 提交意见反馈
var is_feed_on = false;
function add_feedback(opinion,bid,sort){
    if(is_feed_on){
        return false;
    }
    is_feed_on = true;
    if(opinion){
        feeback_opinion = opinion;
    }
    var feedback_other = $('#feedback_other').val();
    var feedback_concat =  $('#feedback_concat').val(); 
    if(feedback_other.length < 1){
        layer.msg("内容不能为空");
        is_feed_on = false;
    	return false;
    }
    if(!feedback_concat){
        layer.msg("联系方式不能为空");
        is_feed_on = false;
    	return false;
    }

    if(feedback_concat.length > 11 || feedback_concat.length < 5){
        layer.msg("联系方式格式错误，请输入5-11个数字");
        is_feed_on = false;
    	return false;
    }
    feedback_concat =  '[' +feedback_concat+']'; 
    
    AjaxJson("/My/record_feedback",{opinion:feeback_opinion,other:feedback_other+feedback_concat,bid:bid,sort:sort},function(data){
        is_feed_on = false;
        if(data.status == 1){
            layer.msg(data.msg);
            $('#feedback_other').val('');
            $('#feedback_concat').val('');
            $('#feedback_lay').hide();
        }else{
            layer.msg(data.msg);
        }
    });
}

// 修改呢称
var is_nick_on = false;
function edit_nick(){
    if(is_nick_on){
        return false;
    }
    is_nick_on = true;
    var nick = $('#edit_user_nick').val();
    if(nick.length < 1){
        layer.msg("呢称不能为空");
    	is_nick_on = false;
    	return false;
    }

    if(nick.length > 14){
    	layer.msg('昵称长度不能超过14个字符');
    	is_nick_on = false;
    	return false;
    }
    AjaxJson("/My/edit_nick",{nick:nick},function(data){
        is_nick_on = false;
        if(data.status == 1){
            layer.msg(data.msg);
            $('#edit_user_nick').val();
            setTimeout(function(){
                window.location.reload();
            },1000)
            
        }else{
            layer.msg(data.msg);
        }
    });
}

