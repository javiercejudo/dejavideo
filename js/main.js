$(document).ready(function(){
	if($('.display_novideo').length) {
		// if (location.hash !== '#listing') {
			$('.display_novideo').animate({
				height: "-=450px"
			}, 600);
			$('.title').animate({
				opacity: "0",
				left: "+=750",
				width: "-=750",
				top: "-=450px"
			}, 800, function(){
				$(this).css('display', 'none');
			});
		// } else {
		// 	$('.display_container').css({
		// 		marginTop: "-=450px"
		// 	});
		// }
	}
});