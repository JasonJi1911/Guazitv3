//滚动条移动62px,改变navTop样式
$(window).scroll(function() {
	//获取距离页面顶部的距离
	let toTop = document.documentElement.scrollTop || document.body.scrollTop;
	if(toTop > 100) {
		$('#indexTS .navTopBox').removeClass('bkgBlack')
		$('#indexTS .navTopBox').addClass('ZT-black')
		$('.rigNav-top').show();
	} else {
		$('#indexTS .navTopBox').addClass('bkgBlack')
		$('#indexTS .navTopBox').removeClass('ZT-black')
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
	// $(".XQ-btn > input").click(function() {
	// 	$(this).toggleClass("act");
	// });
});

//首页大轮播
$(document).ready(function() {
	var imgGeshu = $("#imgList a").length - 1;
	//设置变量速度为3秒
	var speed = 8000;
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
	// $(".rBtn-04").click(function() {
	// 	$(this).toggleClass("act");
	// });
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
	$(".qy-shouji").click(function() {
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
		$(".GNbox-xq-K").toggle();
		// $(".GNbox-xq-K").toggle(500);
	});
	$(".GNbox-TJ").click(function() {
		$(this).toggleClass("act");
		$(".GNbox-xq").removeClass("act");
		$(".GNbox-xq-K").hide();
		$(".GNbox-xq-K").toggle();
		// $(".GNbox-TJ-K").toggle(500);
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
	// $(".rBtn-07").click(function() {
	// 	$("#alt04").show();
	// });
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

	//	帮助页面tab样式切换
	$(".RANbox-help-tab>li").click(function() {
		var ranTabNum = $(this).index();
		$(this).addClass("act").siblings().removeClass("act");
		$(".RANbox-help>div").eq(ranTabNum).addClass("act").siblings().removeClass("act");
		//图标为选中样式
		$(this).find('.J_per_tab_img').hide().siblings('.J_per_tab_img_c').show();
		$(this).siblings().find('.J_per_tab_img').show().siblings('.J_per_tab_img_c').hide();
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
	// $(".per-tab03>li").click(function() {
	// 	var tabNum = $(this).index();
	// 	$(this).addClass("act").siblings().removeClass("act");
	// 	$(".per-tab-w03>div").eq(tabNum).addClass("act").siblings().removeClass("act");
	// });
	// 消息页tab  切换
	$(".per-tab04>li").click(function() {
		var tabNum = $(this).index();
		$(this).addClass("act").siblings().removeClass("act");
		$(".per-tab-w04>div").eq(tabNum).addClass("act").siblings().removeClass("act");
	});

	//点赞
	// $(".per-btn-z").click(function() {
	// 	var tabNum = $(this).index();
	// 	$(this).toggleClass("act").siblings("span").toggleClass("act");
	// });
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

	// $(".per-slt-list>input").click(function() {
	// 	var perSlt=$(this).val();
	// 	$(this).addClass("act").siblings().removeClass("act");
	// 	$(this).parents(".per-slt").find(".per-slt-name>input").val(perSlt);
	// 	$('.per-slt-name>input').removeClass("act");
	// 	$('.per-slt-list').removeClass("act");
	// });

	// 收藏页全选样式切换
	$(".per-qx>input").click(function() {
		$(this).parents(".per-sp-box").addClass("act").siblings(".per-sp-box02").addClass("act");
		$(this).parents(".per-sp-box").siblings(".per-tab-w05").find(".per-tab-box05.act .per-btn-tow").toggle();
		$(this).parents(".per-sp-box").siblings(".per-tab-w05").find(".per-tab-box05.act .per-btn-cbox").toggle();
	});
	// $("#btnQX>input").click(function() {
	// 	$(this).parents(".per-sp-box02").removeClass("act").siblings(".per-sp-box").removeClass("act");
	// 	$(this).parents(".per-sp-box02").siblings(".per-tab-w05").find(".per-tab-box05.act .per-btn-tow").toggle();
	// 	$(this).parents(".per-sp-box02").siblings(".per-tab-w05").find(".per-tab-box05.act .per-btn-cbox").toggle();
	// 	//取消选择
	// 	$(this).parents(".per-sp-box02").siblings(".per-tab-w05").find(".per-tab-box05.act .per-btn-cbox>input").removeClass("act").removeAttr("checked");
	// });

	//全选
	// $(".per-qx-02>input").click(function() {
	// 	$(this).parents(".per-sp-box02").siblings(".per-tab-w05").find(".per-tab-box05.act .per-btn-cbox>input").addClass("act").attr("checked","checked");
	// });
	// $(".per-btn-cbox>input").click(function() {
	// 	$(this).toggleClass("act");
	// 	if($(this).hasClass("act")){
	// 		$(this).attr("checked","checked");
	// 	} else{
	// 		$(this).removeAttr("checked");
	// 	};
	// });

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

//个人中心(新)  tab 切换
$(document).ready(function() {
	//	页面切换
	$(".box-per-tab>li").click(function () {
		var tabNum = $(this).index();
		$(this).addClass("act").siblings().removeClass("act");
		$(".per-tab-w-new>div").eq(tabNum).addClass("act").siblings().removeClass("act");
	});
});

// //首页图片高度统一
// $(document).ready(function(e) {
// 	//	热点图片
// 	var indexedImgHgt01 = $(".RD-img").width() / 640 * 360 / 2;
// 	$(".RD-img>img").height(indexedImgHgt01);
// 	//	视频图片
// 	var indexedImgHgt02 = $(".HrBox-D").width() / 640 * 360;
// 	$(".HrBox-img").height(indexedImgHgt02);
// 	//	电影图片
// 	var indexedImgHgt03 = $(".Movie-list").width() / 420 * 600;
// 	$(".Movie-list .Movie-img").height(indexedImgHgt03);
// 	//	热点轮播图片
// 	var indexedImgHgt04 = $(".RD-banner .RD-img").width() / 655 * 375;
// 	$(".RD-banner .RD-img>img").height(indexedImgHgt04);
// 	//	个人中心视频图片
// 	var indexedImgHgt05 = 200 / 640 * 360;
// 	$(".per-tab-box .RANbox-list-xx>li:first-of-type img ").height(indexedImgHgt05);
// 	//	个人中心剧集图片
// 	var indexedImgHgt05 = 120 / 420 * 600;
// 	$(".per-tab-box .RANbox-list-xx.per-img>li:first-of-type img ").height(indexedImgHgt05);
//
// 	//	排行榜剧集图片
// 	var indexedImgHgt06 = 150 / 420 * 600;
// 	$(".RANbox-box02 .RANbox-list-xx>li:first-of-type img ").height(indexedImgHgt06);
// 	var indexedImgHgt07 = 120 / 420 * 600;
// 	$(".RAN-z-box01>li:nth-of-type(2) img ").height(indexedImgHgt07);
//
// 	//	视频列表图片
// 	var indexedImgHgt08 = $(".act .oth-list>li").width() / 640 * 360;
// 	$(".othSp>a>img").height(indexedImgHgt08);
// 	//	剧集列表图片
// 	var indexedImgHgt09 = $(".act .oth-list>li").width() / 420 * 600;
// 	$(".othJj>a>img").height(indexedImgHgt09);
//
// 	//窗口大小改变   首页图片高度统一
// 	window.onresize = function() {
// 		//	热点图片
// 		var indexedImgHgt01 = $(".RD-img").width() / 640 * 360 / 2;
// 		$(".RD-img>img").height(indexedImgHgt01);
// 		//	视频图片
// 		var indexedImgHgt02 = $(".HrBox-D").width() / 640 * 360;
// 		$(".HrBox-img").height(indexedImgHgt02);
// 		//	电影图片
// 		var indexedImgHgt03 = $(".Movie-list").width() / 420 * 600;
// 		$(".Movie-list .Movie-img").height(indexedImgHgt03);
// 		//	热点轮播图片
// 		var indexedImgHgt04 = $(".RD-banner .RD-img").width() / 655 * 375;
// 		$(".RD-banner .RD-img>img").height(indexedImgHgt04);
// 		//	视频列表图片
// 		var indexedImgHgt08 = $(".act .oth-list>li").width() / 640 * 360;
// 		$(".othSp>a>img").height(indexedImgHgt08);
// 		//	剧集列表图片
// 		var indexedImgHgt09 = $(".act .oth-list>li").width() / 420 * 600;
// 		$(".othJj>a>img").height(indexedImgHgt09);
// 	};
// });

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

// //他人主页
// $(document).ready(function() {
// 	//	关注按钮切换样式
// 	$('.oth-bth-box>input').click(function() {
// 		$(this).toggleClass("act").siblings("input").toggleClass("act");
// 	});
// });

//上传视频页
$(document).ready(function() {
	//	分类选择按钮tab切换样式
	$(".upl-rbtn").click(function() {
		var tabNum = $(this).index();
		$(this).addClass("act").siblings().removeClass("act");
		$(".pul-kong").hide();
		$(".upl-cbtn").removeClass("act");
		$(".upl-btn-tab-box>div").eq(tabNum).addClass("act").siblings().removeClass("act");
	});
	//	选择标签按钮切换样式
	$(".upl-cbtn").click(function() {
		var cbtnNum = $(".upl-cbtn.act").length;
		if(cbtnNum < 3) {
			$(this).toggleClass("act");
		} else {
			$(this).removeClass("act");
		}
	});
});

//上传剧集页
$(document).ready(function() {
	//	下拉菜单显示隐藏
	$(".upl-slt-text>input").click(function() {
		$('.upl-slt-text').removeClass("act");
		$('.upl-slt-list').removeClass("act");
		$(this).parents(".upl-slt-text").addClass("act").siblings(".upl-slt-list").addClass("act");

		$(document).click(function(e) {
			var $target = $(e.target);
			// 点击下拉菜单以外的地方切换样式
			if(!$target.is('.upl-slt *') && !$target.is('.upl-slt')) {
				$('.upl-slt-text').removeClass("act");
				$('.upl-slt-list').removeClass("act");
			}
		});
	});
	//	下拉菜单显示隐藏
	$(".upl-slt-list>input").click(function() {
		var uplText = $(this).val();
		$(this).parents(".upl-slt").find(".upl-slt-text>input").val(uplText);
		$(this).addClass("act").siblings("input").removeClass("act");
		$('.upl-slt-text').removeClass("act");
		$('.upl-slt-list').removeClass("act");
	});
	//	更新时间样式
	$(".upl-btn-list02>input").click(function() {
		$(this).toggleClass("act");
	});
});

//vip中心
$(document).ready(function() {
	//	tab切换样式   01
	$(".vip-top-tab>a").click(function() {
		var tabNum = $(this).index();
		$(this).addClass("act").siblings().removeClass("act");
		$(".vip-content>div").eq(tabNum).addClass("act").siblings().removeClass("act");
	});
	//	tab切换样式   02
	$(".vip-content-nav>li").click(function() {
		var tabNum02 = $(this).index();
		$(this).addClass("act").siblings().removeClass("act");
		$(".vip-content-box>div").eq(tabNum02).addClass("act").siblings().removeClass("act");
	});
	//	套餐选择切换样式
	$(".vip-tc>li").click(function() {
		$(this).addClass("act").siblings().removeClass("act");
	});
	//	支付地址选择
	$(".paybtn01>input").click(function() {
		$(".paybox").toggle();
		$(".vip-pay-xz").toggle();
		$(".vip-tc>li").addClass("no");
		$(".alt02-tabA>li").addClass("no");
		$(".pay-dz>li").click(function() {
			$(".vip-pay-xz .bnt-tow>input").removeAttr("disabled");
		});
	});
	//	上一步
	$(".vip-pay-xz .bnt-tow>.on").click(function() {
		$(".paybox").toggle();
		$(".vip-pay-xz").toggle();
		$(".vip-tc>li").toggleClass("no");
		$(".alt02-tabA>li").toggleClass("no");

	});
	$(".pay-dz>li").click(function() {
		$(this).addClass("act").siblings().removeClass("act");
	});
	//  新增/修改  地址
	$(".add-box").click(function() {
		$(".vip-pay-xz").toggle();
		$(".vip-pay-add").toggle();
	});
	$(".vip-pay-add .bnt-tow>input").click(function() {
		$(".vip-pay-xz").toggle();
		$(".vip-pay-add").toggle();
	});

	//	聚合支付 付款方式选择
	$(".alt02-tabA>li:nth-of-type(2)").click(function() {
		$(".paybox02-B").show();
		$(this).siblings().click(function() {
			$(".paybox02-B").hide();
		});
	});
	$(".paybox02-btn>input").click(function() {
		$(".paybox").toggle();
		$(".vip-pay-jh").toggle();
		$(".vip-tc>li").addClass("no");
		$(".alt02-tabA>li").addClass("no");
	});
	//为他充值  tab切换
	$(".cz-tab>li").click(function() {
		var tabNum03 = $(this).index();
		$(this).addClass("act").siblings().removeClass("act");
		$(".cz-tab-box>div").eq(tabNum03).addClass("act").siblings().removeClass("act");
	});
});

//广告中心
$(document).ready(function() {
	//	币种选择
	$(".ADcurrency>li>input").click(function() {
		$(this).addClass("act").parents("li").siblings().find("input").removeClass("act");
	});

	//  右侧定位锚点
	$(window).scroll(function() {
		//获取距离页面顶部的距离
		var toTop3 = document.documentElement.scrollTop || document.body.scrollTop;
		if(1250 > toTop3) {
			$(".AD-navR>a").addClass("act")
			$(".AD-navR>a:last-of-type").removeClass("act")
		};
		if(1250 < toTop3) {
			$(".AD-navR>a").removeClass("act")
			$(".AD-navR>a:last-of-type").addClass("act")
		};
	});

	//  弹出层用户协议
	$(".ADS").click(function() {
		var ADSact=$(this).siblings("input").attr("checked")
		if (ADSact=="checked") {
			$(this).toggleClass("act").siblings("input").removeAttr("checked");
		} else{
			$(this).toggleClass("act").siblings("input").attr("checked","checked");
		}
	});
	//广告注册
	// $("ul .bth-r").click(function() {
	// 	$("#alt08").show();
	// });
	$(".ADjsq").click(function() {
		$(this).siblings("li").click(function(){
			$(".AD-bow").show();
		});
		$(".AD-bow").hide();
	});
});

//密码隐藏显示
$(document).ready(function() {
	$(".eye").click(function() {
		var eyeOn=$(this).attr("class")
		if(eyeOn=="eye") {
			$(this).addClass("act");
			$(this).siblings(".inp").removeClass("pas").attr("type", "text");
		} else {
			$(this).removeClass("act");
			$(this).siblings(".inp").addClass("pas").attr("type", "password");
		}
	});
});

//登录弹出层
$(document).ready(function() {
	//登录注册tab
	$(".alt-logon .tab-nav>li").click(function() {
		var tabNum = $(this).index();
		$(this).addClass("act").siblings().removeClass("act");
		$(".alt-logon .tab-box>div").eq(tabNum).addClass("act").siblings().removeClass("act");
	});
	//自动登录切换样式
	$(".gn-box .chebox").click(function() {
		$(this).toggleClass("act");
	});
	//用户协议样式切换
	$(".bowbox .chebox").click(function() {
		$(this).toggleClass("act");
	});
	//假下拉菜单
	$(".alt-logon .selectJ").click(function() {
		$('.alt-logon .opJ').removeClass("act");
		$(this).siblings(".opJ").toggleClass("act");
		$(document).click(function(e) {
			var $target = $(e.target);
			// 点击下拉菜单以外的地方切换样式
			if(!$target.is('.alt-logon .sltJ *') && !$target.is('.alt-logon .opJ')) {
				$('.alt-logon .opJ').removeClass("act");
			}
		});
		$(".alt-logon .opJ>input[type='button']").click(function() {
			var selectVal=$(this).attr('data');
			$(this).addClass("act").siblings("input").removeClass("act");
			$(this).parents(".sltJ").find(".selectJ").addClass("act").val(selectVal);
			$("#reg_question").val(questionid);
			$('.alt-logon .opJ').removeClass("act");
		});
		$(".alt-logon .opJ>li").click(function() {
			var opJval=$(this).find("span").text();
			var selectVal=$(this).attr('data');
			$(this).addClass("act").siblings("li").removeClass("act");
			$(this).parents(".sltJ").find(".selectJ").addClass("act").val(selectVal);
			$(this).parents(".sltJ").find(".selectJ").attr('data',opJval);
			$('.alt-logon .opJ').removeClass("act");
		});
	});
	//点击注册,显示注册页面，关闭登录页面
	$('.J_c_register').click(function(){
		$('.J_alt_login').hide();
		$('.J_alt_register').show();
	});
	//注册页面返回,显示登录页面，注册页面关闭
	$('.J_alt_reback').click(function(){
		$('.J_alt_login').show();
		$('.J_alt_register').hide();
	});
});

//有关手机下拉
$(document).ready(function() {
	$(".J_select_country").click(function () {
		$(this).siblings(".J_opt_country").toggleClass("act");
		$(document).click(function (e) {
			var $target = $(e.target);
			// 点击下拉菜单以外的地方切换样式
			if (!$target.is('.J_account *') && !$target.is('.J_opt_country')) {
				$('.J_opt_country').removeClass("act");
			}
		});
		$(".J_opt_country>li").click(function () {
			var opJval = $(this).find("span").text();
			var selectVal = $(this).attr('data');
			$(this).addClass("act").siblings("li").removeClass("act");
			$(this).parents(".J_account").find(".J_select_country").addClass("act").val(selectVal);
			$(this).parents(".J_account").find(".J_select_country").attr("data", opJval);
			$(this).parent().removeClass("act");
		});
	});

	//安全中心修改手机号，邮箱和密码切换
	$('.J_per_edit_phone').click(function(){
		$(this).parents('.J_safe_list').removeClass("act").siblings('.J_ep').addClass("act");
	});
	$('.J_per_edit_email').click(function(){
		$(this).parents('.J_safe_list').removeClass("act").siblings('.J_email_box').addClass("act");
	});
	$('.J_per_edit_pass').click(function(){
		$(this).parents('.J_safe_list').removeClass("act").siblings('.J_edit_pass_box').addClass("act");
	});
	//忘记密码
	//第一步：忘记密码-第一步
	var is_click = true;
	$('.J_first_step').click(function () {
		if(!is_click){
			return false;
		}
		var account = "";
		var prefix_phone = "";
		var hide_account = "";
		var arr = {};
		account = $(this).parents(".J_step_one").find(".J_phone").val();
		prefix_phone = $(this).parents(".J_step_one").find(".J_select_country").attr("data");
		if (account == "") {
			$(".J_warning").text("账号不能为空");
			$(".J_warning").show();
			return false;
		}
		if (!isMobilePhone(account)) {
			$(".J_warning").text("账号格式错误");
			$(".J_warning").show();
			return false;
		}
		//跳转到第二步骤
		$(this).parents(".J_step_one").removeClass('act');
		$(this).parents(".J_safe_auth").find(".J_step_two").addClass('act');
		hide_account = prefix_phone+hideAccount(account);
		$(this).parents(".J_safe_auth").find(".J_step_two .J_hide_account").text(hide_account);
		//第二步：点击，发送短信，并跳转到短信验证码验证页面
		arr['mobile_areacode'] = prefix_phone;
		arr['mobile'] = account;
		is_click = false;
		$('.J_step_two').click(function () {
			var _this = $('.J_step_two');
			//补接口-发送验证码接口
			$.get('/video/send-code', arr, function (res) {
				is_click = true;
				console.log('忘记密码-发送验证码---',res);
				if(res.errno==0){
					//跳转到发送短信验证码页面
					_this.removeClass('act');
					_this.parents(".J_safe_auth").find(".J_step_two2").addClass('act');
					//赋值短信信息
					_this.parents(".J_safe_auth").find(".J_hide_account").text(hide_account);
					setTimeCode(_this.parents(".J_safe_auth").find(".J_count_down"));
				}else{
					$(".J_warning1").text("验证码发送失败");
					$(".J_warning1").show();
				}
			});
			//重新发送短信验证码
			$('.J_safe_auth').on("click",".J_send_code",function () {
				//补接口-发送验证码接口
				$.get('/video/send-code', arr, function (res) {
					var sc_this = $(".J_safe_auth .J_send_code");
					if (res.errno == 0) {
						setTimeCode(sc_this.parents(".J_safe_auth").find(".J_count_down"));
					} else {
						sc_this.parents(".J_safe_auth").find(".J_warning2").text("验证码发送失败");
						sc_this.parents(".J_safe_auth").find(".J_warning2").show();
					}
				});
			});
			//点击验证码验证
			var code = "";
			$('.J_second_step').click(function(){
				if(!is_click){
					return false;
				}
				var yzm_this = $('.J_second_step');
				code = yzm_this.parents(".J_step_two2").find(".J_yzm").val();
				if (code == "") {
					$(".J_warning2").text("验证码不能为空");
					$(".J_warning2").show();
					return false;
				}
				is_click = false;
				//补接口-对接短信验证接口
				arr['code'] = code;
				console.log('短信验证码校验参数---',arr);
				$.get('/video/vali-code', arr, function (res) {
					console.log('短信验证码校验结果---',res);
					is_click = true;
					if (res.errno == 0) {
						//跳转到找回密码页面
						yzm_this.parents(".J_step_two2").removeClass('act');
						yzm_this.parents(".J_safe_auth").find(".J_step_two3").addClass('act');
						//点亮第二步骤
						yzm_this.parents(".J_safe").find(".J_line2").addClass('act');
						yzm_this.parents(".J_safe").find(".J_jindu2").addClass('act');
						yzm_this.parents(".J_safe").find(".J_auth_text2").addClass('act');
					} else {
						$(".J_warning2").text("验证码不正确");
						$(".J_warning2").show();
					}
				});
			})
		});
		//第三步：重新设置密码
		var new_pass = ''
		var sure_pass = '';
		$(".J_three_step").click(function(){
			if(!is_click){
				return false;
			}
			var ts_this = $(".J_three_step");
			new_pass = ts_this.parents('.J_step_two3').find('.J_new_pass').val();
			sure_pass = ts_this.parents('.J_step_two3').find('.J_sure_pass').val();
			console.log(new_pass,sure_pass);
			if(new_pass == ''){
				$(".J_warning3").text("请输入新密码");
				$(".J_inp_box_warning").show();
				$(".J_warning3").show();
				return false;
			}
			if(sure_pass == ''){
				$(".J_warning3").text("请输入确认密码");
				$(".J_inp_box_warning").show();
				$(".J_warning3").show();
				return false;
			}
			if(sure_pass != new_pass){
				$(".J_warning3").text("两次输入密码不一致");
				$(".J_inp_box_warning").show();
				$(".J_warning3").show();
				return false;
			}
			is_click = false;
			//补接口-修改密码
			arr['newpwd'] = new_pass;
			console.log('更改密码参数---',arr);
			$.get('/video/modify-password', arr, function (res) {
				console.log('更改密码结果---',res);
				is_click = true;
				if(res.errno==0){
					//跳转到操作成功页面
					ts_this.parents(".J_step_two3").removeClass('act');
					ts_this.parents(".J_safe_auth").find(".J_step_three").addClass('act');
					//点亮第三步骤
					ts_this.parents(".J_safe").find(".J_line3").addClass('act');
					ts_this.parents(".J_safe").find(".J_jindu3").addClass('act');
					ts_this.parents(".J_safe").find(".J_auth_text3").addClass('act');
				}else{
					$(".J_warning3").text("密码修改失败");
					$(".J_warning3").show();
				}
			});
		})
	});

	//修改手机号-暂时不做
	//第一步：发送短信验证码-第一步
	is_click = true;
	$('.J_ep_step_one').click(function () {
		if(!is_click){
			return false;
		}
		var account = "";
		var prefix_phone = "";
		var hide_account = "";
		var arr = {};
		account = $(this).attr("data-phone");
		prefix_phone = $(this).attr("data-prefix_phone");
		arr['mobile_areacode'] = prefix_phone;
		arr['mobile'] = account;
		//补接口-发送验证码接口
		$.get('/video/send-code', arr, function (res) {
			is_click = true;
			if(res.errno==0){
				//跳转到发送短信验证码页面
				var _this = $('.J_ep_step_one');
				_this.removeClass('act');
				_this.parents(".J_ep_safe_auth").find(".J_ep_step_one1").addClass('act');
				//赋值短信信息
				_this.parents(".J_ep_safe_auth").find(".J_ep_hide_account").text(hide_account);
				setTimeCode(_this.parents(".J_ep_safe_auth").find(".J_ep_count_down"));
			}else{
				$(".J_ep_warning1").text("验证码发送失败");
				$(".J_ep_warning1").show();
			}
		});
		//验证旧手机号-验证码是否正确
		var code = "";
		$('.J_ep_one1_step').click(function(){
			if(!is_click){
				return false;
			}
			var yzm_this = $('.J_ep_one1_step');
			code = yzm_this.parents(".J_ep_step_one1").find(".J_ep_yzm").val();
			if (code == "") {
				$(".J_ep_warning2").text("验证码不能为空");
				$(".J_ep_warning2").show();
				return false;
			}
			is_click = false;
			//补接口-对接短信验证接口
			$.get('/video/search-watchlog', arr, function (res) {
				is_click = true;
				// if (res.errno == 0) {
				//跳转到填写新手机页面
				yzm_this.parents(".J_ep_step_one1").removeClass('act');
				yzm_this.parents(".J_ep_safe_auth").find(".J_ep_step_two").addClass('act');
				//点亮第二步骤
				yzm_this.parents(".J_ep_safe").find(".J_ep_line2").addClass('act');
				yzm_this.parents(".J_ep_safe").find(".J_ep_jindu2").addClass('act');
				yzm_this.parents(".J_ep_safe").find(".J_ep_auth_text2").addClass('act');
				// } else {
				// 	$(".J_warning2").text("验证码不正确");
				// 	$(".J_warning2").show();
				// }
			});
		})
		//第二步骤：填写新手机号码。并进行短信验证
		var new_account = $('.J_ep_phone').val()
		var new_prefix_phone = $(".J_ep_select_country").attr("data");
		arr['account'] = new_account;
		arr['prefix_phone'] = new_prefix_phone;
		$('.J_second_step').click(function () {
			var _this = $('.J_ep_step_two');
			//补接口-发送验证码接口
			$.get('/video/search-watchlog', arr, function (res) {
				is_click = true;
				// if(res.errno==0){
				//跳转到发送短信验证码页面
				_this.removeClass('act');
				_this.parents(".J_ep_safe_auth").find(".J_ep_step_two2").addClass('act');
				//赋值短信信息
				_this.parents(".J_ep_safe_auth").find(".J_ep_hide_account").text(hide_account);
				setTimeCode(_this.parents(".J_ep_safe_auth").find(".J_ep_count_down"));
				// }else{
				// 	$(".J_warning").text("验证码发送失败");
				// 	$(".J_warning").show();
				// }
			});
			//重新发送短信验证码
			$('.J_safe_auth').on("click",".J_send_code",function () {
				//补接口-发送验证码接口
				$.get('/video/search-watchlog', arr, function (res) {
					var sc_this = $(".J_ef_safe_auth .J_send_code");
					// if (res.errno == 0) {
					setTimeCode(sc_this.parents(".J_ep_safe_auth").find(".J_ep_count_down"));
					// } else {
					// 	sc_this.parents(".J_safe_auth").find(".J_warning2").text("验证码发送失败");
					// 	sc_this.parents(".J_safe_auth").find(".J_warning2").show();
					// }
				});
			});
		});
		//第二步：验证新手机号验证码是否正确，并进行绑定
		$('.J_ep_two2_step').click(function(){
			var yzm_this = $('.J_ep_two2_step');
			code = yzm_this.parents(".J_ep_step_tow2").find(".J_ep_yzm").val();
			//补接口-绑定新手机号
			$.get('/video/search-watchlog', arr, function (res) {
				// if (res.errno == 0) {
				//显示安全中心列表页
				yzm_this.parents(".J_ep_step_two2").removeClass('act');
				yzm_this.parents(".J_ep").removeClass('act');
				yzm_this.parents(".J_safe_list").addClass('act');
				//弹出提示框
				$("#pop-tip").text("手机号绑定成功");
				$("#pop-tip").show().delay(1500).fadeOut();
				// } else {
				// 	yzm_this.find(".J_warning2").text("验证码发送失败");
				// 	yzm_this.find(".J_warning2").show();
				// }
			});
		});
	});

	//绑定邮箱
	//第一步：发送短信验证码-第一步
	is_click = true;
	$('.J_email_send_code').click(function () {
		if(!is_click){
			return false;
		}
		var account = "";
		var prefix_phone = "";
		var hide_account = "";
		var arr = {};
		account = $(this).attr("data-phone");
		prefix_phone = $(this).attr("data-prefix_phone");
		//补接口-发送验证码接口
		arr['mobile'] = account;
		arr['mobile_areacode'] = prefix_phone;
		console.log(arr);
		$.get('/video/send-code', arr, function (res) {
			is_click = true;
			if(res.errno==0){
				//跳转到发送短信验证码页面
				var _this = $('.J_email_step_one');
				_this.removeClass('act');
				_this.parents(".J_email_safe_auth").find(".J_email_step_one1").addClass('act');
				//赋值短信信息
				_this.parents(".J_email_safe_auth").find(".J_email_hide_account").text(hide_account);
				setTimeCode(_this.parents(".J_email_safe_auth").find(".J_email_count_down"));
			}else{
				$(".J_email_warning1").text("验证码发送失败");
				$(".J_email_warning1").show();
			}
		});
		//重新发送短信验证码
		is_click = false;
		$('.J_email_safe_auth').on("click",".J_send_code",function () {
			is_click = true;
			console.log('重新发送参数--',arr);
			//补接口-发送验证码接口
			$.get('/video/send-code', arr, function (res) {
				console.log('重新发送结果--',res);
				var sc_this = $(".J_email_safe_auth .J_send_code");
				if (res.errno == 0) {
					setTimeCode(sc_this.parents(".J_email_step_one1").find(".J_email_count_down"));
				} else {
					sc_this.parents(".J_email_step_one1").find(".J_email_warning2").text(res.error);
					sc_this.parents(".J_email_step_one1").find(".J_email_warning2").show();
				}
			});
		});
		//验证手机号-验证码是否正确
		var code = "";
		$('.J_email_one1_step').click(function(){
			if(!is_click){
				return false;
			}
			var yzm_this = $('.J_email_one1_step');
			code = yzm_this.parents(".J_email_step_one1").find(".J_email_yzm").val();
			if (code == "") {
				$(".J_email_warning2").text("验证码不能为空");
				$(".J_email_warning2").show();
				return false;
			}
			is_click = false;
			//补接口-对接短信验证接口
			arr['code'] = code;
			$.get('/video/vali-code', arr, function (res) {
				is_click = true;
				if (res.errno == 0) {
					//跳转到填写新手机页面
					yzm_this.parents(".J_email_step_one1").removeClass('act').siblings('.J_email_step_two').addClass('act');
					//点亮第二步骤
					yzm_this.parents(".J_email_safe").find(".J_email_line2").addClass('act');
					yzm_this.parents(".J_email_safe").find(".J_email_jindu2").addClass('act');
					yzm_this.parents(".J_email_safe").find(".J_email_auth_text2").addClass('act');
				} else {
					$(".J_email_warning2").text("验证码不正确");
					$(".J_email_warning2").show();
				}
			});
		})
		//第二步骤：填写邮箱。并进行绑定或者修改
		$('.J_email_two_step').click(function () {
			var email = $('.J_email').val()
			arr['email'] = email;
			var _this = $('.J_email_two_step');
			//补接口-绑定邮箱
			console.log('绑定邮箱参数----',arr);
			$.get('/video/modify-email', arr, function (res) {
				console.log('绑定邮箱结果----',res);
				is_click = true;
				if(res.errno==0){
					//修改成功，显示安全中心列表页，隐藏当前页面
					_this.parents(".J_email_step_two").removeClass('act').siblings(".J_email_step_one").addClass('act');
					_this.parents(".J_email_box").removeClass('act').siblings(".J_safe_list").addClass('act');
					$(".J_is_bind_email").text(email);
					//弹出提示框
					$("#pop-tip").text("邮箱绑定成功");
					$("#pop-tip").show().delay(1500).fadeOut();
				}else{
					$(".J_email_warning").text("绑定失败");
					$(".J_email_warning").show();
				}
			});
		});
	});

	//修改密码
	//第一步：发送短信验证码-第一步
	is_click = true;
	$('.J_edp_step_one').click(function () {
		if(!is_click){
			return false;
		}
		var account = "";
		var prefix_phone = "";
		var hide_account = "";
		var arr = {};
		account = $(".J_ep_hide_account").attr("data-phone");
		prefix_phone = $(".J_ep_hide_account").attr("data-prefix_phone");
		arr['mobile_areacode'] = prefix_phone;
		arr['mobile'] = account;
		//补接口-发送验证码接口
		$.get('/video/send-code', arr, function (res) {
			is_click = true;
			if(res.errno==0){
				//跳转到发送短信验证码页面
				var _this = $('.J_edp_step_one');
				_this.removeClass('act');
				_this.parents(".J_edp_safe_auth").find(".J_edp_step_one1").addClass('act');
				//赋值短信信息
				_this.parents(".J_edp_safe_auth").find(".J_edp_hide_account").text(hide_account);
				setTimeCode(_this.parents(".J_edp_safe_auth").find(".J_edp_count_down"));
			}else{
				$(".J_edp_warning1").text("验证码发送失败");
				$(".J_edp_warning1").show();
			}
		});
		//验证验证码是否正确
		var code = "";
		$('.J_edp_one1_step').click(function(){
			if(!is_click){
				return false;
			}
			var yzm_this = $('.J_edp_one1_step');
			code = yzm_this.parents(".J_edp_step_one1").find(".J_edp_yzm").val();
			if (code == "") {
				$(".J_edp_warning2").text("验证码不能为空");
				$(".J_edp_warning2").show();
				return false;
			}
			is_click = false;
			//补接口-对接短信验证接口
			arr['code'] = code;
			$.get('/video/vali-code', arr, function (res) {
				is_click = true;
				if (res.errno == 0) {
					//跳转到安全中心页面
					yzm_this.parents(".J_edp_step_one1").removeClass('act');
					yzm_this.parents(".J_edp_safe_auth").find(".J_edp_step_two").addClass('act');
					//点亮第二步骤
					yzm_this.parents(".J_edp_safe").find(".J_edp_line2").addClass('act');
					yzm_this.parents(".J_edp_safe").find(".J_edp_jindu2").addClass('act');
					yzm_this.parents(".J_edp_safe").find(".J_edp_auth_text2").addClass('act');
				} else {
					$(".J_edp_warning2").text("验证码不正确");
					$(".J_edp_warning2").show();
				}
			});
		})
		//重新发送短信验证码
		is_click = false;
		$('.J_edp_safe_auth').on("click",".J_send_code",function () {
			is_click = true;
			console.log('重新发送参数--',arr);
			//补接口-发送验证码接口
			$.get('/video/send-code', arr, function (res) {
				console.log('重新发送结果--',res);
				var sc_this = $(".J_edp_safe_auth .J_send_code");
				if (res.errno == 0) {
					setTimeCode(sc_this.parents(".J_edp_step_one1").find(".J_edp_count_down"));
				} else {
					sc_this.parents(".J_edp_step_one1").find(".J_edp_warning2").text(res.error);
					sc_this.parents(".J_edp_step_one1").find(".J_edp_warning2").show();
				}
			});
		});
		//第二步骤：填写新密码
		var new_pass = ''
		var sure_pass = '';
		$(".J_edp_two_step").click(function(){
			if(!is_click){
				return false;
			}
			var ts_this = $(".J_edp_two_step");
			new_pass = $('.J_edp_new_pass').val();
			sure_pass = $('.J_edp_sure_pass').val();
			console.log(new_pass,sure_pass);
			if(new_pass == ''){
				$(".J_edp_warning3").text("请输入新密码");
				$(".J_edp_inp_box").show();
				$(".J_edp_warning3").show();
				return false;
			}
			if(sure_pass == ''){
				$(".J_edp_warning3").text("请输入确认密码");
				$(".J_edp_inp_box").show();
				$(".J_edp_warning3").show();
				return false;
			}
			if(sure_pass != new_pass){
				$(".J_edp_warning3").text("两次输入密码不一致");
				$(".J_edp_inp_box").show();
				$(".J_edp_warning3").show();
				return false;
			}
			is_click = false;
			//补接口-修改密码
			arr['newpwd'] = new_pass;
			console.log('更改密码参数---',arr);
			$.get('/video/modify-password', arr, function (res) {
				console.log('更改密码结果---',res);
				is_click = true;
				if(res.errno==0){
					//显示安全中心列表页
					ts_this.parents(".J_edp_step_two").removeClass('act').siblings(".J_edp_step_one").addClass('act');
					ts_this.parents(".J_edit_pass_box").removeClass('act').siblings(".J_safe_list").addClass('act');
					$(".J_is_bind_pass").html("已设置");
					//弹出提示框
					$("#pop-tip").text("密码修改成功");
					$("#pop-tip").show().delay(1500).fadeOut();
				}else{
					$(".J_edp_warning3").text("密码修改失败");
					$(".J_edp_inp_box").show();
					$(".J_edp_warning3").show();
				}
			});
		})
	});

	//电话号隐藏显示
	function hideAccount(account) {
		var account_length = account.length;
		var hide_account_length = account_length - 5;
		var xing = '';
		var hide_account = '';
		if (hide_account_length > 0) {
			for (var i = 0; i < hide_account_length; i++) {
				xing += '*';
			}
			hide_account = account.substr(0, 3) + xing + account.substr(-2);
		} else {
			hide_account = account;
		}
		return hide_account;
	}

	//60s倒计时实现逻辑
	var countdown = 60;
	function setTimeCode(obj) {
		if (countdown == 0) {
			obj.prop('disabled', false);
			obj.addClass('resend J_send_code');
			obj.text('重新发送');
			countdown = 60;//60秒过后button上的文字初始化,计时器初始化;
			clearTimeout(timer);
			return;
		} else {
			obj.prop('disabled', true);
			obj.removeClass('resend J_send_code');
			obj.text(countdown + "s后重新发送");
			countdown--;
		}
		var timer = setTimeout(function () {
			setTimeCode(obj)
		}, 1000) //每1000毫秒执行一次
	}
});
