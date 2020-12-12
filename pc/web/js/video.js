$(function(){
	
	$(document).on("focus",".search-input",function(){
		var $par=$(this).parents(".index-header-search");
		var $reuslt=$(this).siblings(".index-header-search-result");
		$par.addClass("result");
		$reuslt.show();
		$('.index-search-btn').css('background-color', '#FF7488');
		$('.index-header-search').css('border', '1px solid #FF7488');
		$('.index-header-search-result').css('border', '1px solid #FF7488');
	})

	//搜索框阻止点击事件冒泡
	$('.index-header-search').click(function (event) {
		event.stopPropagation();
	});

	//点击搜索框以外，隐藏搜索框
	document.onclick = function (e) {
		$('.index-header-search').removeClass("result");
		$('.index-header-search-result').hide();
		$('.index-search-btn').css('background-color', '#FF556E');
		$('.index-header-search').css('border', '1px solid #FF556E');
		$('.index-header-search-result').css('border', '1px solid #FF556E');
	};

	$(document).on("click",".tab-nav li",function(){
		var num=$(this).index();
		$(this).addClass("on").siblings().removeClass("on");
		var $sib=$(this).parents(".tab-nav").siblings(".tab-box");
		$sib.find(".tab-list").eq(num).addClass("isshow").siblings(".tab-list").removeClass("isshow");
	});

	$(document).on("click",".jglist-select",function(){
		console.log(11);
		var $toggle=$(this).find(".jglist-select-toggle");
		var selected=$toggle.hasClass("is-selected"),
		$sib=$toggle.siblings(".jglist-selct-list"),
		$par=$toggle.parent(".jglist-select");
		var $ul = $sib.find(".select-list");
		 if (!$ul || $ul.length <= 0) return;
		 if(selected){
			$sib.slideUp(300,function(){
			
			});
			 $toggle.removeClass("is-selected");
		 }else{
			 $toggle.addClass("is-selected");
			
			$sib.slideDown(300,function(){
			});
			
		}
	})
	$(document).on("click",function(e){
	 if($(e.target).closest(".jglist-select").length == 0){
		$(".jglist-select .jglist-selct-list").slideUp(300);
		$(".jglist-select .jglist-select-toggle").removeClass("is-selected");
		}
	});
	$(document).on("click",".jglist-selct-list li",function(){
		var sval=$(this).text();
		var $par=$(this).parents(".jglist-selct-list");
		var $sib=$par.siblings(".jglist-select-toggle");
		$(this).addClass("on").siblings().removeClass("on");
		$sib.find(".common-input").val(sval);
	})
	$(document).on("click",".pop-close,.pop-mask",function(){
		$(".pop-mask").remove();
		$(".pop-index-box").remove();
	}).on("click",".ask-share",function(){
		var htmlPopShare=`
		<div class="pop-mask"></div>
		<div class="pop-video-share pop-index-box">
			<a href="javascript:;" class="pop-close iconfont">&#xe641;</a>
			<h3 class="pop-share-title"><span>视频播放源分享</span></h3>
			<div class="pop-form-group clearfix mt39">
				<label class="common-label fl">播放源</label>
				<div class="pop-form fl">
					<input type="text" class="common-input">
					<div class="common-error"></div>
				</div>
			</div>
			<div class="pop-form-group clearfix">
				<label class="common-label fl">片名</label>
				<div class="pop-form fl">
					<input type="text" class="common-input">
					<div class="common-error"></div>
				</div>
			</div>
			<div class="pop-form-group clearfix">
				<label class="common-label fl">频道</label>
				<div class="jglist-select fl ">
					<div class="jglist-select-toggle pop-form ">
						<input type="text" class="common-input" autocomplete="off" readonly="readonly" placeholder="电视剧">
						<span class="iconxiala icon_bottom_no_bg"></span>
						<div class="common-error"></div>
					</div>
					<div class="jglist-selct-list jglist-select-border-none">
						<ul class="select-list">
							<li><a href="javascript:;">电影</a></li>
							<li><a href="#">电视剧</a></li>
							<li><a href="#">综艺</a></li>
							<li><a href="#">动漫</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="pop-form-group clearfix">
				<label class="common-label fl">简介</label>
				<div class="pop-form fl">
					<textarea class="common-textarea" placeholder="请填写简介，简单介绍一下您的视频"></textarea>
					<div class="common-error"></div>
				</div>
			</div>
			<a href="javascript:;" class="pop-share-btn">保存并发布</a>
		</div>
		`;
		 $("body").append(htmlPopShare);
		
	}).on("click",".ask-login",function(){
		
		var htmlPopLogin =`
		<div class="pop-mask"></div>
		<div class="pop-login-box pop-index-box">
			<a href="javascript:;" class="pop-close"></a>
			<h3 class="pop-title">欢迎登录/注册瓜子视频</h3>
			<div class="pop-form mt39">
				<input type="text" class="common-input" placeholder="请输入手机号"> 
				<div class="common-error"> </div>
			</div>
			<div class="pop-form get-code">
				<input type="text" class="common-input" placeholder="请输入验证码">
				<span class="get-code-btn">获取验证码</span>
				<div class="common-error"> </div>
			</div>
			<a href="javascript:;" class="pop-btn">立即登录</a>
			<p class="pop-notice">登录即同意<span>《瓜子视频服务协议》</span></p>
		</div>
		`;
		 $("body").append(htmlPopLogin);
	})

	$('.index-logo').click(function () {
		window.location.href = '/';
	})

	$('.watchYes').click(function () {
		alert('功能开发中!');
	})
	
})
