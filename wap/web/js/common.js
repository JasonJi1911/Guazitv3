$(function() {

    var progress = false; // 是否正在请求中
    // 下拉加载更多
    $('[data-pages]').bind('load-more', function() {
        var $this = $(this);
        var pages = $this.data('pages') || 1;
        var url   = $this.data('url') || location.href;
        var page  = $this.data('page') || 1;

        // console.log(url);
        
        if (page < pages && !progress) {
            progress = true;
            $('#loading').show();
            $.get(url, {page: ++page}, function(html) {
                progress = false;
                $('#loading').hide();
                if (html) {
                    $this.append($(html).find('[data-pages]').html()).data('page', page);
                }
            });
        } else if (page == pages) {
            $('.search-result-notice').html('没有更多内容了~')
        }
    });
    
    $(window).scroll(function () {
        if (($(window).scrollTop()+10) >= $(document).height() - $(window).height()) {
            $('[data-pages]').trigger('load-more');
        }
    });

    new function () {
        function change() {
            document.documentElement.style.fontSize = 100 * document.body.clientWidth / 750 + 'px';
        }
       
        change();
        window.addEventListener('resize', change, false);
    }
});

