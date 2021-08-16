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

//回车搜索
$('#keywords').keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
        savewords();
    }
});

//详情
function XQ(videoId){
    $("#alt03"+videoId).show();
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