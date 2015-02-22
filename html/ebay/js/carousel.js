/*	carousel
-------------------------------------------------------- */
$(function(){
	/* brand */
	$("#brand .carousel ul").carouFredSel({
		circular:false,		//tureでON
		infinite:true,		//tureでON
		auto:3000,			//falseでOFF
		items: {
			visible: 1,		//1画面に表示させる画像の数(1枚)
			width: 600,		//一枚の画像の幅
			height: 288		//一枚の画像の高さ
		},
		prev: {
			button	: "#brand-prev",
			key	: "left"
		},
		next: {
			button	: "#brand-next",
			key	: "right"
		}
	});
	/* shop */
	$("#shop .carousel .carousel-in").carouFredSel({
		circular:false,		//tureでON
		infinite:true,		//tureでON
		auto:3000,			//falseでOFF
		items: {
			visible: 1,		//1画面に表示させる画像の数(1枚)
			width: 600,		//一枚の画像の幅
			height: 700		//一枚の画像の高さ
		},
		prev: {
			button	: "#shop-prev",
			key	: "left"
		},
		next: {
			button	: "#shop-next",
			key	: "right"
		}
	});
});