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
		$('.title').delay(delaytime).animate({
			margin: "0"
		}, 500);
	}
	var main_video = $('#main_video')[0];
	$('.current').click(function(e) {
		main_video.currentTime -= 5;
	});
});