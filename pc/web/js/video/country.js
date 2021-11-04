//根据ip获取国家
COUNTRYINFO = {};
$(document).ready(function() {
    var countrylist = "";
    //获取country_code
    var currentcountry = getCookie("currentcountry");
    if(currentcountry == 1 && window.localStorage.hasOwnProperty("countrylist")) {
        countrylist = window.localStorage.getItem("countrylist");
    }
    //缓存为空
    if (!countrylist || typeof (countrylist) == "undefined" || countrylist == 0 || countrylist == "undefined") {
        // console.log("returnCitySN="+JSON.stringify(returnCitySN));
        if(returnCitySN.cid!=""){
            //获取国家
            var ar = {};
            ar['country_code'] = returnCitySN.cid;
            ar['country_name'] = returnCitySN.cname;
            $.get('/video/get-country', ar, function (res) {
                if (res.errno == 0 && res.data) {
                    COUNTRYINFO = res.data;
                    countrylist = JSON.stringify(res.data);
                    window.localStorage.setItem("countrylist", countrylist);
                    setCookie("currentcountry",1,1);
                }
                showcountry();
            });
        }else{
            showcountry();
        }
    } else {//直接从缓存读取
        COUNTRYINFO = JSON.parse(countrylist)
        showcountry();
    }
});

function showcountry(){
    // console.log(JSON.stringify(COUNTRYINFO));
    if(COUNTRYINFO['country_name'] != "" && COUNTRYINFO['country_name']!=0 && COUNTRYINFO['country_name']!="undefined"){
        $("#head-city").text(COUNTRYINFO['country_name']);
        $("#v_countryname").html(COUNTRYINFO['country_name']);
        $("#v_countryimg").attr("src","/images/newindex/"+COUNTRYINFO['imgname']);
    }else{
        COUNTRYINFO['country_name'] = "全球";
        COUNTRYINFO['imgname'] = "GLgq.png";
        COUNTRYINFO['country_code'] = "GL";
        $("#head-city").text("全球");
        $("#v_countryname").html("全球");
        $("#v_countryimg").attr("src","/images/newindex/GLgq.png");
    }
    $("#head-city").show();
    $("#v_countryname").parent().show();
}

//设置有效期的cookie,exdays为负数时即为删除cookie
function setCookie(cname,cvalue,exdays){
    var d = new Date();
    d.setTime(d.getTime()+(exdays*24*60*60*1000));
    var expires = "expires="+d.toGMTString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}
//获取cookie
function getCookie(cname){
    var name = cname + "=";
    var ca = document.cookie.split(';');
    var str = "";
    for(var i=0; i<ca.length; i++){
        var c = ca[i].trim();
        if (c.indexOf(name)==0){
            str = c.substring(name.length,c.length);
        }
    }
    return str;
}