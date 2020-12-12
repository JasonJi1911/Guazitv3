//把对象调整到中心位置
;(function($){
    $.fn.setmiddle = function() {
        var dl = $(document).scrollLeft(),
            dt = $(document).scrollTop(),
            ww = $(window).width(),
            wh = $(window).height(),
            ow = $(this).width(),
            oh = $(this).height(),
            left = (ww - ow) / 2 + dl,
            top = (wh - oh) / 2 + dt;
        $(this).css({left:Math.max(left, dl) + "px",top:Math.max(top, dt) + "px"}); 
        return this;
    }
})(jQuery);

function getQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return r[2];
    return '';
}
var id =  getQueryString('id');
//提示信息
;(function($){
    $.tips = function(options) {
        var settings = {
            content: "",
            icon: "success",
            time: 1500,
            close: false,
            zindex: 2999
        };
        if (options) {
            $.extend(settings, options);
        }
        if (settings.close) {
            $(".tips").hide();
            return;
        }
        if (!$(".tips")[0]) {
            $("body").append('<div class="tips"><i></i><span></span></div>');
            $(".tips").css("z-index", parseInt(settings.zindex));
        }
        $(".tips span").html(settings.content);
        $(".tips").attr("class", "tips tips-" + settings.icon);
        $(".tips").css("z-index", parseInt($(".tips").css("z-index"))+1).setmiddle().show();
         
        if (settings.time > 0) {
            setTimeout(function() {
                $(".tips").fadeOut()
            }, settings.time);
        }
    }
})(jQuery);

//设置cookie
var setCookie = function(cname, cvalue, exdays) {
    var day = new Date();
    day.setTime(day.getTime() + (exdays*24*60*60*1000));
    document.cookie = cname + "=" + encodeURI(cvalue) + "; " + "expires=" + day.toUTCString() +"; path=/";
};

//获取cookie
var getCookie = function(cname) {
    var name = cname + "=";
    var obj = document.cookie.split(';');
    for (var i = 0; i < obj.length; i++) {
        var c = obj[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) != -1) return c.substring(name.length, c.length);
    }
    return "";
};

//清除cookie 
var clearCookie = function(cname) { 
    setCookie(cname, "", -1); 
};

//检查cookie 
var checkCookie = function(cname) {
    var value = getCookie(cname);
    if (value != "") {
        return true;
    }
    else {
        return false;
    }
};

var bookshelfInit = function() {
    //cookie
    if (checkCookie("hs13_bk123") == false) {
        setCookie("hs13_bk123", '{"count":"0","book":[]}', "365");
    }
    //书架
    $(".link-bookshelf").click(function() {
        if (($(".bookshelf-mask").length > 0) && ($(".bookshelf-panel").length > 0) )  {
            $(".bookshelf-mask").show();
            $(".bookshelf-panel").show(); 
        }
        else {
            var html = "";
            var list = "";
            html += "<div class=\"bookshelf-mask\"></div>";
            html += "<div class=\"bookshelf-panel\">";
            html += "<div class=\"bookshelf-head\"><h4>我的书架(0本)</h4><a class=\"close\" target=\"_self\">关闭</a></div>";
            html += "<div class=\"bookshelf-list\">";
            html += "<ul class=\"clearfix\"></ul>";
            html += "</div>";
            html += "</div>";
            $("body").append(html);
            //检查是否有cookie
            if (checkCookie("hs13_bk123") == true) {
                var data = JSON.parse(decodeURI(getCookie("hs13_bk123")));
            }
            else {
                var data = {"count":"0","book":[]};
            }
            if (data.count > 0) {
                var pic = "";
                var title = "";
                var status = "";
                var chaptername = "";
                //取得每个小说id
                for (var i = 0; i <= data.count - 1; i++) {
                    //同步获取对应id信息
                    $.ajax({
                        type: "get",
                        url: "/ajax.php?act=xxx&id=" + data.book[i].book_id,
                        async: false,
                        success: function(data,status) {
                            $res = JSON.parse(data);
                            for (var key in $res){
                                pic = $res[xx].yy;
                                title = $res[xx].yy;
                                status = $res[xx].yy;
                                chaptername = $res[xx].yy;
                            }
                        }
                    });
                    if (status == "serial") {
                        status_txt = "连载中";
                    }
                    else {
                        status_txt = "已完本";
                    }
                    list += "<li>";
                    list += "<a class=\"pic\" href=\"#\"><img src=\""+pic+"\" alt=\""+title+"\"><i class=\""+status+"\">"+status_txt+"</i></a>";
                    list += "<p class=\"tit\"><a href=\"#\">"+title+"</a></p>";
                    list += "<p class=\"update\"><a href=\"#\">更新至："+chaptername+"</a></p>";
                    list += "<p class=\"read\"><a href=\"#\">继续阅读</a></p>";
                    list += "<i class=\"del\"></i>";
                    list += "</li>";
                    $(".bookshelf-list").append(list);
                }
            }
        }
    }); 

    $("body").on("click",'.close' ,function() {
        $(".bookshelf-mask").hide();
        $(".bookshelf-panel").hide();
    }); 

    $("body").on("click",'.del', function() {
        if(confirm("确定从书架中移除？")) {
            $(this).parent().slideUp(300, function(){
                $(this).remove();
            });
        }
    });

    //防止重复点击
    var flag = true;
    //放入书架
    $(".add-bookshelf").on("click", function(){
        if($(this).find('a').attr('data-type') == 1){
            $.tips({content: '已加入书架'});
            return;
        }
        if (checkCookie("hs13_bk123") == false) {
            var data = JSON.parse(decodeURI(getCookie("hs13_bk123")));
        }
        else {
            var data = {"count":"0","book":[]};
        }
        var len = data.book.length;
        if (flag) {
            flag = false;
            var id = $(this).attr('data-id');
            var num = 0;
            var str = "";
            if ($(this).hasClass("yes")) {
                //从书架移除
                removeBook();
            }
            else {
                addBook();
                
            }
            setTimeout(function(){
                flag = true;
            },1000);
        }
        else {
            alert("请勿频繁操作");
        }
    });
};

function addBook(){
    $.ajax({
        url:'/user/add-book?id='+id,
        type:'post',
        success:function( data ){
            if( data.code == 0 ){
                $.tips({content:"已放入书架", icon:"success"});
                //放入书架
                if (len > 0) {
                    for (var i = 0; i <= len - 1; i++) {
                        str += '{"book_id":"' + data.book[i].book_id + '"}';
                        str += ',';
                    }
                    str += '{"book_id":"' + id + '"}';
                }
                else {
                   str += '{"book_id":"' + id + '"}'; 
                }
                num = len + 1;
                val = '{"count":' + num +',"book":[' + str + ']}';
                
                $(this).addClass("yes");
                $(this).html($(this).html().replace(/放入书架/,"已放入书架"));
            }else{
                $.tips({content: data.error});
            }
        }
    })
};

function removeBook(){
    $.ajax({
        url:'/user/remove-book?id='+ id,
        type:'post',
        success: function( data ){
            if( data.code == 0 ){
                $(this).html($(this).html().replace(/已放入书架/,"放入书架"));
                $.tips({content:"已从书架移除", icon:"success"});
            }else{
                $.tips({content: data.error});
            }
        }
    })
}

var chapterInit = function(){
    $(".left-btns li").click(function() {
        var index = $(this).index();
        $(this).addClass("on").siblings("li").removeClass("on");
        if (index < 3) {
            $(".show-panel").eq(index).addClass("on").siblings(".show-panel").removeClass("on");
        }
        else {
            $(".show-panel").removeClass("on");
        }
    });
    $(".hide-panel").click(function() {
        $(".left-btns li").removeClass("on");
        $(".show-panel").removeClass("on");
    });
    $(".hide-panel").click(function() {
        $(".left-btns li").removeClass("on");
        $(".show-panel").removeClass("on");
    });
    $(".chapter-wrap .porn .index").click(function() {
        $(".left-btns li.btn-chapter").addClass("on").siblings("li").removeClass("on");
        $(".chapter-panel").addClass("on").siblings(".show-panel").removeClass("on");
    });
    $(".set-skin dd span").click(function() {
        $(this).addClass("cur").siblings("span").removeClass("cur");
        var value = $(this).attr("data-value");
        switch (value) {
            case "0":
                $("body").removeClass().addClass("chapter-skin0");
                break;
            case "1":
                $("body").removeClass().addClass("chapter-skin1");
                break;
            case "2":
                $("body").removeClass().addClass("chapter-skin2");
                break;
        }
    });
    $(".set-font-family dd span").click(function() {
        $(this).addClass("cur").siblings("span").removeClass("cur");
        var value = $(this).attr("data-value");
        switch (value) {
            case "0":
                $(".chapter-wrap").removeClass("font-family0 font-family1 font-family2").addClass("font-family0");
                break;
            case "1":
                $(".chapter-wrap").removeClass("font-family0 font-family1 font-family2").addClass("font-family1");
                break;
            case "2":
                $(".chapter-wrap").removeClass("font-family0 font-family1 font-family2").addClass("font-family2");
                break;
        }
    });
    $(".set-font-size dd .prev").click(function() {
        var size = parseInt($(".set-font-size dd .size").text());
        if (size <= 12) {
            size = 12;
        }
        else {
            size = size-1;
        }
        $(".set-font-size dd .size").text(size);
        $(".chapter-wrap").css("font-size",size);

    });
    $(".set-font-size dd .next").click(function() {
        var size = parseInt($(".set-font-size dd .size").text());
        if (size >= 36) {
            size = 36;
        }
        else {
            size = size+1;
        }
        $(".set-font-size dd .size").text(size);
        $(".chapter-wrap").css("font-size",size);
    });
    $(".set-width dd .prev").click(function() {
        var size = parseInt($(".set-width dd .size").text());
        if (size <= 760) {
            size = 760;
        }
        else {
            size = size-100
        }
        $(".set-width dd .size").text(size);
        $(".chapter-container").removeClass("w760 w860 w960 w1060").addClass("w"+size);

    });
    $(".set-width dd .next").click(function() {
        var size = parseInt($(".set-width dd .size").text());
        if (size >= 1060) {
            size = 1060;
        }
        else {
            size = size+100
        }
        $(".set-width dd .size").text(size);
        $(".chapter-container").removeClass("w760 w860 w960 w1060").addClass("w"+size);
    });
    $(".set-btns .btn-save").click(function() {
        var a,b,c,d,e;
        $(".set-skin dd span").each(function(){
            if ($(this).hasClass("cur")) {
                a = $(this).attr("data-value");
            }
        });
        $(".set-font-family dd span").each(function(){
            if ($(this).hasClass("cur")) {
                b = $(this).attr("data-value");
            }
        });
        c = $(".set-font-size dd .size").text();
        d = $(".set-width dd .size").text();
        e = '{"skin":' + a +',"family":' + b +',"size":' + c +',"width":' + d +'}';
        clearCookie("hs13_set123");
        setCookie("hs13_set123", e, "365");
        $(".left-btns li").removeClass("on");
        $(".show-panel").removeClass("on");
    });
    $(".set-btns .btn-cancel").click(function() {
        $(".left-btns li").removeClass("on");
        $(".show-panel").removeClass("on");
    });
    if (checkCookie("hs13_set123") == true) {
        var data = JSON.parse(decodeURI(getCookie("hs13_set123")));
        $("body").removeClass().addClass("chapter-skin"+data.skin);
        $(".chapter-container").removeClass("w760 w860 w960 w1060").addClass("w"+data.width);
        $(".chapter-wrap").css("font-size",data.size);
        $(".chapter-wrap").removeClass("font-family0 font-family1 font-family2").addClass("font-family"+data.family);
        $(".set-skin dd span").each(function(){
            if ($(this).attr("data-value") == data.skin) {
                a = $(this).addClass("cur").siblings("span").removeClass("cur");
            }
        });
        $(".set-font-family dd span").each(function(){
            if ($(this).attr("data-value") == data.family) {
                a = $(this).addClass("cur").siblings("span").removeClass("cur");
            }
        });
        $(".set-font-size dd .size").text(data.size);
        $(".set-width dd .size").text(data.width);
    }
    $(window).scroll(function () {
        if ($(".left-bar,.right-bar").length > 0) {
            var st = $(window).scrollTop();
            var ct = $(".chapter-wrap .main").offset().top;
            var cb = $(".chapter-wrap .main").offset().bottom;
            var ch = $(".chapter-wrap .main").height();
            if (st > ct && st < ct + ch) {
                $(".left-bar").css({position:"fixed", top:0});
            }
            else {
                $(".left-bar").css({position:"absolute", top:ct});
            }
            $(".right-bar").css({position:"fixed", bottom:"20px"});
        }
    });
}

$(function(){
    //首页切换
    $(".new-book ol li").click(function() {
        var index = $(this).index();
        $(this).addClass("on").siblings("li").removeClass("on");
        $(".new-book ul").eq(index).show().siblings("ul").hide();
    });
	//小说页
	$(".book-info .intro .more").click(function() {
		$(this).toggleClass("show");
    	$(".book-info .intro").toggleClass("show");
	});
    $(".go-review").click(function() {
        $('body,html').animate({
            scrollTop: $(".review").offset().top
        }, 300);
        return false;
    });
	$(".j-textarea").on("focus", function() {
		if ($(this).val() == "说点什么吧，您的评论是对本书最大的支持！") {
			$(this).val("")
		}
	}).on("blur", function() {
		if ($.trim($(this).val()) == "") {
			$(this).val("说点什么吧，您的评论是对本书最大的支持！")
		}
	}).on("keydown", function(){  
        var len = $(".j-textarea").val().length;
        if (len >= 200) {
            var num = $(".j-textarea").val().substr(0,200);;
            $(".j-textarea").val(num);;
        }
        else {
            $(".j-count").text(200-len-1);
        }
		$(".form-msg").text("");
    });
    $(".j-send").click(function() {
    	var txt = $(".j-textarea").val();
    	var len = $(".j-textarea").val().length;
    	if (txt == "说点什么吧，您的评论是对本书最大的支持！" || len == 0) {
    		$(".form-msg").text("评论内容不能为空");
    		return false;
    	}
    	else {
    		alert("您的评论已提交，审核过后您的评论会出现在这里！");
    	}
    });
    var $review = $(".review-list ul");
    if ($review.children("li").length > 5) {
    	$review.children("li").slice(5).css("display","none");
    	$(".review .more").click(function() {
    		$(this).css("display","none");
    		$review.children("li").slice(5).css("display","block");
    	});
    }
    $(".guess ol li").click(function() {
        var index = $(this).index();
        $(this).addClass("on").siblings("li").removeClass("on");
        $(".guess ul").eq(index).show().siblings("ul").hide();
    });
    //搜索输入字符串合法性验证
    $("#search-btn").click(function(){
        var str = $("#q").val();
        var ret = /[^\w\u4e00-\u9fa5]/;
        if(ret.test(str)){
           alert("搜索内容不合法");
           return false;
        }else{
           return ture;
        }
    });
    bookshelfInit();
});

//function vip1(book_id,chapter_id){
//    $.ajax({
//        type: "get",
//        url: "/ajax?act=vip&book_id="+book_id+"&chapter_id="+chapter_id,
//        async: false,
//        success: function(data,status) {
//            var res = JSON.parse(data);
//            window.open(res.url);
//        }
//    });
//} 

function vip(book_id,chapter_id){
    window.open("http://www.hs13.cn/book/"+book_id+"/v"+chapter_id+".html");
}
function mulu(book_id,type_id){
    window.open("http://www.hs13.cn/book/"+book_id+"/m"+type_id+".html");
}