<?php 

// default vaules
$video   = '';
$n_video = 'none';
$v_type  = '';
$v_codec = '';
$dir     = DATA;
$is_home = false;
$list    = true;
$GLOBALS['found'] = 0;

if (isset($_GET['v']) && !empty($_GET['v'])) {
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
	} elseif (is_safe_dir($_GET['v']) && contains_supported_mime_types($_GET['v'])) {
		$dir = $_GET['v'];
	}
}
if (
	isset($_GET['d']) 
	&& !empty($_GET['d']) && is_safe_dir($_GET['d'])
	&& contains_supported_mime_types($_GET['d'])
	&& substr($_GET['d'], 0, strlen(DATA)) == DATA
) {
	$dir = $_GET['d'];
}
if ($dir === DATA) {
	$is_home = true;
}
