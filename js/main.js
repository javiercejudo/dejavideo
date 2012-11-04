$(document).ready(function(){
	if($('.display_novideo').length) {
		if (location.hash !== '#listing') {
			var delaytime = 500;
		} else {
			var delaytime = 0;
		}
		$('.display_novideo').delay(delaytime).animate({
			height: "-=575px"
		}, 500);
		$('.title_initial').remove();
		$('.title').delay(delaytime).animate({
			// opacity: "0",
			// left: "+=750",
			// width: "-=750",
			margin: "0"
		}, 500, function(){
			//$(this).css('display', 'none');
		});
	}
});