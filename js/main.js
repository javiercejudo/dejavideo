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

	function get_main_video_prop () {
		if ($('#main_video_html5_api').length) {
			var main_video = $('#main_video_html5_api');
		} else if ($('#main_video').length) {
			var main_video = $('#main_video');
		}
		return main_video;
	}

	function get_main_video (main_video_prop) {
		return main_video_prop[0];
	}

	function clear_videojs_spinner() {
		if ($('.vjs-loading-spinner').length) {
			setTimeout(function(){
				$('.vjs-loading-spinner').hide();
			}, 100);
		}
	}

	function checkIfPaused (main_video) {
		if (main_video.paused) {
			$('.ctrl_pp').text('play');
		} else {
			$('.ctrl_pp').text('pause');
		}
	}

	main_video_prop = get_main_video_prop();
	main_video = get_main_video(main_video_prop);

	if (main_video !== undefined) {
		$('.ctrl_lll').click(function(e) {
			main_video.currentTime -= 60;
			clear_videojs_spinner();
		});

		$('.ctrl_ll').click(function(e) {
			main_video.currentTime -= 10;
			clear_videojs_spinner();
		});

		$('.ctrl_l').click(function(e) {
			main_video.currentTime -= 3;
			clear_videojs_spinner();
		});

		$('.ctrl_pp').on('click', function(e) {
			if (main_video.paused) {
				main_video.play();
			} else {
				main_video.pause();
			}
			clear_videojs_spinner();
		});

		$('.ctrl_r').click(function(e) {
			main_video.currentTime += 3;
			clear_videojs_spinner();
		});

		$('.ctrl_rr').click(function(e) {
			main_video.currentTime += 10;
			clear_videojs_spinner();
		});

		$('.ctrl_rrr').click(function(e) {
			main_video.currentTime += 60;
			clear_videojs_spinner();
		});

		main_video_prop.on({
			play: function(){
				checkIfPaused(main_video);
			},
			pause: function(){
				checkIfPaused(main_video);
			}
		});
	}
});