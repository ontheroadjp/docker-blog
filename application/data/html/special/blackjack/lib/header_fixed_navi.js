
/**
/* http://www.webopixel.net/javascript/538.html
**/

$(function() {
	var nav = $('.nav');
	var social_buttons = $('.social_buttons');

	//表示開始位置
	var navTop = nav.offset().top+300;

	//ナビゲーションの高さ（シャドウの分だけ足してます）
	var navHeight = nav.height()+10;
	var showFlug = false;
	nav.css('top', -navHeight+'px');

	$(window).scroll(function () {
		var winTop = $(this).scrollTop();

		//ナビゲーションの位置まできたら表示
		if (winTop >= navTop) {
			if (showFlug == false) {
				showFlug = true;
				nav
					.addClass('fixed')
					.stop().animate({'top' : '0px'}, 200);
				social_buttons
					.removeClass('social_buttons')
					.addClass('fixed_social_buttons');
			}

		//ナビゲーションの位置まできたら非表示
		} else if (winTop <= navTop) {
			if (showFlug) {
				showFlug = false;
				nav.stop().animate({'top' : -navHeight+'px'}, 200, function(){
					nav.removeClass('fixed');
					social_buttons
						.removeClass('fixed_social_buttons')
						.addClass('social_buttons');

				});
			}
		}
	});
});
