var ifClick = true;
var timer = null;
$('#get_verify_btn').on('click', function(){
    if(!(/^1\d{10}$/.test($('#user_phone').val()))){
        alert('手机号码格式不正确')
        return;
    }
    var mobile = $('#user_phone').val();
    $.get('/user/send-code', {mobile: mobile}, function(s){
        if (s.errno) {
            alert('系统繁忙,请稍后重试');
            return;
        }
    })

    if (ifClick) {
        ifClick = false;
        var codeTime = 60;
        clearInterval(timer);
        
        timer = setInterval(function(){
            if(codeTime > 1) {
                codeTime--;
                $('#get_verify_btn').html(toD(codeTime));
            }else{
                clearInterval(timer);
                $('#get_verify_btn').html('获取验证码');
                ifClick = true;
            }
        },1000);
    }
});
function toD(n){
    return n<10?'0'+n:n;
}
