$(document).ready(function(){
	// $.timeago.settings.strings = {
	//   prefixAgo: null,
	//   prefixFromNow: null,
	//   suffixAgo: "ago",
	//   suffixFromNow: "from now",
	//   seconds: "less than a minute",
	//   minute: "a minute",
	//   minutes: "%d minutes",
	//   hour: "an hour",
	//   hours: "%d hours",
	//   day: "a day",
	//   days: "%d days",
	//   month: "a month",
	//   months: "%d months",
	//   year: "a year",
	//   years: "%d years",
	//   wordSeparator: " ",
	//   numbers: []
	// };
	$("abbr.timeago").timeago();

	if ($('#listing').length) {
		$('#listing').css('opacity', '1');
	}

	function checkSupportedVideosLinks (linkType) {
		$('.' + linkType).each(function(i) {
			var mimeType = $(this).data('mimeType');
			console.log(mimeType);
			if (!Modernizr.video
				|| mimeType === "video/mp4"  && !Modernizr.video.h264
				|| mimeType === "video/webm" && !Modernizr.video.webm
				|| mimeType === "application/ogg"  && !Modernizr.video.ogg
				|| (mimeType !== "video/mp4" && mimeType !== "video/webm" && mimeType !== "application/ogg")
			) {
				$(this).addClass('unsupported');
				$(this).find('.title-link').attr('href', 'javascript:;').css('cursor', 'text');
			}
		});
	}

	checkSupportedVideosLinks('file');

	if ($('.display_novideo').length) {
		if (false && window.location.hash === '#rtc') {
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

	if ($('.novideo').length && $('.listing_container').length) {
		var breadcrumbDistanceTop = $('.novideo').position().top;
		var listingDistanceTop = $('.listing_container').position().top;
	}
	
	function update_recent(setup) {
		setup = (typeof setup === "undefined") ? false : true;
		if ($('.novideo').length && $('.listing_container').length) {
			$.ajax({
				type: "GET",
				url: "ajax/recent_files.php",
				data: { path: $('#current_dir').val() }
			}).done(function( result ) {
				setTimeout(function(){
					if ($('#loading_tag').length) {
						$('#loading_tag').remove();	
					}
					if ($('.replaceable').length) {
						$('.replaceable').remove();	
					}
					$('#recent_tag').after(result);
					checkSupportedVideosLinks('file_recent');
				}, 250);
				if (setup) {
					setTimeout(function(){
						$("#top_recent").on("selectstart", function(e) {
							e.preventDefault();
							return false;
						});
						$("#top_recent a").on("dragstart", function() {
					        return false;
					    });
						var hammer = new Hammer($("#top_recent")[0], {
							'prevent_default' : false,
							'drag_min_distance' : 0
						});
						var current_marginLeft = $('#top_recent').css('marginLeft');
						$('#top_recent').css('display','inline');
						var total_width_a = $('#top_recent').outerWidth();
						$('#top_recent').css('display','block');
						var total_width_b = document.getElementById('top_recent').scrollWidth;
						var total_width = Math.min(total_width_a, total_width_b);
						hammer.ondrag = function(ev) {
							if (parseInt(current_marginLeft.slice(0,-2), 10) + ev.distanceX < 0) {
								if (total_width > -parseInt($('#top_recent').css('marginLeft').slice(0,-2), 10) + 200
									|| ev.direction == 'right') {
									$('#top_recent')
										.css('marginLeft', current_marginLeft)
										.css('marginLeft', '+=' + ev.distanceX);
								} else {
									$('#top_recent')
										.css('marginLeft', parseInt(-total_width + 200, 10) + 'px');
								}
							} else {
								$('#top_recent').css('marginLeft', '0');
							}
						};
						hammer.ondragend = function(ev) {
							current_marginLeft = $('#top_recent').css('marginLeft');
						};
					}, 275);
				}
			});
		}
	}

	update_recent(true);
	setInterval(update_recent, 60000);

	$(window).on('resize', function(){
		if ($('.novideo').length && $('.listing_container').length) {
			breadcrumbDistanceTop = $('.novideo').position().top;
			listingDistanceTop = $('.listing_container').position().top;
		}
		if ($(window).height() <= 480) {
			$('.display_video').attr('style', 'height:' + $(window).height() + 'px !important;');
		} else {
			$('.display_video').attr('style', 'height: auto;');
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
		if (controls_fade_out_timeout !== undefined) {
			clearTimeout(controls_fade_out_timeout);
		}
	}

	function mousemove(main_video_prop) {
		document.getElementById('main_video').style.cursor = "auto";
		if ($('.vjs-controls').length) {
			clear_fade_out_timeout(controls_fade_out_timeout);
			controls_fade_out_timeout = fadeIn_then_fadeOut(main_video_prop);
		}
	}

	function fadeIn_then_fadeOut(main_video_prop) {
		if (!$('.vjs-controls').hasClass('vjs-fade-in')) {
			$('.vjs-controls').removeClass('vjs-fade-out').addClass('vjs-fade-in');
		}
		return setTimeout(function(){
			$('.vjs-controls').removeClass('vjs-fade-in').addClass('vjs-fade-out');
			main_video_prop.off('mousemove');
			document.getElementById('main_video').style.cursor = "none";
			setTimeout(function(){main_video_prop.on({mousemove: function(){mousemove(main_video_prop);}});}, 300);
		}, 1000);
	}

	main_video_prop = get_main_video_prop();
	main_video = get_main_video(main_video_prop);

	if (main_video !== undefined) {
		if ($(window).height() < 480) {
			var new_video_height = $(window).height();
			$('.display_video').attr('style', 'height:' + new_video_height + 'px !important');
		}
		$(".custom_controls").show();
		if ($('.novideo').length && $('.listing_container').length) {
			breadcrumbDistanceTop = $('.novideo').position().top;
			listingDistanceTop = $('.listing_container').position().top;
		}
		vol_step = .05;
		main_video.volume = 0; // will help us check if vol can be modified
		if (main_video.volume === 0) {
			main_video.volume = 1; // default vol
		} else {
			$(".vol").hide(); // if vol cannot be modified, hide vol controls
			if ($('.vjs-control').length) {
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
			if (e.originalEvent.detail >= 5) { // I love this :)
				main_video.volume = 0;
			} else {
				if (main_video.volume - vol_step > 0) main_video.volume -= vol_step;
				else main_video.volume = 0;
			}
			controls_fade_out_timeout = fadeIn_then_fadeOut(main_video_prop);
		});
		var hammer = new Hammer($('.vol_d')[0]);
		hammer.onhold = function(ev) {
			clear_fade_out_timeout(controls_fade_out_timeout);
			if (!main_video.muted) main_video.muted = true;
			else main_video.volume = 0;
			controls_fade_out_timeout = fadeIn_then_fadeOut(main_video_prop);
		};

		$('.ctrl_pp').on('click', function(e) {
			if (main_video.paused) main_video.play();
			else main_video.pause();
			clear_videojs_spinner();
		});

		$('.vol_i').on('click', function(e) {
			clear_fade_out_timeout(controls_fade_out_timeout);
			if (e.originalEvent.detail >= 5) { // I love this :)
				main_video.volume = 1;
			} else {
				if (main_video.volume + vol_step < 1) main_video.volume += vol_step;
				else main_video.volume = 1;
			}
			controls_fade_out_timeout = fadeIn_then_fadeOut(main_video_prop);
		});
		var hammer = new Hammer($('.vol_i')[0]);
		hammer.onhold = function(ev) {
			clear_fade_out_timeout(controls_fade_out_timeout);
			if (main_video.muted) main_video.muted = false;
			else main_video.volume = 1;
			controls_fade_out_timeout = fadeIn_then_fadeOut(main_video_prop);
		};

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
						fadeIn_then_fadeOut(main_video_prop);
						main_video.currentTime = offset;
						clear_videojs_spinner();
					}, 1000);
				}
				setInterval(function(){
					ignoreHashChange = true;
					window.location.hash = Math.floor(main_video.currentTime);
				}, 10000);
			},
			mousemove: function(){
				mousemove(main_video_prop);
			},
			dblclick: function(){
				toggle_fullscreen(main_video, .1);
			}
		});
		setInterval(function(){
			checkIfPaused(main_video);
		}, 1000);

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

		if (Modernizr.touch) {
			var hammer = new Hammer(main_video, {'prevent_default' : false});
			hammer.ontransform = function(ev) {
				if (ev.scale > 1) {
					toggle_fullscreen(main_video, 0);
				}
			};
			hammer.ontap = function(ev) {
				clear_fade_out_timeout(controls_fade_out_timeout);
				controls_fade_out_timeout = fadeIn_then_fadeOut(main_video_prop);
			};
		}
	}

	// if (!Modernizr.touch) {
		$(window).scroll(function(){
			if ($('.novideo').length && $('.listing_container').length) {
				if ($(window).scrollTop() >= breadcrumbDistanceTop) {
					$('.novideo').addClass('fixed');
				} else {
					$('.novideo').removeClass('fixed');
				}
			}
		});
	// }

	$('.current_container').on('mouseup', function (ev){
		if ($(this).has(ev.target).length === 0){
			$("html, body").animate({ scrollTop: "0" });
		}
	});
});