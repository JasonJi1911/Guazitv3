P = new Page();

function Page() {
	this.config = {
		elemId: "#page",
		pageIndex: "1",
		total: "0",
		pageNum: "12",
		pageSize: "10"
	};
	this.version = "1.0";
	this.requestFunction = null;
	this.initMathod = function(a) {
		$.extend(this.config, a.params);
		this.requestFunction = a.requestFunction;
		this.renderPage();
	};
	this.renderPage = function() {
		this.requestFunction();
		this.pageHtml();
		/*
		$(P.config.elemId).on("click", "a", function() {
			var a = $(this).parent().hasClass("disabled");
			if(a) {
				return false
			}
			var b = $(this).data("pageindex");
			P.config.pageIndex = b;
			P.requestFunction();
			P.pageHtml()
		})*/
	};
	this.pageHtml = function() {
		var a = this.config;
		if(parseInt(a.total) <= 0) {
			return false
		}
		var b = a.elemId;
		var h = isBlank(a.pageNum) ? 7 : parseInt(a.pageNum);
		var l = isBlank(a.pageSize) ? 10 : parseInt(a.pageSize);
		var n = parseInt(a.total);
		var m = n % l != 0 ? parseInt(n / l) + 1 : parseInt(n / l);
		var g = m < parseInt(a.pageIndex) ? m : parseInt(a.pageIndex);
		var d = m < h ? m : h;
		var e = g < parseInt((d / 2) + 1) ? -1 * (g - 1) : g > (m - parseInt(d / 2)) ? -1 * (d - (m - g) - 1) : -1 * parseInt((d / 2));
		var f = "<ul>";
		if(g <= 0 || g == 1) {
			f += '<li class="disabled"><a class="videobtn" href="javascript:;" data-type="page_num" data-value="' + g + '" data-pageindex="' + g + '">首页</a></li><li class="disabled"><a class="videobtn" href="javascript:;" data-type="page_num" data-value="' + g + '" data-pageindex="' + g + '">上一页</a></li>'
		} else {
			f += '<li><a class="videobtn" href="javascript:;" data-type="page_num" data-value="1" data-pageindex="1">首页</a></li><li><a class="videobtn" href="javascript:;" data-type="page_num" data-value="' + (g - 1) + '" data-pageindex="' + (g - 1) + '">上一页</a></li>'
		}
		for(var c = e; c < (e + d); c++) {
			if(m == (g + c - 1)) {
				break
			}
			if(c == 0) {
				f += '<li class="active"><a class="videobtn" href="javascript:;" data-type="page_num" data-value="' + g + '" data-pageindex="' + g + '">' + g + "</a></li>"
			} else {
				f += '<li><a class="videobtn" href="javascript:;" data-type="page_num" data-value="' + (g + c) + '" data-pageindex="' + (g + c) + '">' + (g + c) + "</a></li>"
			}
		}
		if(m == 1 || m <= g) {
			f += '<li class="disabled"><a class="videobtn" href="javascript:;" data-type="page_num" data-value="' + m + '" data-pageindex="' + m + '">下一页</a></li><li class="disabled"><a class="videobtn" href="javascript:;" data-type="page_num" data-value="' + m + '" data-pageindex="' + m + '">末页</a></li>'
		} else {
			f += '<li><a class="videobtn" href="javascript:;" data-type="page_num" data-value="' + (g + 1) + '" data-pageindex="' + (g + 1) + '">下一页</a></li><li><a class="videobtn" href="javascript:;" data-type="page_num" data-value="' + m + '" data-pageindex="' + m + '">末页</a></li>'
		}
		f += "</ul>";
		$(b).html("");
		$(b).html(f)
	}
}

function isBlank(a) {
	if(a == undefined || a == null || a.trim() == "") {
		return true
	}
	return false
};