
<?php include('data.php'); ?>
<?php include('user.php')?>
<?php include('daohang.php')?>



<?php
error_reporting(0);
include('config.php');
$token = $_COOKIE["admin_token"];
$session = md5($conf['admin_user'].md5($conf['admin_pwd']));
if($session !== $token){
echo '<script language="javascript">window.location.href=\'404.php\';</script>';
  }
?>
<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link href="https://cdn.bootcss.com/bootstrap-colorpicker/3.0.0-beta.1/css/bootstrap-colorpicker.min.css" rel="stylesheet">
<script src="//cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap-colorpicker/3.0.0-beta.1/js/bootstrap-colorpicker.min.js"></script>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>瓜子 - 播放器后台管理</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="https://www.layuicdn.com/layui/css/layui.css" />
	<script type="text/javascript" src="https://www.layuicdn.com/layui/layui.js" type="text/javascript" charset="utf-8"></script>
	<script src="./js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="./js/config.js" type="text/javascript" charset="utf-8"></script>

	<style>
		.layui-elem-field {
			border-color: #00bcd4;
		}

		.width {
			width: 120px !important;
			text-align: center;
		}

		.long {
			width: 300px !important;
			text-align: center;
		}

		.smt {
			width: 75px !important;
			text-align: center;
		}

		.sm {
			width: 50px !important;
			text-align: center;
		}

		.layui-textarea {
			min-height: 60px;
			height: 38px;
		}

		#configSave {
			margin-bottom: 0;
			background-color: #00BCD4;
			color: #ffffff;
			height: 39px;
			border-radius: 2px 2px 0 0;
			width: 80px;
			border-width: 1px;
			border-style: solid;
			border-color: #00BCD4;
		}

		.layui-form-pane .layui-form-label {
			padding: 8px 5px;
		}
	</style>
</head>

<body>
	<form class="layui-form layui-form-pane" name="configform" id="configform">
		<div class="layui-tab" overflow>
			<ul class="layui-tab-title">
			    <li class="layui-this">基本设置</li>
				<li class="">广告设置</li>
					<li class="">解析设置</li>
				<li class="">弹幕管理</li>
			</ul>
			

			
		
			
			
			<div class="layui-tab-content">
				<div class="layui-tab-item layui-show" name="基本设置">
					<div class="layui-form-item">
						<label class="layui-form-label">弹幕开关</label>
						<div class="layui-input-block">
							<input type="checkbox" name="yzm[danmuon]" lay-skin="switch" lay-filter="switchTest" lay-text="ON|OFF" <?php $t = $yzm['danmuon'];
																																	if ($t == "on") {
																																		echo "checked";
																																	} ?>>
							<div class="layui-unselect layui-form-switch" lay-skin="_switch"><em>Off</em><i></i></div>
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">主题颜色</label>
						<div class="layui-input-inline">
							<input type="text" name="yzm[color]" value="<?php echo $yzm['color'] ?>" size="30" class="layui-input upload-input" placeholder="颜色代码">
						</div>
						<div class="layui-form-mid layui-word-aux">颜色代码 例如：#00a1d6</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">LOGO</label>
						<div class="layui-input-inline long">
							<input type="text" name="yzm[logo]" value="<?php echo $yzm['logo'] ?>" size="30" class="layui-input upload-input" placeholder="图片地址">
						</div>
						<div class="layui-form-mid layui-word-aux">图片地址 例如：/guazitv6/logo.png</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">试看时间</label>
						<div class="layui-input-inline">
							<input type="text" name="yzm[trytime]" value="<?php echo $yzm['trytime'] ?>" size="30" class="layui-input upload-input" placeholder="单位/分">
						</div>
						<div class="layui-form-mid layui-word-aux">试看时间只在固定会员组有效，设置会员组请进入广告选项进行设置</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">加载页等待时间</label>
						<div class="layui-input-inline">
							<input type="text" name="yzm[waittime]" value="<?php echo $yzm['waittime'] ?>" size="30" class="layui-input upload-input" placeholder="单位/秒">
						</div>
						<div class="layui-form-mid layui-word-aux">loading页等待时间</div>
					</div>
				
					<div class="layui-form-item">
						<label class="layui-form-label">弹幕发送间隔</label>
						<div class="layui-input-inline">
							<input type="text" name="yzm[sendtime]" value="<?php echo $yzm['sendtime'] ?>" size="30" class="layui-input upload-input" placeholder="单位/秒">
						</div>
						<div class="layui-form-mid layui-word-aux">指的是发送时间只能在设置时间后才能重新发送新弹幕</div>
					</div>
		<div class="layui-form-item">
						<label class="layui-form-label">弹幕API接口</label>
						<div class="layui-input-inline">
							<input type="text" name="yzm[api]" value="<?php echo $yzm['api'] ?>" size="30" class="layui-input upload-input" placeholder="dmku/">
						</div>
						<div class="layui-form-mid layui-word-aux">弹幕接口，如/dmku/，建议不改</div>
					</div>
        	<div class="layui-form-item">
						<label class="layui-form-label">哔哩哔哩弹幕</label>
						<div class="layui-input-inline">
							<input type="text" name="yzm[av]" value="<?php echo $yzm['av']?>" size="30" class="layui-input upload-input" placeholder="请输入aid值 为空则不启用">
						</div>
						<div class="layui-form-mid layui-word-aux">（获取方法：随便点击一个哔哩哔哩视频链接查看源代码搜索"aid="，获取aid值即可</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">弹幕礼仪链接</label>
						<div class="layui-input-inline long">
							<input type="text" name="yzm[dmrule]" value="<?php echo $yzm['dmrule'] ?>" size="30" class="layui-input upload-input" placeholder="链接地址">
						</div>
						<div class="layui-form-mid layui-word-aux">弹幕框右边按钮链接</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">弹幕关键字禁用</label>
						<div class="layui-input-inline long">
							<input type="text" name="yzm[pbgjz]" value="<?php echo $yzm['pbgjz'] ?>" size="30" class="layui-input upload-input" placeholder="输入关键字以" ,"隔开">
						</div>
						<div class="layui-form-mid layui-word-aux">输入关键字以","隔开</div>
					</div>
					<div class="layui-form-item center">
						<div class="layui-input-block">
							<input name="edit" type="hidden" value="1" />
							<button class="layui-btn" type="button" onclick="text()">保 存</button>
							<button class="layui-btn layui-btn-warm" type="reset" onclick="reset1()">还 原</button>
						</div>
					</div>
				</div>
				<div class="layui-tab-item" name="广告设置">
					<div class="layui-form-item">
						<label class="layui-form-label">广告开关</label>
						<div class="layui-input-block">
							<input type="checkbox" name="yzm[ads][state]" lay-skin="switch" lay-filter="switchTest" lay-text="ON|OFF" <?php $t = $yzm['ads']['state'];
																																		if ($t == "on") {
																																			echo "checked";
																																		} ?>>
							<div class="layui-unselect layui-form-switch" lay-skin="_switch"><em>Off</em><i></i></div>
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">广告类型</label>
						<div class="layui-input-inline">
							<input type="radio" name="yzm[ads][set][state]" value="1" title="视频" <?php $t = $yzm['ads']['set']['state'];
																									if ($t == "1") {
																										echo "checked";
																									} ?>>
							<input type="radio" name="yzm[ads][set][state]" value="2" title="图片" <?php $t = $yzm['ads']['set']['state'];
																									if ($t == "2") {
																										echo "checked";
																									} ?>>
						</div>
					</div>

					<div class="layui-form-item">
						<label class="layui-form-label">广告范围</label>
						<div class="layui-input-inline">
							<select name="yzm[ads][set][group]" lay-verify="required">
								<option value="null" <?php $t = $yzm['ads']['set']['group'];
														if ($t == "null") {
															echo "selected";
														} ?>>无限制</option>
								<option value="2" <?php $t = $yzm['ads']['set']['group'];
													if ($t == "2") {
														echo "selected";
													} ?>>游客</option>
								<option value="3" <?php $t = $yzm['ads']['set']['group'];
													if ($t == "3") {
														echo "selected";
													} ?>>注册会员</option>
								<option value="4" <?php $t = $yzm['ads']['set']['group'];
													if ($t == "4") {
														echo "selected";
													} ?>>充值会员</option>
							</select>
						</div>
						<div class="layui-form-mid layui-word-aux">当前会员及下级会员有效</div>
					</div>



					<div class="layui-form-item">
						<label class="layui-form-label">图片广告时间</label>
						<div class="layui-input-inline">
							<input type="text" name="yzm[ads][set][pic][time]" value="<?php echo $yzm['ads']['set']['pic']['time'] ?>" size="30" class="layui-input upload-input" placeholder="单位/秒">
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">图片广告内容</label>
						<div class="layui-input-inline long">
							<input type="text" name="yzm[ads][set][pic][img]" value="<?php echo $yzm['ads']['set']['pic']['img'] ?>" size="30" class="layui-input upload-input" placeholder="图片地址">
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">图片广告链接</label>
						<div class="layui-input-inline long">
							<input type="text" name="yzm[ads][set][pic][link]" value="<?php echo $yzm['ads']['set']['pic']['link'] ?>" size="30" class="layui-input upload-input" placeholder="点击链接地址">
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">视频广告内容</label>
						<div class="layui-input-inline long">
							<input type="text" name="yzm[ads][set][vod][url]" value="<?php echo $yzm['ads']['set']['vod']['url'] ?>" size="30" class="layui-input upload-input" placeholder="视频地址">
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">视频广告链接</label>
						<div class="layui-input-inline long">
							<input type="text" name="yzm[ads][set][vod][link]" value="<?php echo $yzm['ads']['set']['vod']['link'] ?>" size="30" class="layui-input upload-input" placeholder="点击链接地址">
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">暂停广告开关</label>
						<div class="layui-input-block">
							<input type="checkbox" name="yzm[ads][pause][state]" lay-skin="switch" lay-filter="switchTest" lay-text="ON|OFF" <?php $t = $yzm['ads']['pause']['state'];
																																				if ($t == "on") {
																																					echo "checked";
																																				} ?>>
							<div class="layui-unselect layui-form-switch" lay-skin="_switch"><em>Off</em><i></i></div>
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">暂停图片</label>
						<div class="layui-input-inline long">
							<input type="text" name="yzm[ads][pause][pic]" value="<?php echo $yzm['ads']['pause']['pic'] ?>" size="30" class="layui-input upload-input" placeholder="图片地址">
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">暂停图片链接</label>
						<div class="layui-input-inline long">
							<input type="text" name="yzm[ads][pause][link]" value="<?php echo $yzm['ads']['pause']['link'] ?>" size="30" class="layui-input upload-input" placeholder="点击链接地址">
						</div>
					</div>
					<div class="layui-form-item center">
						<div class="layui-input-block">
							<input name="edit" type="hidden" value="1" />
							<button class="layui-btn" type="button" onclick="text()">保 存</button>
							<button class="layui-btn layui-btn-warm" type="reset" onclick="reset1()">还 原</button>
						</div>
					</div>
				</div>
			
				
				<div class="layui-tab-item" name="广告设置">
					<div class="layui-form-item">
				
						<label class="layui-form-label">账号</label>
						<div class="layui-input-inline">
							<input type="text" name="user[uid]" value="<?php echo $user['uid'] ?>" size="30" class="layui-input upload-input" placeholder="解析账号">
						</div>
						<div class="layui-form-mid layui-word-aux">解析账号在后台获取,后台地址 guazitv6.com</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">密钥</label>
						<div class="layui-input-inline long">
							<input type="text" name="user[token]" value="<?php echo $user['token'] ?>" size="30" class="layui-input upload-input" placeholder="密钥地址">
						</div>
						<div class="layui-form-mid layui-word-aux">这里填写你的密钥，在 http://guazitv6.com平台可以查看</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">加载图片</label>
						<div class="layui-input-inline">
							<input type="text" name="user[jhpic]" value="<?php echo $user['jhpic']?>" size="30" class="layui-input upload-input" placeholder="gif图片">
						</div>
						<div class="layui-form-mid layui-word-aux">解析加载图片。</div>
					</div>
				<div class="layui-form-item">
						<label class="layui-form-label">备用接口</label>
						<div class="layui-input-inline">
							<input type="text" name="user[api]" value="<?php echo $user['api']?>" size="30" class="layui-input upload-input" placeholder="备用api">
						</div>
						<div class="layui-form-mid layui-word-aux">这里是填写你的备用api，json格式的</div>
					</div>
			
				
        	<div class="layui-form-item">
						<label class="layui-form-label">解析名称</label>
						<div class="layui-input-inline">
							<input type="text" name="user[title]" value="<?php echo $user['title']?>" size="30" class="layui-input upload-input" placeholder="瓜子智能云解析">
						</div>
						<div class="layui-form-mid layui-word-aux">设置解析页面title名称   例如 '瓜子智能云解析',</div>
					</div>
						
				<div class="layui-form-item">
						<label class="layui-form-label">P2P加速</label>
						<div class="layui-input-inline">
							<input type="text" name="user[p2p]" value="<?php echo $user['p2p']?>" size="30" class="layui-input upload-input" placeholder="p2p">
						</div>
						<div class="layui-form-mid layui-word-aux">1开0关,支持mp4,m3u8,如播放资源站资源建议开启,相关加速流量百度cdnbye</div>
					</div>
						<div class="layui-form-item">
						<label class="layui-form-label">右键文字</label>
						<div class="layui-input-inline">
							<input type="text" name="user[wenzi]" value="<?php echo $user['wenzi']?>" size="30" class="layui-input upload-input" placeholder="文字">
						</div>
						<div class="layui-form-mid layui-word-aux">填写你的右键文字</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">右键链接</label>
						<div class="layui-input-inline">
							<input type="text" name="user[link]" value="<?php echo $user['link']?>" size="30" class="layui-input upload-input" placeholder="链接">
						</div>
						<div class="layui-form-mid layui-word-aux">设置解析播放器右键 如,guazitv6.com',</div>
					</div>
						<div class="layui-form-item">
						<label class="layui-form-label">解析失败提示语</label>
						<div class="layui-input-inline">
							<input type="text" name="user[jxsb]" value="<?php echo $user['jxsb']?>" size="30" class="layui-input upload-input" placeholder="解析失败了">
						</div>
						<div class="layui-form-mid layui-word-aux">这里设置你的解析失败消息'</div>
					</div>
					
					<div class="layui-form-item">
						<label class="layui-form-label">防盗域名</label>
						<div class="layui-input-inline">
							<input type="text" name="user[fd]" value="<?php echo $user['fd']?>" size="30" class="layui-input upload-input" placeholder="这里写域名">
						</div>
						<div class="layui-form-mid layui-word-aux">防盗链域名，多个用|隔开，如：123.com|abc.com（不设置盗链请留空）</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">防盗信息</label>
						<div class="layui-input-inline">
							<input type="text" name="user[fdhost]" value="<?php echo $user['fdhost']?>" size="30" class="layui-input upload-input" placeholder="信息">
						</div>
						<div class="layui-form-mid layui-word-aux">这里设置你的防盗信息'</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">统计信息</label>
						<div class="layui-input-inline long">
							<input type="text" name="user[tongji]" value="<?php echo $user['tongji'] ?>" size="30" class="layui-input upload-input" placeholder="统计地址">
						</div>
						<div class="layui-form-mid layui-word-aux">统计代码.  复制你的统计代码到这就可以拉，如友盟，百度代码id，https://s13.cnzz.com/z_stat.php?id=1274097302&web_id=1274097302</div>
					</div>
			
					<div class="layui-form-item center">
						<div class="layui-input-block">
							<input name="edit" type="hidden" value="1" />
							<button class="layui-btn" type="button" onclick="text()">保 存</button>
							<button class="layui-btn layui-btn-warm" type="reset" onclick="reset1()">还 原</button>
						</div>
					</div>
				</div>	
				
				
			
    					

    
    	
				
				
				
				
				
				
				
				
				
				
				<div class="layui-tab-item" name="广告设置">
					<div class="layui-tab" overflow>
						<ul class="layui-tab-title">
							<li class="layui-this">弹幕列表</li>
							<li class="">举报列表</li>
						</ul>
						<div class="layui-tab-content">
							<div class="layui-tab-item layui-show" name="弹幕列表">
								<div class="chu" style="margin-top:30px">
									<div class="demoTable layui-form-item">
										<div class="layui-inline">
											<label class="layui-form-label">搜索</label>
											<div class="layui-input-inline">
												<input class="layui-input" id="textdemo" placeholder="请输入弹幕id或弹幕关键字">
											</div>
											<button class="layui-btn" lay-submit="search_submits" type="button" lay-filter="reloadlst_submit">搜索</button>
										</div>
									</div>
								</div>
								<table class="layui-hide" id="dmlist" lay-filter="dmlist">
								</table>
							</div>

							<div class="layui-tab-item" name="举报列表">
								<table class="layui-hide" id="dmreport" lay-filter="report">
								</table>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
		</div>
	</form>
	<script type="text/html" id="listbar">
		<a class="layui-btn layui-btn-xs" lay-event="dmedit">编辑</a>
		<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
	</script>
	<script type="text/html" id="reportbar">
		<a class="layui-btn layui-btn-xs" lay-event="edit">误报</a>
		<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
	</script>

	<script type="text/template" id="bondTemplateList">
		<div class="layui-card-body" style="padding: 15px;">
        <form class="layui-form" lay-filter="component-form-group" id="submits" onsubmit="return false">
            <div class="layui-row layui-col-space10 layui-form-item">
                <input type="hidden" name="cid" value="{{ d[4] }}">
                <div class="layui-col-lg5">
                    <label class="layui-form-label">弹幕ID：</label>
                    <div class="layui-input-block">
                        <input type="text" name="id" placeholder="请输入名称" autocomplete="off"
                               lay-verify="required" class="layui-input"
                               value="{{ d[0]?d[0]:'' }}" {{# if(d[0]){ }}disabled{{# } }}>
                    </div>
                </div>
                <div class="layui-col-lg5">
                    <label class="layui-form-label">颜色：</label>
  						<div class="layui-input-block">
							<div class="layui-input-inline" style="width: 120px;">
								<input type="text" name="color" placeholder="请选择颜色" class="layui-input" id="test-form-input" value="{{ d[3]?d[3]:'' }}">
							</div>
						<div class="layui-inline" style="left: -11px;">
						<div id="test-form"></div>
					</div>
				</div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">弹幕内容</label>
                    <div class="layui-input-block">
                    <textarea name="text" placeholder="请输入内容" class="layui-textarea"
                              lay-verify="required">
                        {{ d[5] ? d[5]:'' }}
                    </textarea>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit="" lay-filter="bond_sumbit">立即提交</button>
                </div>
            </div>
        </form>
    </div>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
</script>

</body>

</html>