var ajaxPost = function () {
    var x = {};
        x.entity = {};
        x.canSubmit = true;

    var validateForm = function(_form){
        x.canSubmit = true;

        _form.find('input, select').each(function(idx, els){
            var _this = $(this);
            if (_this.attr('data-required') && !_this.val().length){
                showDailog.swalInfo(_this.attr('placeholder'));

                x.canSubmit = false;
                return x.canSubmit;
            }
        });

        if (!x.canSubmit){
            return false;
        }
        return true;
    };

    var postRequest = function(_form, _callback_url){
        if (validateForm(_form) != true) {
            return false;
        }
        $.post(_form.attr('action'), _form.serialize(), function(s){
            if (s.errno){
                showDailog.swalInfo(s.error);
                return false;
            }

            window.location.href = _callback_url;
        }, 'json');
    };
    
    return {
        formSubmit: function (obj) {
            var _form = $(obj).parents('form');
            var _callback_url = _form.find('#callback-url').val();
            return postRequest(_form, _callback_url);
        }
    };
}();
