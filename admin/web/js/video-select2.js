$(function() {

    var placeholder = '请输入作品名称搜索作品';

    function formatSeries(series) {
        if (series.loading) return series.name;

        var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__avatar'><img src='" + series.cover + "' /></div>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" + series.title + "</div>";

        if (series.description) {
            markup += "<div class='select2-result-repository__description'>" + series.description + "</div>";
        }

        markup += "</div></div>";

        return markup;
    }

    function formatSeriesSelection(series) {
        if (series.title) return series.title;
        return series.text;
    }

    // 获取get参数
    function getQueryVariable(variable)
    {
        var query = window.location.search.substring(1);
        var vars = query.split("&");
        for (var i=0;i<vars.length;i++) {
            var pair = vars[i].split("=");
            if(pair[0] == variable){return pair[1];}
        }
        return '';
    }

    var $seriesSelect2 = $('.select2.series').select2({
        placeholder: placeholder,
        allowClear: true,
        ajax: {
            url: '/video/search',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                var query = {
                    name: params.term,
                    channel_id:getQueryVariable('channel_id')
                };
                return query;
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: false
        },
        escapeMarkup: function(markup) {
            return markup;
        },
        minimumInputLength: 0,
        templateResult: formatSeries,
        templateSelection: formatSeriesSelection
    });
});
