$(document).ready(function(){
	// if($('.display_novideo').length) {
	// 	if (location.hash !== '#listing') {
	// 		var delaytime = 500;
	// 	} else {
	// 		var delaytime = 0;
	// 	}

	// 	$('.display_novideo').css({
	// 		height: "+=800px"
	// 	});
	// 	$('.display_novideo').delay(delaytime).animate({
	// 		height: "-=800px"
	// 	}, 500);

	// 	$('.title').css({
	// 		marginTop: "100px"
	// 	});
	// 	$('.title').delay(delaytime).animate({
	// 		marginTop: "0"
	// 	}, 500);
	// }

	function get_main_video_prop () {
		if ($('#main_video_html5_api').length) {
			var main_video = $('#main_video_html5_api');
		} else if ($('#main_video').length) {
			var main_video = $('#main_video');
		}
		return main_video;
	}

	function get_main_video (main_video_prop) {
		if (main_video_prop !== undefined) {
			return main_video_prop[0];
		}
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

	function clear_fade_out_timeout(controls_fade_out_timeout) {
		if(controls_fade_out_timeout !== undefined) {
			clearTimeout(controls_fade_out_timeout);
		}
	}

	function fadeIn_then_fadeOut() {
		if (!$('.vjs-controls').hasClass('vjs-fade-in')) {
			$('.vjs-controls').removeClass('vjs-fade-out').addClass('vjs-fade-in');
		}
		return setTimeout(function(){
			$('.vjs-controls').removeClass('vjs-fade-in').addClass('vjs-fade-out');
		}, 1000);
	}

	main_video_prop = get_main_video_prop();
	main_video = get_main_video(main_video_prop);

	if (main_video !== undefined) {
		$(".custom_controls").show();
		if (Modernizr.touch) {
			$(".ctrl_vol").hide();
		}
		var offset = 0;
		if (location.hash !== ''){
			offset = parseFloat(location.hash.substr(1));
		}
		main_video.volume = .8;
		var controls_fade_out_timeout;

		$('.ctrl_lll').on('click', function(e) {
			main_video.currentTime -= 60;
			clear_videojs_spinner();
		});

		$('.ctrl_ll').on('click', function(e) {
			main_video.currentTime -= 10;
			clear_videojs_spinner();
		});

		$('.ctrl_l').on('click', function(e) {
			main_video.currentTime -= 3;
			clear_videojs_spinner();
		});

		$('.vol_d').on('click', function(e) {
			clear_fade_out_timeout(controls_fade_out_timeout);
			if(main_video.volume - .1 > 0) main_video.volume -= .1;
			else main_video.volume = 0;
			controls_fade_out_timeout = fadeIn_then_fadeOut();
		});

		$('.ctrl_pp').on('click', function(e) {
			if (main_video.paused) main_video.play();
			else main_video.pause();
			clear_videojs_spinner();
		});

		$('.vol_i').on('click', function(e) {
			clear_fade_out_timeout(controls_fade_out_timeout);
			if(main_video.volume + .1 < 1) main_video.volume += .1;
			else main_video.volume = 1;
			controls_fade_out_timeout = fadeIn_then_fadeOut();
		});

		$('.ctrl_r').on('click', function(e) {
			main_video.currentTime += 3;
			clear_videojs_spinner();
		});

		$('.ctrl_rr').on('click', function(e) {
			main_video.currentTime += 10;
			clear_videojs_spinner();
		});

		$('.ctrl_rrr').on('click', function(e) {
			main_video.currentTime += 60;
			clear_videojs_spinner();
		});

		main_video_prop.on('mousemove', function(){
			clear_fade_out_timeout(controls_fade_out_timeout);
			controls_fade_out_timeout = fadeIn_then_fadeOut();
		});

		$('.vjs-controls').on('mousemove', function(){
			clear_fade_out_timeout(controls_fade_out_timeout);
		});

		main_video_prop.on('dblclick', function(){
			if ($('.video-js').length) {
				main_video.currentTime -= .1;
				clear_videojs_spinner();
				var player = _V_("main_video");
				if (!player.isFullScreen) {
					player.requestFullScreen();
				} else {
					player.cancelFullScreen();
				}
			}
		});

		main_video_prop.on({
			play: function(){
				checkIfPaused(main_video);
				if ($('.vjs-controls').length) {
					$('.vjs-controls').removeClass('vjs-fade-in').addClass('vjs-fade-out');
				}
			},
			pause: function(){
				checkIfPaused(main_video);
				if ($('.vjs-controls').length) {
					clear_fade_out_timeout(controls_fade_out_timeout);
					$('.vjs-controls').removeClass('vjs-fade-out').addClass('vjs-fade-in');
				}
			},
			seeking: function(){
				location.hash = Math.floor(main_video.currentTime);
			},
			loadedmetadata: function(){
				if (offset > 0){
					setTimeout(function(){
						fadeIn_then_fadeOut();
						main_video.currentTime = offset;
						clear_videojs_spinner();
					}, 1000);
				}
			}
		});

		setInterval(function(){
			location.hash = Math.floor(main_video.currentTime);
			checkIfPaused(main_video);
		}, 5000);
	}
});