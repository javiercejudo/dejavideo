<?php 

// default vaules
$video   = '';
$n_video = 'none';
$v_type  = '';
$v_codec = '';
$dir     = DATA;
$list    = true;

if(isset($_GET['v']) && !empty($_GET['v'])) {
	if(is_safe_dir(get_dirname($_GET['v'])) && is_file($_GET['v'])) {
		$video   = $_GET['v'];
		$n_video = $video;
		$v_type  = get_mime_type($video);
		if (accepted_mime_type($v_type)) {
			$v_codec = get_codec($v_type);
		}
		if (HIDE_LIST_WHEN_VIDEO_SELECTED) {
			$list = false;
		}
	} elseif(is_safe_dir($_GET['v'])) {
		$dir = $_GET['v'];
	}
}
if(isset($_GET['d']) && !empty($_GET['d']) && is_safe_dir($_GET['d'])) {
	$dir = $_GET['d'];
}
