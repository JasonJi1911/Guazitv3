//旋转木马
;(function($, window, document, undefined) {
	var Carousel = function(elem, options) {
			var self = this;
			this.defaults = {
				curDisplay: 0,
				autoPlay: false,
				interval: 3000
			};
			this.opts = $.extend({}, this.defaults, options);
			this.$carousel = elem;
			this.$aImg = this.$carousel.find("img");
			this.imgLen = this.$aImg.length;
			this.curDisplay = this.opts.curDisplay;
			this.autoPlay = this.opts.autoPlay;
			this.viewWidth = $(window).width() / 2;
			this.b_switch = true;
			this.iNow = this.opts.curDisplay;
			this.timer = null;
			this.interval = this.opts.interval;
			this.$aNav = this.$carousel.find(".carousel-nav").find("li");
		};

	var _height = 120;
	var _slideHeight = 120;

	Carousel.prototype = {
		play: function() {
			if (this.autoPlay) {
				if (this.iNow === this.imgLen - 1) {
					this.iNow = 0;
				} else {
					this.iNow++;
				}

				this.movingNext(this.iNow);
			}
		},

		movingPrev: function(index) {
			this.curDisplay = index;
			this.initalCarousel();
		},

		movingNext: function(index) {
			this.curDisplay = index;
			this.initalCarousel();
		},

		initalCarousel: function() {
			var self = this;
			var half_imgLen = Math.floor(this.imgLen / 2);
			var leftNum, rightNum;

			var k = 0;
			for (var i = 0; i < half_imgLen; i++) {
				leftNum = this.curDisplay - i - 1;
				if (k == 0) {
					this.$aImg.eq(leftNum).css({
						transform: 'translateX(' + (-90 * (i + 1)) + 'px) translateZ(-90px) rotateY(25deg)'
					}).animate({
						height: _slideHeight + 'px',
						marginTop: -_slideHeight / 2 + 'px',
						opacity: '0.6'
					}, 500);
					this.$aImg.eq(leftNum).attr('onclick', null);

					rightNum = this.curDisplay + i + 1;
					if (rightNum > this.imgLen - 1) rightNum -= this.imgLen;
					this.$aImg.eq(rightNum).css({
						transform: 'translateX(' + (90 * (i + 1)) + 'px) translateZ(-90px) rotateY(-25deg)'
					}).animate({
						height: _slideHeight + 'px',
						marginTop: -_slideHeight / 2 + 'px',
						opacity: '0.6'
					}, 500);
					this.$aImg.eq(rightNum).attr('onclick', null);
					k++;
				} else {
					this.$aImg.eq(leftNum).css({
						transform: 'translateX(0px) translateZ(-1000px) rotateY(25deg)'
					});

					rightNum = this.curDisplay + i + 1;
					if (rightNum > this.imgLen - 1) rightNum -= this.imgLen;
					this.$aImg.eq(rightNum).css({
						transform: 'translateX(0px) translateZ(-1000px) rotateY(-25deg)'
					});
				}
				this.$aImg.removeClass('on');
				this.$aNav.removeClass('on');
			}

			var _href = 'location.href=' + "'" + this.$aImg.eq(this.curDisplay).attr('data-url') + "'";
			this.$aImg.eq(this.curDisplay).css({
				transform: 'translateZ(0px)'
			}).animate({
				height: _height + 'px',
				marginTop: -_height / 2 + 'px',
				opacity: '1',
			}, 500).addClass('on').attr('onclick', _href);
			this.$aNav.eq(this.curDisplay).addClass('on');

			this.$carousel.on('webkitTransitionEnd', function() {
				self.b_switch = true;
			});
		},

		inital: function() {
			var self = this;

			this.initalCarousel();

			this.$aImg.on('click', function(ev) {
				if (self.b_switch && !$(this).hasClass('on')) {
					self.iNow = $(this).index();
					self.b_switch = false;

					var direction = self.viewWidth < ev.clientX ? 'next' : 'prev';
					var index = $(this).index();

					if (direction === 'next') {
						self.movingNext(index);
					} else {
						self.movingPrev(index);
					}
				}
			}).hover(function() {
				clearInterval(self.timer);
			}, function() {
				self.timer = setInterval(function() {
					self.play();
				}, self.interval);
			});
			this.$aNav.on('click', function(ev) {
				if (self.b_switch && !$(this).hasClass('on')) {
					self.iNow = $(this).index();
					self.b_switch = false;

					var direction = self.viewWidth < ev.clientX ? 'next' : 'prev';
					var index = $(this).index();

					if (direction === 'next') {
						self.movingNext(index);
					} else {
						self.movingPrev(index);
					}
				}
			}).hover(function() {
				clearInterval(self.timer);
			}, function() {
				self.timer = setInterval(function() {
					self.play();
				}, self.interval);
			});

			this.timer = setInterval(function() {
				self.play();
			}, this.interval);

			this.$carousel.on('selectstart', function() {
				return false;
			});
		},
		constructor: Carousel
	};

	$.fn.carousel = function(options) {
		var carousel = new Carousel(this, options);
		return carousel.inital();
	};

})(jQuery, window, document, undefined);