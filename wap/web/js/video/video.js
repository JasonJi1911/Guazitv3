$(function(){
	//banner
	var myBanner = new Swiper ('#video-list-banner', {
		loop: true, // 循环模式选项
		autoplay: 3000,
		autoplay: true,
		pagination: {
			el: '.swiper-pagination',
		},
	});
	myBanner.on('tap', function (swiper, e) {
		window.location.href = $("#video-list-banner .swiper-slide").eq(this.clickedIndex).attr('data-link');
	});
	//类别选择	
	var myType = new Swiper ('.video-select-box', {
		slidesPerView:'auto',
	 })  
	 //选集
/*	 var mySeries = new Swiper ('.video-detail-series-bottom', {
	 	slidesPerView : 'auto',
		// spaceBetween : 15,
	  })*/
	  //弹窗
	  $(document).on("click",".video-intro-btn",function(){
		   $(".pop-mask").show();
		   $(".video-pop-intro").css("bottom",0);
		   $("body").addClass("body-mode");
	  					   
	  }).on("click",".video-detail-series-btn",function(){
		   $(".pop-mask").show();
		   $(".video-pop-series").css("bottom",0);
		   $("body").addClass("body-mode");
	  }).on("click",".video-source-btn",function(){
		   $(".pop-mask").show();
		   $(".video-pop-source").css("bottom",0);
		   $("body").addClass("body-mode");
	  }).on("click",".pop-close-btn",function(){
		    $(".pop-mask").hide();
		  	$(".pop-video-mask").hide();
		    $(".pop-intro").css("bottom","-100%");
			$("body").removeClass("body-mode");
	  }).on("click",".pop-series-sort",function(){//正序
			var hasF=$(this).hasClass("fsort");
			if(hasF){
				$(this).text("正序");
				$(this).removeClass("fsort");
				$('.sort-asc').show();
				$('.sort-desc').hide();
			}else{
			   $(this).text("倒序");
			   $(this).addClass("fsort");
			   $('.sort-asc').hide();
			   $('.sort-desc').show();
		   }
	  })
	  //清空搜索历史
	  $(document).on("click",".history-delete",function(){
	  		$(".pop-mask").show();
	  		$(".pop-history").show();
	  		$("body").addClass("body-mode");
	  }).on("click",".history-btn-cancel",function(){
		  $(".pop-mask").hide();
		  $(".pop-history").hide();
		  $("body").removeClass("body-mode");
	  }).on("click",".history-btn-ok",function(){
		  localStorage.removeItem('novelKeywords');
		  $(".pop-mask").hide();
		  $(".pop-history").hide();
		  $("body").removeClass("body-mode");
		  $(".video-history-search").remove();
	  })
	  //搜索按钮切换
	$(document).on("input property",".search-input",function(){
		var sval=$(this).val();
		var $searchBtn=$(this).parents(".video-search-box").siblings(".search-btn-search");
		var $cancelBtn=$(this).parents(".video-search-box").siblings(".search-btn-cancel");
		var $close=$(this).siblings(".search-delete");
		if(sval==""){
			$searchBtn.hide();
			$cancelBtn.show();
			$close.removeClass("show");
		}else{
			$searchBtn.show();
			$cancelBtn.hide();
			$close.addClass("show");
		}
	}).on("click",".search-delete",function(){
		var $searchBtn=$(this).parents(".video-search-box").siblings(".search-btn-search");
		var $cancelBtn=$(this).parents(".video-search-box").siblings(".search-btn-cancel");
		$(this).removeClass("show");
		$(".search-input").val("").focus();
		$searchBtn.hide();
		$cancelBtn.show();
	})


	var is_click = false; //加锁，防止数据没更新，用户频繁点击
	//换一换
	$('.more-change').on('click', function() {
		var recommend_id = $(this).attr('data-recommend');
		if (is_click == true) {
			return;
		}
		is_click = true;

		//发送请求，获取数据
		$.get('/video/refresh', {recommend_id: recommend_id}, function(s) {
			var data = s.data;
			var content = '';
			for (var s=0; s<data.length; s++) { //拼接换一换内容
				content += "<dd>"+
					"<a href='/video/detail?video_id="+data[s]['video_id']+"'>"+
					"<div class='video-item-top'>"+
					"<img src="+data[s]['cover']+" alt=''>"+
					"<div class='mark-box'>"+
					"<p class='mark'>"+data[s]['flag']+"</p>"+
					"</div>"+
					"</div>"+
					"<h5 class='video-item-name'>"+data[s]['video_name']+"</h5>"+
					"<p class='video-item-play'>"+data[s]['play_times']+"</p>"+
					"</a>"+
					"</dd>"
			}
			$('.more-change-'+recommend_id).html(content); // 更新换一换内容
			is_click = false;
		})
	});

	$('.search-cont').click(function () {
		window.location.href = '/video/search';
	})

});

