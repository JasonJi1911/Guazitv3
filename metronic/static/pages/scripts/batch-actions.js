$(function() {
    var $actionBtns = $('.batch-actions .btn').addClass('disabled');
    
    $('th:first-child>:checkbox,td:first-child>:checkbox').change(function() {
        if ($('td:first-child>:checked').length) {
            $actionBtns.removeClass('disabled');
        } else {
            $actionBtns.addClass('disabled');
        }
    });

    $actionBtns.click(function() {
        var $this = $(this);

        var ids = [];
        $.each($('td:first-child>:checked'), function(index, checkbox) {
            ids.push($(checkbox).val());
        });

        var data = {
            _csrf: $('[name="csrf-token"]').attr('content'),
              ids: ids,
        };
        
        $.post($this.attr('href'), data, function(response) {
            toastr.success(response ? "操作成功" : "操作失败");
            setTimeout(function() { location.reload(); }, 1000);
        });

        return false;
    });
});
