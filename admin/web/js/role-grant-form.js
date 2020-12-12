jQuery(document).ready(function($) {

    var $permissions = $('#permissions');
    
    $permissions.jstree({
        'plugins': ["wholerow", "checkbox"],
        'core': {
            "themes" : {
                "responsive": false
            },
            data: $permissions.data('json')
        }
    });

    $('form').submit(function() {

        var permissions = [];
        $.each($permissions.jstree().get_selected(), function(key, id) {
            permissions.push(id);
        });

        if (permissions.length == 0) {
            event.preventDefault();
            alert("请至少选择一项权限");
            return false;
        }else {
            $(':hidden[name=permissions]').val(permissions.join(','));
        }

    });
});
