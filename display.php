<?php 
if ($video) {	
	echo "<video id='main_video' class='display display_video video-js vjs-default-skin' controls autoplay='autoplay' poster='img/dejavideo.png' data-setup='{}'>";
	echo "<source src='" . $video . "' type='" . $v_type . ";" . $v_codec . "'>";
	if ($subs = get_subtitles($video)) {
		echo "<track kind='subtitles' src='" . $subs . "' srclang='en' label='English' />";
	}
	echo "Your browser does not support the video tag.";
	echo "</video>";
	echo "<p class='custom_controls'>";
	echo " <a href='javascript:;' class='ctrl dir ctrl_lll'>-1min</a>";
	echo " <a href='javascript:;' class='ctrl dir ctrl_ll'>-10s</a>";
	echo " <a href='javascript:;' class='ctrl dir ctrl_l'>-3s</a>";
	echo " <a href='javascript:;' class='ctrl dir ctrl_pp'>loading…</a>";
	echo " <a href='javascript:;' class='ctrl dir ctrl_r'>+3s</a>";
	echo " <a href='javascript:;' class='ctrl dir ctrl_rr'>+10s</a>";
	echo " <a href='javascript:;' class='ctrl dir ctrl_rrr'>+1min</a>";
	echo "</p>";
	echo "<p class='current_container'>";
	echo "Current video: ";
	echo "<span class='current' title='" . $n_video . "'>" . get_display_name(basename($n_video)) . "</span>";
	echo " <a href='$video'>[download]</a>";
	echo " <a href='?v=" . rawurlencode($dir) . "#listing'><strong>[close]</strong></a>";
	echo "</p>";
} else {
	echo "<h1 class='title'>" . TOP_TITLE . "</h1>";
	echo "<div class='display display_novideo'></div>";
}
if (!$video || !HIDE_LIST_WHEN_VIDEO_SELECTED) {
	echo "<p class='current_container'>";
	echo "Current location: ";
	echo display_current_location($dir);
	// if ($dir !== DATA ) {
	// 	echo " <a href='?v=" . get_parent_folder($dir) . "#listing'>[up]</a>";
	// 	echo " <a href='.#listing'><strong>[home]</strong></a>";
	// }
	echo "</p>";
}