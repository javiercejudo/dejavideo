<?php 
if ($video) {
	echo "<video class='display' controls='controls' autoplay='autoplay' poster='img/dejavideo.png'>";
	echo "<source src='" . $video . "' type='" . $v_type . ";'>";
	echo "Your browser does not support the video tag.";
	echo "</video>";
	echo "<p>";
	echo "Current video: ";
	echo "<span class='current' title='" . $n_video . "'>" . basename($n_video) . "</span>";
	echo " <a href='$video'>[download]</a>";
	echo " <a href='?v=" . $dir . "'><strong>[close]</strong></a>";
	echo "</p>";
} else {
	echo "<h1 class='title'>DejaVideo by<br>@javiercejudo</h1>";
	echo "<div class='display display_novideo'></div>";
	echo "<p>";
	echo "Current location: ";
	echo "<span class='current' title='" . $dir . "'>" . $dir . "</span>";
	if ($dir !== DATA ) {
		echo " <a href='?v=" . get_parent_folder($dir) . "#listing'>[up]</a>";
		echo " <a href='.#listing'><strong>[home]</strong></a>";
	}
	echo "</p>";
}