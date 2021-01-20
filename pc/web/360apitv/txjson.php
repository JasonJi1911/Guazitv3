<?php  
	date_default_timezone_set("PRC");
	
//	define('Set_Cookie','tvfe_boss_uuid=f49dd564e2c1ffa1; pgv_pvid=7779910302; video_guid=b5be43c65e1a84a2; video_platform=2; pgv_info=ssid=s4743249318; RK=9AJkDfqSOh; ptcz=f7bcef91d53f1afbdcbb397357cd25e3cf3792718fb89c10bb3d57fcf1efee52; _qpsvr_localtk=1603543746451; pgv_pvi=899269632; pgv_si=s92007424; main_login=qq; vqq_access_token=1265D4B68C24D8D864DAE3E557E9AC0A; vqq_appid=101483052; vqq_openid=7EDAEC5C91500DD227DA1D4338F697A9; vqq_vuserid=1281189366; vqq_vusession=9Nysc-K87PKuyx8HcR5nVg..; vqq_refresh_token=770A59DD3B27B9E4E548B7B21D3C1845; login_time_init=2020-10-25 16:5:56; vqq_next_refresh_time=6583; vqq_login_time_init=1603613174; login_time_last=2020-10-25 16:6:13');//填入的腾讯Cookie，一个小时需要获取一次   可以写入文本 挂服务器 远程调用
	
	$Url = $_GET['url'];
	if(!$Url){
		echo Null;
	}
 	$ids = parse($Url);

	echo json_encode(proxy_http($ids));


	function proxy_http($ids){
		$ehost = !empty($ids["cid"]) ? "https://v.qq.com/x/cover/".$ids["cid"]."/".$ids["vid"].".html": "https://v.qq.com/x/page/".$ids["vid"].".html";
		$params["buid"] = "vinfoad";
		$vinfoparam["charge"] = 1;
		$vinfoparam["defaultfmt"] = "auto";
		$vinfoparam["otype"] = "ojson";
		$vinfoparam["guid"] = md5(getEncryptVer7());//设备ID，限速和检测多设备登录使用
		$vinfoparam["pid"] = md5(time());
		$vinfoparam["flowid"] = $vinfoparam["pid"]."_10901";//播放id 
		$vinfoparam["platform"] = 10901;//10303  10201
		$vinfoparam["sdtfrom"] = "v1010";//v5000  v1010
		$vinfoparam["defnpayver"] = 1;
		$vinfoparam["appVer"] = "3.5.57";
		$vinfoparam["host"] = "v.qq.com";
		$vinfoparam["refer"] = $ehost;
		$vinfoparam["ehost"] = $ehost;
		$vinfoparam["sphttps"] = 1;
		preg_match("#<ip>(.*)</ip>#",file_get_contents("https://vv.video.qq.com/checktime"),$val);
    	$ip = $val[1];
		$vinfoparam["tm"] = time();
		$vinfoparam["spwm"] = 4;//4为 m3u8
		$vinfoparam["unid"] = md5($vinfoparam["pid"]);
		$vinfoparam["vid"] = $ids["vid"];
		$vinfoparam["defn"] = "fhd";//标清;(270P) = sd ; 高清;(480P) = hd ; 超清;(720P) = shd ; 蓝光;(1080P) = fhd ;
		$vinfoparam["fhdswitch"] = 0;
		$vinfoparam["show1080p"] = 1;
		$vinfoparam["isHLS"] = 1;
		$vinfoparam["onlyGetinfo"] = true;
		$vinfoparam["dtype"] = 3;// 3为 m3u8
		$vinfoparam["sphls"] = 1;
		$vinfoparam["defsrc"] = 2;
		$ckey7 = index($vinfoparam["vid"],$vinfoparam["tm"],$vinfoparam["platform"],$vinfoparam["sdtfrom"],$vinfoparam["appVer"]);
		$vinfoparam["encryptVer"] = $ckey7["encryptVer"];
		$vinfoparam["cKey"] = $ckey7["ckey"];
		$vinfoparam["fp2p"] = 1;
		$params["vinfoparam"] = http_build_query($vinfoparam);
		
		$api = "https://vd.l.qq.com/proxyhttp?buid=onlyvinfo&vinfoparam=".urlencode(http_build_query($vinfoparam));
		$Set_Cookie=file_get_contents('http://getcookie.360apitv.com/cookie.txt');//列子  http://ip/cookie.txt
		$content = Cookie_curl($api,$Set_Cookie);
		//$content = Cookie_curl($api,Set_Cookie);
		
 		preg_match('#"vinfo":\"(.*)"}#',str_replace("\\","",$content),$body);
		
		$data = json_decode($body[1],true);	
        $vi = $data["vl"]["vi"][0];
        $ui = $vi["ul"]["ui"];
		$img = "http://puui.qpic.cn/vpic/0/".$vinfoparam["vid"].".png/0";
		$videoinfo["poster"]= $img;
		

	
		$m3u8 = $ui[2]["url"].$ui[3]["hls"]["pt"];
		$ch=$vi["ch"];
		$m3u8_shuju=$vi["ul"]["m3u8"];
		$m3u8_shuju = str_replace( 'ltsws.qq.com', 'omts.tc.qq.com',$m3u8);
		
		
		
		$videoinfo["url"] = $m3u8;
		$videoinfo["name"] = "jianghu";
		$videoinfo['player'] = 'dplayer';
        $videoinfo['code'] = 200;
        $videoinfo['metareferer'] = "origin";
        return $videoinfo;
	}

	function Cookie_curl($url,$cookie="")
	{	$Set_Cookie=file_get_contents('http://getcookie.360apitv.com/cookie.txt');
		$params["ua"] = "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.84 Safari/537.36";
		$params["cookie"] = $cookie;
		return curl($url,$params);
	}

	function parse($url)
    {
		$content = curl($url);
        preg_match('#id=(\w+)&vid=(\w+)["|&]#',$content,$id);
		$cid = empty($id[1])? 0 :$id[1];
		$vid = $id[2];
		$ids = array("vid"=>$vid,"cid"=>$cid);
		return $ids;
	}
	
	
	function curl($url,$params=array())
	{
      $ip = empty($params["ip"]) ? rand_ip() : $params["ip"]; 
      $header = array('X-FORWARDED-FOR:'.$ip,'CLIENT-IP:'.$ip);
      if(isset($params["httpheader"])){
        $header = array_merge($header,$params["httpheader"]);
      }
      $referer = empty($params["ref"]) ? $url : $params["ref"];
      $user_agent = empty($params["ua"]) ? $_SERVER['HTTP_USER_AGENT'] : $params["ua"] ;
      $ch = curl_init();                                                      //初始化 curl
      curl_setopt($ch, CURLOPT_URL, $url);                                    //要访问网页 URL 地址
      curl_setopt($ch, CURLOPT_HTTPHEADER, $header);                          //伪装来源 IP 地址
      curl_setopt($ch, CURLOPT_REFERER, $referer);                            //伪装网页来源 URL
      curl_setopt($ch, CURLOPT_USERAGENT,$user_agent);                        //模拟用户浏览器信息
      curl_setopt($ch, CURLOPT_NOBODY, false);                                //设定是否输出页面内容
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                         //返回字符串，而非直接输出到屏幕上
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, false);                        //连接超时时间，设置为 0，则无限等待
      curl_setopt($ch, CURLOPT_TIMEOUT, 3600);                                //数据传输的最大允许时间超时,设为一小时
      curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);                       //HTTP验证方法
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                        //不检查 SSL 证书来源
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);                        //不检查 证书中 SSL 加密算法是否存在
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);                         //跟踪爬取重定向页面
      curl_setopt($ch, CURLOPT_AUTOREFERER, true);                            //当Location:重定向时，自动设置header中的Referer:信息
      curl_setopt($ch, CURLOPT_ENCODING, '');                                 //解决网页乱码问题
      curl_setopt($ch, CURLOPT_HEADER, empty($params["header"])?false:true);  //不返回 header 部分
      if(!empty($params["fields"])){
        curl_setopt($ch, CURLOPT_POST, true);                                  //设置为 POST 
        curl_setopt($ch, CURLOPT_POSTFIELDS,$params["fields"]);                //提交数据
      }
      if(!empty($params["cookie"])){
        curl_setopt($ch, CURLOPT_COOKIE, $params["cookie"]);                  //从字符串传参来提交cookies
      }
      if(!empty($params["proxy"])){
        curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC);                  //代理认证模式
        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);                  //使用http代理模式
        curl_setopt($ch, CURLOPT_PROXY, $params["proxy"]);                    //代理服务器地址 host:post的格式
        if(!empty($params["proxy_userpwd"])){
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, $params["proxy_userpwd"]); //http代理认证帐号，username:password的格式
        }
      }
      $data = curl_exec($ch);                                                 //运行 curl，请求网页并返回结果
      curl_close($ch);                                                        //关闭 curl
      return $data;
	}
	function rand_ip(){
		$ip_long = array(
			array('607649792', '608174079'), //36.56.0.0-36.63.255.255
			array('1038614528', '1039007743'), //61.232.0.0-61.237.255.255
			array('1783627776', '1784676351'), //106.80.0.0-106.95.255.255
			array('2035023872', '2035154943'), //121.76.0.0-121.77.255.255
			array('2078801920', '2079064063'), //123.232.0.0-123.235.255.255
			array('-1950089216', '-1948778497'), //139.196.0.0-139.215.255.255
			array('-1425539072', '-1425014785'), //171.8.0.0-171.15.255.255
			array('-1236271104', '-1235419137'), //182.80.0.0-182.92.255.255
			array('-770113536', '-768606209'), //210.25.0.0-210.47.255.255
			array('-569376768', '-564133889') //222.16.0.0-222.95.255.255
		);
		$rand_key = mt_rand(0, 9);
		$ip = long2ip(mt_rand($ip_long[$rand_key][0], $ip_long[$rand_key][1]));
		return $ip;
	}
	
	
	

	function index($vid,$tm,$platform,$sdtfrom,$appVer){
		$ckey = getCkey7($vid,$tm,$platform);
		$encryptVer = getEncryptVer7();
		$data = array(
			'encryptVer' => $encryptVer,
			'appVer'     => $appVer,
			'ckey'       => $ckey,
		);
		return $data;
	}
	function getCkey7($vid,$tm,$platform){
		return md5( getCkey70ToKey(getEncryptVer7())."{$vid}{$tm}*#06#{$platform}" );
	}
	function getEncryptVer7(){
		$g = date('w',time());
		$f = 0 == $g ? 7 : $g;
		return "7.{$f}";
	}
	function getCkey70ToKey($v){
		$t = substr($v,2);
		switch($t){
			case "1": return "06fc1464";
			case "2": return "4244ce1b";
			case "3": return "77de31c5";
			case "4": return "e0149fa2";
			case "5": return "60394ced";
			case "6": return "2da639f0";
			case "7": return "c2f0cf9f";
			default:  return "err";
		}
	}

?> 