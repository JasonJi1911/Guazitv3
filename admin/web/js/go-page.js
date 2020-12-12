//替换指定传入参数的值,name为参数,val为替换值
function UpdateUrlParam(name, val) {
    var thisURL = this.location.href;
    // 如果 url中包含这个参数 则修改
    if (thisURL.indexOf(name+'=') > 0) {
        var v = getUrlParam(name);
        if (v != null) {
            // 是否包含参数
            thisURL = thisURL.replace(name + '=' + v, name + '=' + val);

        }
        else {
            thisURL = thisURL.replace(name + '=', name + '=' + val);
        }

    } else {
        // 不包含这个参数 则添加
        if (thisURL.indexOf("?") > 0) {
            thisURL = thisURL + "&" + name + "=" + val;
        }
        else {
            thisURL = thisURL + "?" + name + "=" + val;
        }
    }
    location.href = thisURL;
};

//获取url
function getUrlParam(name) {
    var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if(r!=null)return  unescape(r[2]); return null;
}

// Enter键盘事件
$("#form-control").keydown(function(e){
    var e = e || event,
        keycode = e.which || e.keyCode;
    var _this = $(this);
    if (keycode==13) {
        UpdateUrlParam("page", _this.val())
    }
});

//点击事件
$('#go-page').click(function () {
    var value = $('#form-control').val();
    UpdateUrlParam("page", value)
});

//显示与隐藏
$(function () {
    if ($('.pagination').length > 0) {
        $('#go-page').show();
    }else {
        $('#go-page').hide();
    }
});
