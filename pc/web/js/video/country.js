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
        var req = new XMLHttpRequest();
        req.open('GET', document.location, false);
        req.send(null);
        var cf_ray = req.getResponseHeader('cf-Ray');//指定cf-Ray的值
        var citycode = '';
        if(cf_ray && cf_ray.length>3){
            citycode = cf_ray.substring(cf_ray.length-3);
        }
        // if(returnCitySN.cid!=""){
            //获取国家
            var ar = {};
            // ar['country_code'] = returnCitySN.cid;
            // ar['country_name'] = returnCitySN.cname;
            ar['citycode'] = citycode;
            // console.log(ar);
            $.get('/video/get-country', ar, function (res) {
                // console.log(res);
                if (res.errno == 0 && res.data) {
                    COUNTRYINFO = res.data;
                    countrylist = JSON.stringify(res.data);
                    window.localStorage.setItem("countrylist", countrylist);
                    setCookie("currentcountry",1,1);
                }
                showcountry();
            });
        // }else{
        //     showcountry();
        // }
    } else {//直接从缓存读取
        COUNTRYINFO = JSON.parse(countrylist)
        showcountry();
    }
});

function showcountry(){
    if(COUNTRYINFO['city_name'] && COUNTRYINFO['city_name'] != "" && COUNTRYINFO['city_name']!="undefined"){
        $("#head-city").text(COUNTRYINFO['city_name']);
        $("#head-city").show();
    }else if(COUNTRYINFO['city_code'] && COUNTRYINFO['city_code'] != "" && COUNTRYINFO['city_code']!="undefined"){
        $("#head-city").text(COUNTRYINFO['city_code']);
        $("#head-city").show();
    }
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