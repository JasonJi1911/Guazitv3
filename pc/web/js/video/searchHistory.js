//查找关键字
function findwords(){
    var searchwords = "";
    if(window.localStorage.hasOwnProperty("searchwords")){
        searchwords = window.localStorage.getItem("searchwords");
    }
    if(searchwords!=null && searchwords!=''){
        var uar = searchwords.split(",");
        var html = "";
        // var words = "";
        var l = 10;
        if(uar.length>l){
            for(var i=uar.length-1;i>uar.length-l-1;i--){
                if(typeof(uar[i]) != undefined && uar[i].trim().length>0){
                    // words = "\""+uar[i]+"\"";
                    html = html + "<a href='/video/search-result?keyword="+uar[i]+"' >"+uar[i]+"</a>";
                }
            }
        }else{
            for(var i=uar.length-1;i>=0;i--){
                if(typeof(uar[i]) != undefined && uar[i].trim().length>0){
                    // words = "\""+uar[i]+"\"";
                    html = html + "<a href='/video/search-result?keyword="+uar[i]+"'>"+uar[i]+"</a>";
                }
            }
        }
    }
    $("#searchHistory").html(html);
}

//点击关键字搜索
function searchwords(words){
    $("#keywords").val(words);
    naviwords(words);
    searchurl();
}

//存储关键字
function savewords(){
    var words = $("#keywords").val();
    if(words.trim()==""){
        $("#keywords").val($("#v_keywords0").val());//无关键字,搜索默认推荐关键字
        words = $("#v_keywords0").val();
    }
    naviwords(words);
    searchurl();
}

//清空搜索历史
function clearwords(){
    if(window.localStorage.hasOwnProperty("searchwords")){
        window.localStorage.removeItem("searchwords");
    }
    $("#searchHtitle").css("display","none");
    $("#searchHistory").html("");
}

//检验关键字去重
function naviwords(word){
    var searchwords = "";
    if(word.trim()!=""){
        if(window.localStorage.hasOwnProperty("searchwords")){
            searchwords = window.localStorage.getItem("searchwords");
        }
        if(searchwords.trim()!=""){
            var str = searchwords+","+word;
            var ar = noRepeat(str.split(","));
            if(ar.length>10){
                window.localStorage.setItem("searchwords",ar.slice(-10).toString());
            }else{
                window.localStorage.setItem("searchwords",ar.toString());
            }
        }else{
            window.localStorage.setItem("searchwords",word);
        }
    }
}

//搜索信息链接跳转
function searchurl() {
    var searchKeyword = $('#keywords').val();
    if(!searchKeyword) {
        window.location.href = '/video/search-result';
        return false;
    }
    // setSearchStore(searchKeyword);
    window.location.href = '/video/search-result?keyword=' + searchKeyword;
}

//数组去重
function noRepeat(arr) {
    for(var i = 0; i < arr.length-1; i++){
        for(var j = i+1; j < arr.length; j++){
            if(arr[i]===arr[j]){
                arr.splice(j,1);
                j--;
            }
        }
    }
    return arr;
}

//求片页关闭弹框
$(document).ready(function() {
    $('#closealt05').click(function() {
        $('#alt05').hide();
    });
});

//存用户
function saveuser(uid){
    setCookie("uid",uid,180);
}

//读用户
function finduser(){
    return getCookie("uid");
}
//删除
function removeuser(){
    setCookie("uid","",-1);
}

//设置有效期的cookie,exdays为负数时即为删除cookie
function setCookie(cname,cvalue,exdays){
    var d = new Date();
    d.setTime(d.getTime()+(exdays*24*60*60*1000));
    var expires = "expires="+d.toGMTString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}
//获取cookie
function getCookie(cname){
    var name = cname + "=";
    var ca = document.cookie.split(';');
    var str = "";
    for(var i=0; i<ca.length; i++){
        var c = ca[i].trim();
        if (c.indexOf(name)==0){
            str = c.substring(name.length,c.length);
        }
    }
    return str;
}

//右上角登录
function showlogin(user){
    if(user.avatar && user.avatar!="underfined" && typeof (user.avatar) != "undefined"){
        $("#user_headimg").attr("src",user.avatar);
    }
    if(user.nickname && user.nickname!="underfined" && typeof (user.nickname) != "undefined"){
        $("#user_name").html(user.nickname);
    }
    // $("#user_isvip").text();
    // $("#user_grade").text();
    // $(".user_score").text();
    // $("#user_allscore").text();

    $("#notloggedin").hide();
    $("#loggedin").show();
}

//手机验证
function isMobilePhone(mobile){
    var reg = /^[0-9]*$/;
    if (mobile =='' || !reg.test(mobile)) {
        return false;
    } else {
        return true;
    }
}

//邮箱验证
function isEmail(email){
    var reg = /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/;
    if (!reg.test(email)) {
        return false;
    } else {
        return true;
    }
}

//背景色处理
function ztBlack(){
    var bodycolor = $("body").attr("class");
    if(bodycolor.indexOf("ZT-black")>=0){
        $("[name='zt']").addClass("ZT-black");
    }else{
        $("[name='zt']").removeClass("ZT-black");
    }
}

//弹层隐藏
$(document).ready(function() {
    $("#pop-tip").click(function(){
        $("#pop-tip").hide();
    });
});
