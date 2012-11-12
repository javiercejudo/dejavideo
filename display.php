<?php 
if ($video) {	
	echo "<video id='main_video' class='display display_video video-js vjs-default-skin' controls autoplay='autoplay' poster='img/dejavideo.png' data-setup='{}'>";
	echo "<source src='" . $video . "' type='" . $v_type . ";'>";
	echo "Your browser does not support the video tag.";
	echo "</video>";
	echo "<p class='current_container'>";
	echo "Current video: ";
	echo "<span class='current' title='" . $n_video . "'>" . basename($n_video) . "</span>";
	echo " <a href='$video'>[download]</a>";
	echo " <a href='?v=" . rawurlencode($dir) . "#listing'><strong>[close]</strong></a>";
	echo "</p>";
} else {
	echo "<h1 class='title'>" . TOP_TITLE . "</h1>";
	echo "<div class='display display_novideo'></div>";
	echo "<p class='current_container'>";
	echo "Current location: ";
	echo display_current_location($dir);
	// if ($dir !== DATA ) {
	// 	echo " <a href='?v=" . get_parent_folder($dir) . "#listing'>[up]</a>";
	// 	echo " <a href='.#listing'><strong>[home]</strong></a>";
	// }
	echo "</p>";
}