$(document).ready(function(){
	if($('.display_novideo').length) {
		if (location.hash !== '#listing') {
			var delaytime = 200;
		} else {
			var delaytime = 0;
			// $('.display_container').css({
			// 	marginTop: "-=450px"
			// });
		}
		$('.display_novideo').delay(delaytime).animate({
			height: "-=450px"
		}, 600);
		$('.title').delay(delaytime).animate({
			opacity: "0",
			left: "+=750",
			width: "-=750",
			top: "-=450px"
		}, 800, function(){
			$(this).css('display', 'none');
		});
	}
});