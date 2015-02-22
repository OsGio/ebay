
/*	mainvisual
-------------------------------------------------------- */
({
	counter:2,
	init:function(){
		var self = this;
		$(function(){
			if(!$.ua.isLtIE10) {
				setTimeout(function(){
					self.intro(1);
				},600);
			}else {
				$('body').addClass('letIe');
			}
		});
	},
	intro: function(num) {
		var self = this;
		var elm = $('#img_'+num);
		var time = 10;
		var timer = 300;
		elm.fadeIn(200);
		elm.removeClass('zoom');
		setTimeout(function() {
			if(num != 5) {
				$('#container').animate({left:-7},20).animate({top:-7},20).animate({left:7},20).animate({top:7},20).animate({left:0},20).animate({top:0},20);
			}else {
				$('#container').animate({left:-12},25).animate({top:-12},25).animate({left:12},25).animate({top:12},25).animate({left:-12},25).animate({top:-12},25).animate({left:12},25).animate({top:12},25).animate({left:0},25).animate({left:-5},25).animate({top:-5},25).animate({left:0},25).animate({top:0},{duration:25});
			}
			num++;
			if(num<=5) {
				if(num == 5) time = 800;
				setTimeout(function() {self.intro(num);},time);
			}
		},timer);
	}
}).init();


/*	smooth scroll
-------------------------------------------------------- */
var span = 1000;
var effect = 'easeOutSine';

$(function() {
	var ua = $.browser;
	$("nav a").click(function() {
		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
			$(this).blur();
			var t = navigator.appName.match(/Opera/) ? "html" : "html,body";
			$(t).queue([]).stop();
			var $targetElement = $(this.hash);
			var scrollTo = $targetElement.offset().top;
			if (window.scrollMaxY) {
				var maxScroll = window.scrollMaxY;
			} else {
				var maxScroll = document.documentElement.scrollHeight - document.documentElement.clientHeight;
			}
			if (scrollTo > maxScroll){
				scrollTo = maxScroll;
			}
			$(t).animate({ scrollTop: scrollTo }, span, effect);
			return false;
		}
	});
});


/*	rollover
-------------------------------------------------------- */
// preload
$(function(){
	$("a img").each(function(){
		if(String($(this).attr("src")).match(/_off\.(.*)$/)){
			var img = new Image();
			img.src = String($(this).attr("src")).replace(/_off\.(.*)$/,"_on.$1");
		}
	});
});

// rollover
$(function(){
	$('a img').hover(function(){
		$(this).attr('src',$(this).attr('src').replace('_off','_on'));
	},function(){
		$(this).attr('src',$(this).attr('src').replace('_on','_off'));
	});
});


/*	navigation
-------------------------------------------------------- */
$(function() {
	$('#mainvisual').bind('inview', function (event, visible, topOrBottomOrBoth) {
		if (visible == true) {
			if (topOrBottomOrBoth == 'bottom'){
				$("nav li").removeClass("current");
				$("nav #nv00").addClass("current");
			}
		}
	});

	$('#soy').bind('inview', function (event, visible, topOrBottomOrBoth) {
		if (visible == true) {
			if (topOrBottomOrBoth == 'top'){
				$("nav li").removeClass("current");
				$("nav #nv01").addClass("current");
			}
		}
	});

	$('#kaitori').bind('inview', function (event, visible, topOrBottomOrBoth) {
		if (visible == true) {
			if (topOrBottomOrBoth == 'top'){
				$("nav li").removeClass("current");
				$("nav #nv02").addClass("current");
			}
		}
	});

	$('#mypage').bind('inview', function (event, visible, topOrBottomOrBoth) {
		if (visible == true) {
			if (topOrBottomOrBoth == 'top'){
				$("nav li").removeClass("current");
				$("nav #nv03").addClass("current");
			}
		}
	});

	$('#voice').bind('inview', function (event, visible, topOrBottomOrBoth) {
		if (visible == true) {
			if (topOrBottomOrBoth == 'top'){
				$("nav li").removeClass("current");
				$("nav #nv04").addClass("current");
			}
		}
	});
	
	$('#flow').bind('inview', function (event, visible, topOrBottomOrBoth) {
		if (visible == true) {
			if (topOrBottomOrBoth == 'top'){
				$("nav li").removeClass("current");
				$("nav #nv05").addClass("current");
			}
		}
	});

	$('#faq').bind('inview', function (event, visible, topOrBottomOrBoth) {
		if (visible == true) {
			if (topOrBottomOrBoth == 'top'){
				$("nav li").removeClass("current");
				$("nav #nv06").addClass("current");
			}
		}
	});

	$('#advance').bind('inview', function (event, visible, topOrBottomOrBoth) {
		if (visible == true) {
			if (topOrBottomOrBoth == 'top'){
				$("nav li").removeClass("current");
				$("nav #nv07").addClass("current");
			}
		}
	});

});


/*	move effect
-------------------------------------------------------- */
$(function(){
	
	
	$("#soy .side h3").css({left:"-1000px", top:"-200px"});
	$("#oversea .side h3").css({left:"-1000px", top:"-200px"});
	$("#brand .side h3").css({left:"-1000px", top:"-200px"});
	$("#shop .side h3").css({left:"-1000px", top:"-200px"});
	$("#pro .side h3").css({left:"-1000px", top:"-200px"});
	$("#list .side h3").css({left:"-1000px", top:"-200px"});
	$("#check h3").css({left:"-1500px"});
	$("#vo1").css({left:"-1000px"});
	$("#vo2").css({left:"1422px"});
	$("#vo3").css({left:"-1000px"});
	$("#vo4").css({left:"1422px"});
	
	$('#soy .main h3').hide();
	$('#oversea .main h3').hide();
	$("#pro .main h3").css({left:"2000px"});
	
	/* soy arrow */
	$('#soy .side p').bind('inview', function (event, visible, topOrBottomOrBoth) {
		if (visible == true) {
			if (topOrBottomOrBoth == 'top') {
				// top part of element is visible
				$("#soy .side h3").animate({left:"0px", top:"10px"}, 1200, "easeOutExpo");
			} else if (topOrBottomOrBoth == 'bottom') {
				// bottom part of element is visible
			} else {
				// whole part of element is visible
			}
		} else {
			//$("#soy .side h3").animate({left:"1500px"}, 400, "easeInExpo");
		}
	});
	
	/* soy h3 */
	$('#soy .main p').bind('inview', function (event, visible, topOrBottomOrBoth) {
		if (visible == true) {
			if (topOrBottomOrBoth == 'top') {
				// top part of element is visible
				$('#soy .main h3').fadeIn(500,"linear");
			} else if (topOrBottomOrBoth == 'bottom') {
				// bottom part of element is visible
			} else {
				// whole part of element is visible
			}
		} else {
			//$("#list .side h3").animate({left:"1500px"}, 400, "easeInExpo");
		}
	});
	
	/* oversea arrow */
	$('#oversea .side p').bind('inview', function (event, visible, topOrBottomOrBoth) {
		if (visible == true) {
			if (topOrBottomOrBoth == 'top') {
				// top part of element is visible
				$("#oversea .side h3").animate({left:"0px", top:"10px"}, 1200, "easeOutExpo");
			} else if (topOrBottomOrBoth == 'bottom') {
				// bottom part of element is visible
			} else {
				// whole part of element is visible
			}
		} else {
			//$("#oversea .side h3").animate({left:"1500px"}, 400, "easeInExpo");
		}
	});
	
	/* oversea h3 */
	$('#oversea .main p').bind('inview', function (event, visible, topOrBottomOrBoth) {
		if (visible == true) {
			if (topOrBottomOrBoth == 'top') {
				// top part of element is visible
				$('#oversea .main h3').fadeIn(500,"linear");
			} else if (topOrBottomOrBoth == 'bottom') {
				// bottom part of element is visible
			} else {
				// whole part of element is visible
			}
		} else {
			//$("#list .side h3").animate({left:"1500px"}, 400, "easeInExpo");
		}
	});
	
	/* brand arrow */
	$('#brand .side p').bind('inview', function (event, visible, topOrBottomOrBoth) {
		if (visible == true) {
			if (topOrBottomOrBoth == 'top') {
				// top part of element is visible
				$("#brand .side h3").animate({left:"0px", top:"10px"}, 1200, "easeOutExpo");
			} else if (topOrBottomOrBoth == 'bottom') {
				// bottom part of element is visible
			} else {
				// whole part of element is visible
			}
		} else {
			//$("#brand .side h3").animate({left:"1500px"}, 400, "easeInExpo");
		}
	});
	
	/* shop arrow */
	$('#shop .side p').bind('inview', function (event, visible, topOrBottomOrBoth) {
		if (visible == true) {
			if (topOrBottomOrBoth == 'top') {
				// top part of element is visible
				$("#shop .side h3").animate({left:"0px", top:"10px"}, 1200, "easeOutExpo");
			} else if (topOrBottomOrBoth == 'bottom') {
				// bottom part of element is visible
			} else {
				// whole part of element is visible
			}
		} else {
			//$("#shop .side h3").animate({left:"1500px"}, 400, "easeInExpo");
		}
	});
	
	/* pro arrow */
	$('#pro .side p').bind('inview', function (event, visible, topOrBottomOrBoth) {
		if (visible == true) {
			if (topOrBottomOrBoth == 'top') {
				// top part of element is visible
				$("#pro .side h3").animate({left:"0px", top:"10px"}, 1200, "easeOutExpo");
			} else if (topOrBottomOrBoth == 'bottom') {
				// bottom part of element is visible
			} else {
				// whole part of element is visible
			}
		} else {
			//$("#pro .side h3").animate({left:"1500px"}, 400, "easeInExpo");
		}
	});
	
	/* pro h3 */
	$('#pro .side p').bind('inview', function (event, visible, topOrBottomOrBoth) {
		if (visible == true) {
			if (topOrBottomOrBoth == 'top') {
				// top part of element is visible
				$("#pro .main h3").animate({left:"81px"}, 1200, "easeOutExpo");
			} else if (topOrBottomOrBoth == 'bottom') {
				// bottom part of element is visible
			} else {
				// whole part of element is visible
			}
		} else {
			//$("#list .side h3").animate({left:"1500px"}, 400, "easeInExpo");
		}
	});
	
	/* list arrow */
	$('#list .side p').bind('inview', function (event, visible, topOrBottomOrBoth) {
		if (visible == true) {
			if (topOrBottomOrBoth == 'top') {
				// top part of element is visible
				$("#list .side h3").animate({left:"0px", top:"10px"}, 1200, "easeOutExpo");
			} else if (topOrBottomOrBoth == 'bottom') {
				// bottom part of element is visible
			} else {
				// whole part of element is visible
			}
		} else {
			//$("#list .side h3").animate({left:"1500px"}, 400, "easeInExpo");
		}
	});
	
	/* check h3 */
	$('#check p').bind('inview', function (event, visible, topOrBottomOrBoth) {
		if (visible == true) {
			if (topOrBottomOrBoth == 'top') {
				// top part of element is visible
				$("#check h3").animate({left:"0px"}, 1200, "easeOutExpo");
			} else if (topOrBottomOrBoth == 'bottom') {
				// bottom part of element is visible
			} else {
				// whole part of element is visible
			}
		} else {
			//$("#list .side h3").animate({left:"1500px"}, 400, "easeInExpo");
		}
	});
	
	/* voicelist */
	$('#voicelist').bind('inview', function (event, visible, topOrBottomOrBoth) {
		if (visible == true) {
			if (topOrBottomOrBoth == 'top') {
				// top part of element is visible
				$("#vo1").animate({left:"0px"}, 1000, "easeOutSine");
				$("#vo2").animate({left:"481px"}, 1200, "easeOutSine");
				$("#vo3").animate({left:"0px"}, 1400, "easeOutSine");
				$("#vo4").animate({left:"481px"}, 1600, "easeOutSine");
			} else if (topOrBottomOrBoth == 'bottom') {
				// bottom part of element is visible
			} else {
				// whole part of element is visible
			}
		} else {
			//$("#list .side h3").animate({left:"1500px"}, 400, "easeInExpo");
		}
	});

});





