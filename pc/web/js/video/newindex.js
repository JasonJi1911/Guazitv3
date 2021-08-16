//滚动条移动62px,改变navTop样式
$(window).scroll(function() {
	//获取距离页面顶部的距离
	let toTop = document.documentElement.scrollTop || document.body.scrollTop;
	if(toTop > 100) {
		$('#indexTS .navTopBox').removeClass('bkgBlack')
		$('#indexTS .navTopBox').addClass('bkgWhite')
		$('.rigNav-top').show();
	} else {
		$('#indexTS .navTopBox').addClass('bkgBlack')
		$('#indexTS .navTopBox').removeClass('bkgWhite')
		$('.rigNav-top').hide();
	}
});

//vip弹出层
$(document).ready(function() {
	//	弹出层显示
	$("#vipbtn").click(function() {
		$("#alt02").show();
	});
	//	付费金额切换
	$(".alt02-xz>ul").click(function() {
		$(this).addClass("alt02-bdr").siblings().removeClass("alt02-bdr");
	});
	//	付费模式切换
	$(".alt02-tabA>li").click(function() {
		var tabNum = $(this).index();
		$(this).addClass("tabA").siblings().removeClass("tabA");
		$(".paybox>div").eq(tabNum).addClass("act").siblings().removeClass("act");
	});
	//  聚合支付   支付方式选择，授权支付按钮可用
	$(".paybox02-fs>div").click(function() {
		$(".paybox02-btn>input").removeAttr("disabled");
	});
});

//详情弹出曾
$(document).ready(function() {
	//	弹出层显示
	$(".XQ").click(function() {
		$("#alt03").show();
	});
	//	收藏按钮改变样式
	$(".XQ-btn > input").click(function() {
		$(this).toggleClass("act");
	});
});

//首页大轮播
$(document).ready(function() {
	var imgGeshu = $("#imgList a").length - 1;
	//设置变量速度为3秒
	var speed = 3000;
	//循环变量为1，是避免定时器再等第一章图片
	var m = 1;
	//设置定时器的函数和时间
	var playTimer = setInterval(runPlay, speed);
	//定时函数
	function runPlay() {
		//判读如果m大于imgGeshu，就设置m=0
		if(m > imgGeshu) {
			m = 0;
		}
		//调用controlPlay函数来控制图片变化
		controlPlay(m);
		m++;
	}
	//通过参数控制图片的变化,图标变化
	function controlPlay(n) {
		$("#imgList a").removeClass("current").eq(n).addClass("current");
		$(".iconList ul li").removeClass("current").eq(n).addClass("current");
	}
	//给整个轮播图绑定鼠标事件，当鼠标放到轮播图上停止轮播图，当鼠标离开轮播图继续滚动
	$("#playBox").mouseenter(function() {
		//停止定时
		clearInterval(playTimer);
		//左右控制按钮显示
	}).mouseleave(function() {
		//重新开始定时
		playTimer = setInterval(runPlay, speed);
	});
	//给li绑定控制图标绑定单击事件
	$(".iconList ul li").hover(function() {
		controlPlay($(this).index());
		//鼠标点击过后修改m的值
		m = $(this).index() + 1;
	})

});

// //热点轮播
// $(document).ready(function() {
// 	//设置默认图片大小
// 	var imgGeshu02 = $("#imgList02 a").length - 1;
// 	//设置变量速度为3秒
// 	var speed02 = 2000;
// 	//循环变量为1，是避免定时器再等第一章图片
// 	var m02 = 1;
// 	//设置定时器的函数和时间
// 	var playTimer02 = setInterval(runPlay02, speed02);
// 	//定时函数
// 	function runPlay02() {
// 		//判读如果m大于imgGeshu，就设置m=0
// 		if(m02 > imgGeshu02) {
// 			m02 = 0;
// 		}
// 		//调用controlPlay函数来控制图片变化
// 		controlPlay02(m02);
// 		m02++;
// 	}
// 	//通过参数控制图片的变化,图标变化
// 	function controlPlay02(n) {
// 		$("#imgList02 a").removeClass("current02").eq(n).addClass("current02");
// 		$(".iconList02 ul li").removeClass("current02").eq(n).addClass("current02");
// 	}
// 	//给整个轮播图绑定鼠标事件，当鼠标放到轮播图上停止轮播图，当鼠标离开轮播图继续滚动
// 	$("#playBox02").mouseenter(function() {
// 		//停止定时
// 		clearInterval(playTimer02);
// 	}).mouseleave(function() {
// 		//重新开始定时
// 		playTimer02 = setInterval(runPlay02, speed02);
// 	});
// 	//给li绑定控制图标绑定单击事件
// 	$(".iconList02 ul li").click(function() {
// 		controlPlay02($(this).index());
// 		//鼠标点击过后修改m的值
// 		m02 = $(this).index() + 1;
// 	}).hover(function() {
// 		//给li取消鼠标悬停的冒泡
// 		return false;
// 	})
// 	//给li绑定控制图标绑定单击事件
// 	$(".iconList02 ul li").hover(function() {
// 		controlPlay02($(this).index());
// 		//鼠标点击过后修改m的值
// 		m02 = $(this).index() + 1;
// 	})
//
// });

//关闭按钮

$(document).ready(function() {
	$('.alt-GB').click(function() {
		$(this).parents('.alt').hide();
	});

});

//换肤
$(document).ready(function() {
	$('#HF').click(function() {
		$("[name='zt']").toggleClass("ZT-black");
		//.i_background_errorimg
		$(".i_background_errorimg").each(function (i, n) {
			var imgurl = $(this)[0].src;
			if(imgurl.indexOf("znwuC-b.png")>=0){
				$(this).attr('src',"../../images/newindex/znwuC-g.png");
			}else if(imgurl.indexOf("znwuG-b.png")>=0){
				$(this).attr('src',"../../images/newindex/znwuG-g.png");
			}else if(imgurl.indexOf("znwuC-g.png")>=0){
				$(this).attr('src',"../../images/newindex/znwuC-b.png");
			}else if(imgurl.indexOf("znwuG-g.png")>=0){
				$(this).attr('src',"../../images/newindex/znwuG-b.png");
			}
		});
	});
});

//按钮不触发a链接

$(document).ready(function() {

	$(".Movie-btm").click(function() {
		return false;
	});
});

//tab 切换
$(document).ready(function() {

	$(".XX-tabA>li").click(function() {
		var tabNum = $(this).index();
		$(this).addClass("tabA").siblings().removeClass("tabA");
		$(".XX-tabBox>div").eq(tabNum).addClass("tabBox").siblings().removeClass("tabBox");
	});
});

//筛选条件选中样式切换
// $(document).ready(function() {
// 	$(".condition>li>a").click(function() {
// 		$(this).addClass("conditionAct").parents('li').siblings().find('a').removeClass("conditionAct");
// 		$(this).addClass("conditionAct").parents('.conditionType').find('.conditionType-all>a').removeClass("conditionAct");
// 	});
// 	$(".conditionType-all>a").click(function() {
// 		$(this).addClass("conditionAct").parents(".conditionType").find(".condition>li>a").removeClass("conditionAct");
// 	});
// });

//排序样式切换
// $(document).ready(function() {
// 	$(".scPX>li").click(function() {
// 		if($(this).hasClass("scJgAct")) {
// 			$(this).find("span").toggleClass("pxBj");
// 		} else {
// 			$(this).addClass("scJgAct").siblings().removeClass("scJgAct");
// 			$(this).siblings().find("span").removeClass("pxBj");
// 		}
//
// 	});
// });
//播放页按钮样式切换
$(document).ready(function() {

	$(".rBtn-02").click(function() {
		$(this).toggleClass("act");
	});
	$(".rBtn-03").click(function() {
		$(this).toggleClass("act");
	});
	$(".rBtn-04").click(function() {
		$(this).toggleClass("act");
	});
	$(".lBtn-01").click(function() {
		$(this).toggleClass("act");
	});
	$(".lBtn-02").click(function() {
		$(this).toggleClass("act");
	});
	//	手机看弹出曾
	$(".rBtn-06>input").click(function() {
		$(".Altsjk").toggle();
	});
	$(".Altsjk .GB").click(function() {
		$(".Altsjk").hide();
	});

	//	详情,统计,简介点击效果

	$(".GNbox-xq").click(function() {
		$(this).toggleClass("act");
		$(".GNbox-TJ").removeClass("act");
		$(".GNbox-TJ-K").hide();
		$(".GNbox-xq-K").toggle(500);
	});
	$(".GNbox-TJ").click(function() {
		$(this).toggleClass("act");
		$(".GNbox-xq").removeClass("act");
		$(".GNbox-xq-K").hide();
		$(".GNbox-TJ-K").toggle(500);
	});
	//  集数切换效果
	$(".GNbox-JS>a").click(function() {
		$(this).addClass("act").siblings().removeClass("act");
	});
	
	//  集数tab 全部显示
	
	$(".GNtab-all").click(function() {
		$(this).hide().parents(".GNtab").addClass("GNall");
		$(".GNtab-sq").show();
	});
	$(".GNtab-sq").click(function() {
		$(this).hide().parents(".GNtab").removeClass("GNall");
		$(".GNtab-all").show();
	});
	
	// 集数tab切换
	$(".GNtab>.GNtab-a").click(function() {
		var tabNum = $(this).index()-2;
		$(this).addClass("act").siblings(".GNtab-a").removeClass("act");
		$(".GNtab-Box>div").eq(tabNum).addClass("act").siblings().removeClass("act");
	});

	// 片源报错alert
	$(".rBtn-07").click(function() {
		$("#alt04").show();
	});
});

//排行榜页面
$(document).ready(function() {
	//	排行榜页面tab样式切换
	$(".RANbox-tab>li").click(function() {
		var ranTabNum = $(this).index();
		$(this).addClass("act").siblings().removeClass("act");
		$(".RANbox>div").eq(ranTabNum).addClass("act").siblings().removeClass("act");
	});

	//  年月日排行样式切换
	$(".RAN-date>li").hover(function() {
		$(this).addClass("act").siblings().removeClass("act");
	});

});

//帮助中心页面
$(document).ready(function() {
	//	常见问题tab样式切换
	$(".hlptab-a>li").click(function() {
        var ranTabNum = $(this).index();
        $(this).addClass("act").siblings().removeClass("act");
        $(".hlp-text").removeClass("act");
        $(".hlp-text02").hide();
        $(this).parents(".hlp-w").siblings().find(".hlp-text02").hide(500);
        $(".hlptab-box>div").eq(ranTabNum).addClass("act").siblings().removeClass("act");
	});

	// 问题样式切换hlp-text01
	$(".hlp-text").click(function() {
		$(this).find(".hlp-text01").siblings(".hlp-text02").toggle(500).parents(".hlp-text").toggleClass("act").siblings(".hlp-text").removeClass("act").find(".hlp-text02").hide(500);
	});
	//	app下载tab样式切换
	$(".app-tabA>li").click(function() {
		var ranTabNum = $(this).index();
		$(this).addClass("act").siblings().removeClass("act");
		$(this).parents("ul").siblings("ul").find("li").eq(ranTabNum).addClass("act").siblings().removeClass("act");
	});
	//	app安装教程显示/隐藏
	$(".hlp-app-jc").click(function() {
		$(this).find(".dh-02").toggleClass("act");
		$(this).find("ul").toggle(500);
		$(this).find("p").toggle(500);
	});
	//  左侧定位锚点
	$(window).scroll(function() {
		//获取距离页面顶部的距离
		var toTop2 = document.documentElement.scrollTop || document.body.scrollTop;
		if (822 > toTop2 ) {
			$(".hlp-app-nav a").removeClass("act")
			$(".hlp-app-nav>li:first-of-type a").addClass("act")
		};
		if (822 < toTop2 ) {
			$(".hlp-app-nav a").removeClass("act")
			$(".hlp-app-nav>li:nth-of-type(2) a").addClass("act")
		};
		if ( toTop2 > 1644) {
			$(".hlp-app-nav a").removeClass("act")
			$(".hlp-app-nav>li:last-of-type a").addClass("act")
		};
	});
});

//个人中心  tab 切换
$(document).ready(function() {
	//	页面切换
	$(".per-tab>li").click(function() {
		var tabNum = $(this).index();
		$(this).addClass("act").siblings().removeClass("act");
		$(".per-tab-w>div").eq(tabNum).addClass("act").siblings().removeClass("act");
	});
	// 视频页tab  切换
	$(".per-tab02>li").click(function() {
		var tabNum = $(this).index();
		$(this).addClass("act").siblings().removeClass("act");
		$(".per-tab-w02>div").eq(tabNum).addClass("act").siblings().removeClass("act");
	});
	// 关注页tab  切换
	$(".per-tab03>li").click(function() {
		var tabNum = $(this).index();
		$(this).addClass("act").siblings().removeClass("act");
		$(".per-tab-w03>div").eq(tabNum).addClass("act").siblings().removeClass("act");
	});
	// 消息页tab  切换
	$(".per-tab04>li").click(function() {
		var tabNum = $(this).index();
		$(this).addClass("act").siblings().removeClass("act");
		$(".per-tab-w04>div").eq(tabNum).addClass("act").siblings().removeClass("act");
	});

	//点赞
	$(".per-btn-z").click(function() {
		var tabNum = $(this).index();
		$(this).toggleClass("act").siblings("span").toggleClass("act");
	});
	// 收藏页tab  切换
	$(".per-tab05>li").click(function() {
		var tabNum = $(this).index();
		$(this).addClass("act").siblings().removeClass("act");
		$(".per-tab-w05>div").eq(tabNum).addClass("act").siblings().removeClass("act");
	});
	// 人气  状态 等  下拉菜单样式切换  文字切换
	$(".per-slt-name>input").click(function() {
		$('.per-slt-name>input').removeClass("act");
		$('.per-slt-list').removeClass("act");
		$(this).toggleClass("act").parents(".per-slt-name").siblings(".per-slt-list").toggleClass("act");
	});

	$(document).click(function(e) {
		var $target = $(e.target);
		// 点击下拉菜单以外的地方切换样式
		if(!$target.is('.per-slt *') && !$target.is('.per-slt')) {
			$('.per-slt-name>input').removeClass("act");
			$('.per-slt-list').removeClass("act");
		}
	});

	$(".per-slt-list>input").click(function() {
		var perSlt=$(this).val();
		$(this).addClass("act").siblings().removeClass("act");
		$(this).parents(".per-slt").find(".per-slt-name>input").val(perSlt);
		$('.per-slt-name>input').removeClass("act");
		$('.per-slt-list').removeClass("act");
	});

	// 收藏页全选样式切换
	$(".per-qx>input").click(function() {
		$(this).parents(".per-sp-box").addClass("act").siblings(".per-sp-box02").addClass("act");
		$(this).parents(".per-sp-box").siblings(".per-tab-w05").find(".per-tab-box05.act .per-btn-tow").toggle();
		$(this).parents(".per-sp-box").siblings(".per-tab-w05").find(".per-tab-box05.act .per-btn-cbox").toggle();
	});
	$("#btnQX>input").click(function() {
		$(this).parents(".per-sp-box02").removeClass("act").siblings(".per-sp-box").removeClass("act");
		$(this).parents(".per-sp-box02").siblings(".per-tab-w05").find(".per-tab-box05.act .per-btn-tow").toggle();
		$(this).parents(".per-sp-box02").siblings(".per-tab-w05").find(".per-tab-box05.act .per-btn-cbox").toggle();
		//取消选择
		$(this).parents(".per-sp-box02").siblings(".per-tab-w05").find(".per-tab-box05.act .per-btn-cbox>input").removeClass("act").removeAttr("checked");
	});

	//全选
	$(".per-qx-02>input").click(function() {
		$(this).parents(".per-sp-box02").siblings(".per-tab-w05").find(".per-tab-box05.act .per-btn-cbox>input").addClass("act").attr("checked","checked");
	});
	$(".per-btn-cbox>input").click(function() {
		$(this).toggleClass("act");
		var  aggg=$(this).attr("class");
		if (aggg=="act") {
			$(this).attr("checked","checked");
		} else{
			$(this).removeAttr("checked");
		};
	});


	// 播放记录页tab  切换
	$(".per-tab06>li").click(function() {
		var tabNum = $(this).index();
		$(this).addClass("act").siblings().removeClass("act");
		$(".per-tab-w06>div").eq(tabNum).addClass("act").siblings().removeClass("act");
	});

	// 私信页面  消息设置
	$(".per-qq-sz").click(function() {
		$(this).removeClass("act").siblings(".per-qq-bl").addClass("act");
		$(".per-yh-lst").toggleClass("act");
		$(".per-qq-xxsz-box").toggleClass("act");
	});
	$(".per-qq-bl").click(function() {
		$(this).removeClass("act").siblings(".per-qq-sz").addClass("act");
		$(".per-yh-lst").toggleClass("act");
		$(".per-qq-xxsz-box").toggleClass("act");
	});
	// 私信页面  用户切换
	$(".per-qq-yh").click(function() {
		$(this).addClass("act").siblings(".per-qq-yh").removeClass("act");
	});
	// 私信页面  设置按钮切换
	$(".per-qq-xxsz-an label").click(function() {
		$(this).toggleClass("act");
	});
	// 私信页面  关注按钮切换
	$(".per-qq-name02>input").click(function() {
		$(".per-qq-name02>input").toggleClass("act");
	});
	// 私信页面  设置下拉菜单
	$(".per-qq-sz02").click(function() {
		$(this).toggleClass("act")
		$(".per-qq-sz02-slc").toggleClass("act");
	});
	$(".per-qq-sz02-slc input").click(function() {
		$(".per-qq-sz02").toggleClass("act")
		$(".per-qq-sz02-slc").toggleClass("act");
	});

	$(document).click(function(e) {
		var $target = $(e.target);
		// 点击下拉菜单以外的地方切换样式
		if(!$target.is('.per-qq-sz02-slc *') && !$target.is('.per-qq-sz02')) {
			$('.per-qq-sz02-slc').removeClass("act");
			$('.per-qq-sz02').removeClass("act");
		}
	});
});

// //首页图片高度统一
// $(document).ready(function(e) {
// //	热点图片
// 	var indexedImgHgt01 = $(".RD-img").width() / 215 * 120 / 2;
// 	$(".RD-img>img").height(indexedImgHgt01);
// //	电影图片
// 	var indexedImgHgt02 = $(".HrBox-D").width() / 215 * 120;
// 	$(".HrBox-img").height(indexedImgHgt02);
// //	视频图片
// 	var indexedImgHgt03 = $(".Movie-list").width() / 58 * 78;
// 	$(".Movie-list .Movie-img").height(indexedImgHgt03);
// //	热点轮播图片
// 	var indexedImgHgt04 = $(".RD-banner .RD-img").width() / 220 * 125;
// 	$(".RD-banner .RD-img>img").height(indexedImgHgt04);
// });
// //窗口大小改变   首页图片高度统一
// window.onresize = function() {
// //	热点图片
// 	var indexedImgHgt01 = $(".RD-img").width() / 215 * 120 / 2;
// 	$(".RD-img>img").height(indexedImgHgt01);
// //	电影图片
// 	var indexedImgHgt02 = $(".HrBox-D").width() / 215 * 120;
// 	$(".HrBox-img").height(indexedImgHgt02);
// //	视频图片
// 	var indexedImgHgt03 = $(".Movie-list").width() / 58 * 78;
// 	$(".Movie-list .Movie-img").height(indexedImgHgt03);
// //	热点轮播图片
// 	var indexedImgHgt04 = $(".RD-banner .RD-img").width() / 220 * 125;
// 	$(".RD-banner .RD-img>img").height(indexedImgHgt04);
// };

//落地页面
$(document).ready(function() {
	//	最近更新  样式切换
	$(".ind-bth-box01>input").click(function() {
		$(this).addClass("act").siblings().removeClass("act");
	});
	//	影片产地  样式切换
	$(".ind-bth-all").click(function() {
		$(".ind-bth-all").addClass("act");
		$(".ind-bth").removeClass("act");
	});
	$(".ind-bth").click(function() {
		$(".ind-bth").addClass("act");
		$(".ind-bth-all").removeClass("act");
	});
});

//求篇弹出层
// $(document).ready(function() {
// 	//	最近更新  样式切换
// 	$(".seek-btn").click(function() {
// 		$("#alt05").show();
// 	});
// });

