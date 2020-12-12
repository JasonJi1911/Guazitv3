var ComponentsSelect2 = function() {

    var handle = function() {
        // Set the "bootstrap" theme as the default theme for all Select2
        // widgets.
        //
        // @see https://github.com/select2/select2/issues/2927
        $.fn.select2.defaults.set("theme", "bootstrap");

        $(".select2, .select2-multiple").each(function(index, element) {
            var $this = $(element);

            var config = {};
            if ($this.attr('placeholder')) {
                config.placeholder = $this.attr('placeholder');
                config.allowClear = true;
            }

            if ($this.data('url')) {
                config.ajax = {
                    url: $this.data('url'),
                    cache: false,
                    data: function (params) {
                        var query = {
                            q: params.term
                        };
                        return query;
                    },
                    processResults: function (data) {
                        console.log(data);
                        return {
                            results: data
                        };
                    }
                }
            }

            $this.select2(config);
        });
    };

    return {
        init: function() {
            handle();
        }
    };

}();

jQuery(document).ready(function() {
    ComponentsSelect2.init();
});
