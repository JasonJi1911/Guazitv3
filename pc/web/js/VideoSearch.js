
//搜索信息
$('.search-box-out').on('click', function() {
    searchInfo()
});

//回车搜索
$('#keywords').keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
        searchInfo()
    }
});

//搜索信息
function searchInfo() {
    var searchKeyword = $('#keywords').val();
    if(!searchKeyword) {
        window.location.href = '/video/search-result';
        return false;
    }
    //写入缓存
    setSearchStore(searchKeyword);
    window.location.href = '/video/search-result?keyword=' + searchKeyword;
}

//点击搜索历史记录进行搜索
$('.search-histoty-list').on('click', '.search-history', function() {
    window.location.href = '/video/search-result?keyword=' + $(this).attr('data-keyword');
});

//清楚搜索信息
$('.history-delete').click(function() {
    localStorage.removeItem('pcNovelKeywords');
    searchDisplay();
});

//历史搜索信息展示与隐藏
function searchDisplay()
{
    //搜索历史
    keywords = JSON.parse(localStorage.getItem('pcNovelKeywords'));
    var html = '';
    if(keywords != null) {
        keywords = noRepeat(keywords);
    }

    //遍历历史搜索
    $.each(keywords, function(i, v) {
        html = html + "<li><a class='search-history' data-keyword='"+v+"'>" + v + "</a></li>";
    });

    if(keywords == null) {
        $('.video-history-search').hide();
    }else {
        $('.video-history-search').show();
    }

    $('.search-histoty-list').html(html);
}

searchDisplay();

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

//将搜索历史写入缓存
function setSearchStore(word){
    //搜索历史写入local
    if (keywords == null) {
        keywords = [word];
    } else {

        var item = $.inArray(word, keywords);
        if (item > 0) {  //如果已有
            keywords.splice(item, 1);
        } else {
            if (keywords.length > 4) {
                keywords.pop();
            }
        }
        keywords.unshift(word);
    }
    localStorage.setItem('pcNovelKeywords', JSON.stringify(keywords));
}