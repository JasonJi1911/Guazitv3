$(function() {

    var progress = false; // 是否正在请求中
    var isFlag = true;

    $(window).scroll(function () {
        if (($(window).scrollTop()+188) >= $(document).height() - $(window).height()) {
            if(isFlag) {
                    var pages = $('#loading-page').attr('data-pages') || 1;
                    var url   = $('#loading-page').attr('data-url') || location.href;
                    var page  = $('#loading-page').attr('data-page') || 1;

                    if (page < pages && !progress) {
                        progress = true;
                        page++;
                        $('#loading-page').attr('data-page', page);

                        $.get(url, {page: page, token: $('#token').val()}, function(html) {
                            /*progress = false;
                            if (html) {
                                $('#loading-page').append(html);
                            }*/
                        });
                    } else if (page == pages) {
                        $('#loading').hide();
                        $('#no-more').show();
                        progress = true;
                    }
                isFlag = false;
            }
        }else {
            isFlag = true;
        }
    });
});

