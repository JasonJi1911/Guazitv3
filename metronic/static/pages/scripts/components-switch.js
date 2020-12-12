var ComponentsSwitch = function() {

    var handle = function() {
        $('.make-switch').on('switchChange.bootstrapSwitch', function(event, state) {
            var $this = $(this);
            $this.parent().parent().next(':hidden').val(state ? $this.data('on-value') : $this.data('off-value'));
        });
    };

    return {
        init: function() {
            handle();
        }
    };

}();

jQuery(document).ready(function() {
    ComponentsSwitch.init();
});
