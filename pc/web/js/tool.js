function slideClick(){
   	if(slide_item.openType == 0){
   		//无操作
   	}else if(slide_item.openType == 1){
   		//打开地址
   		if(slide_item.url)
   			window.open(slide_item.url);
   	}else if(slide_item.openType == 2){
   		//打开地址
   		if(slide_item.module == 1){
   			//详情页
       		window.open('/book/'+slide_item.bid);
   		}else if(slide_item.module == 2){
   			//阅读页
       		window.open('/book/'+slide_item.bid+'/0/');
   		}
   	}
}

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
	
	// px转化成rem
    (function (doc, win) {

        var docEl = doc.documentElement,
        resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
        recalc = function () {
            var clientWidth = docEl.clientWidth;
            if (!clientWidth) return;
            if(clientWidth>=750){
            docEl.style.fontSize = '20px';
        }else{
            docEl.style.fontSize = 20 * (clientWidth / 375) + 'px';
        }
    };
    if (!doc.addEventListener) return;
    win.addEventListener(resizeEvt, recalc, false);
    doc.addEventListener('DOMContentLoaded', recalc, false);
    })(document, window);
    
$(function(){
	/*登录状态*/
	var login_box = $('#login_box');
	if(login_box){
		//  $.ajax({
		//       url: '/login/login_state',
		//       type:"get",
		//       success: function (res) {
		//     	  login_box.html(res);

	    // 	    // 显示修改密码下拉
	    // 	    $('#show_edit_menu').hover(function(){
	    // 	        $('#show_edit_menu_d').show();
	    // 	    },function(){
	    // 	        $('#show_edit_menu_d').hide();
	    // 	    });
		//       }
		//  });
	}

    //推荐位鼠标经过样式
    $('.recommend .entry').not('.no_activity').find('li').hover(function(){
    	
        $(this).addClass('on');
        $(this).siblings().removeClass('on');
    });
	
})