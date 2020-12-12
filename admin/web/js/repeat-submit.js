$(document).on({
    beforeValidate: function (event, messages, deferreds) { // 提交时会走验证方法，将按钮失效
        $('#form-submit').attr('disabled', true);
    },
    afterValidate: function (event, messages, errorAttributes) { // 提交后，根据是否有错误信息，来将按钮恢复
        if (errorAttributes.length > 0) {
            $('.has-error')[0].scrollIntoView(); // 错误情况下定位到错误栏目
            $('#form-submit').attr('disabled', false);
        }
    }
});
