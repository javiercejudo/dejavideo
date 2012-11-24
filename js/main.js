$(document).ready(function(){
	if ($('.novideo').length && $('.listing_container').length) {
		var breadcrumbDistanceTop = $('.novideo').position().top;
		var listingDistanceTop = $('.listing_container').position().top;
	}
	if($('.display_novideo').length) {
		if (window.location.hash === '#rtc') {
			var stillTime = 500;
			var transitionTime = 1500;
			$('.display_novideo').css({
				height: "+=800px"
			});
			$('.display_novideo').delay(stillTime).animate({
				height: "-=800px"
			}, transitionTime, function(){
				breadcrumbDistanceTop = $('.novideo').position().top;
				listingDistanceTop = $('.listing_container').position().top;
			});

			$('.title').css({
				marginTop: "100px"
			});
			$('.title').delay(stillTime).animate({
				marginTop: "0"
			}, transitionTime);
		}
	}

	$(window).on('resize', function(){
		if ($('.novideo').length && $('.listing_container').length) {
			breadcrumbDistanceTop = $('.novideo').position().top;
			listingDistanceTop = $('.listing_container').position().top;
		}
	});

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

	function toggle_fullscreen (main_video, time_correction) {
		if ($('.video-js').length) {
			if (time_correction > 0) {
				main_video.currentTime -= time_correction;
				clear_videojs_spinner();
			}
			var player = _V_("main_video");
			if (!player.isFullScreen) {
				player.requestFullScreen();
			} else {
				player.cancelFullScreen();
			}
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
		if ($('.novideo').length && $('.listing_container').length) {
			breadcrumbDistanceTop = $('.novideo').position().top;
			listingDistanceTop = $('.listing_container').position().top;
		}
		main_video.volume = 0; // will help us check if vol can be modified
		if (main_video.volume === 0) {
			main_video.volume = 1; // default vol
		} else {
			$(".vol").hide(); // if vol cannot be modified, hide vol controls
			if($('.vjs-control').length) {
				$(".vjs-volume-control, .vjs-mute-control").hide();
			}
		}
		var offset = 0;
		if (window.location.hash !== ''){
			offset = parseFloat(window.location.hash.substr(1));
		}
		var controls_fade_out_timeout;
		var ignoreHashChange = false;

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

		$('.vjs-controls').on('mousemove', function(){
			clear_fade_out_timeout(controls_fade_out_timeout);
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
				ignoreHashChange = true;
				window.location.hash = Math.floor(main_video.currentTime);
				if ($('.vjs-controls').length) {
					clear_fade_out_timeout(controls_fade_out_timeout);
					$('.vjs-controls').removeClass('vjs-fade-out').addClass('vjs-fade-in');
				}
			},
			seeking: function(){
				ignoreHashChange = true;
				window.location.hash = Math.floor(main_video.currentTime);
			},
			loadedmetadata: function(){
				if (offset > 0){
					setTimeout(function(){
						fadeIn_then_fadeOut();
						main_video.currentTime = offset;
						clear_videojs_spinner();
					}, 1000);
				}
			},
			mousemove: function(){
				// $('#main_video, #main_video_html5_api').css('cursor','auto');
				if ($('.vjs-controls').length) {
					clear_fade_out_timeout(controls_fade_out_timeout);
					controls_fade_out_timeout = fadeIn_then_fadeOut();
				}
			},
			dblclick: function(){
				toggle_fullscreen(main_video, .1);
			}
		});
		setInterval(function(){
			ignoreHashChange = true;
			window.location.hash = Math.floor(main_video.currentTime);
			checkIfPaused(main_video);
		}, 10000);

		$(window).on('hashchange', function(){
			if (window.location.hash !== ''){
				offset = parseFloat(window.location.hash.substr(1));
				if (offset > 0 && !ignoreHashChange) {
					main_video.currentTime = offset;
					clear_videojs_spinner();
				}
			}
			ignoreHashChange = false;
		});

		if(Modernizr.touch) {
			var hammer = new Hammer(main_video);
			hammer.ontransform = function(ev) {
				toggle_fullscreen(main_video, 0);
			};
			hammer.ontap = function(ev) {
				clear_fade_out_timeout(controls_fade_out_timeout);
				controls_fade_out_timeout = fadeIn_then_fadeOut();
			};
		}
	}

	if(!Modernizr.touch) {
		$(window).scroll(function(){
			if ($('.novideo').length && $('.listing_container').length) {
				if ($(window).scrollTop() >= breadcrumbDistanceTop) {
					$('.novideo').addClass('fixed');
				} else {
					$('.novideo').removeClass('fixed');
				}
			}
		});
	}
});