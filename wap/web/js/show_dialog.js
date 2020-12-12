var showDailog = function() {
    return {
        init: function () {
            
        },
        
        swalInfo: function(msg, time){
            time = time || 600;
            swal({
                title: "",
                text: msg,
                timer: time,
                showConfirmButton: false
            });
        },

        swalChose: function(msg, callback) {
            swal({
                    title: "",
                    text: msg,
                    showCancelButton: true,
                    confirmButtonColor: "#00c98d",
                    confirmButtonText: "确定",
                    cancelButtonText: '取消',
                    closeOnConfirm: false
                },
                callback
            );
        }
    }
}();
