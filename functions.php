<?php

function get_codec ($mime_type) {
	$codecs = $GLOBALS["ARRAY_MIME_TYPES_CODECS"];
	return $codecs[$mime_type];
}

function get_mime_type ($file) {
	$finfo     = finfo_open(FILEINFO_MIME_TYPE);
	$mime_type = finfo_file($finfo, $file);
	finfo_close($finfo);
	if ($mime_type === 'application/octet-stream' && get_extension($file) === 'webm') {
		return 'video/webm'; // solves problems with some webm files
	}
	return $mime_type;
}

function accepted_mime_type ($mime_type) {
	return array_key_exists($mime_type, $GLOBALS["ARRAY_MIME_TYPES_CODECS"]);
}

function get_extension ($file) {
	$info = pathinfo($file);
	return $info['extension'];
}

function list_files ($files, $dir, $video, $list_directory, $level) {
	echo "<ul class='level-$level'>";
	foreach ($files as $filename) {
		if ($filename != "." && $filename != "..") {
			echo "<li>";
			$new_dir = $dir . "/" . $filename;
			if (!is_dir($new_dir)) {
				if (accepted_mime_type(get_mime_type($new_dir))) {
					$is_current = ($new_dir === $video) ? ' current' : '';
					echo "<p><a class='file$is_current' href='?v=" . rawurlencode($new_dir) . "'>" . $filename . "</a></p>";
				} else {
					echo "<p class='file unsupported'>" . $filename . " [" . get_mime_type($new_dir) . " unsupported]</p>";
				}
			} else {
				echo "<p><span  class='dir'>" . $filename . "</span></p>";
				$list_directory($new_dir, $video, $level + 1);
			}
			echo "</li>";
		}
	}
	echo "</ul>";
}

function list_directory ($dir, $video, $level) {
	if ($handle = opendir($dir)) {
		while (false !== ($filename = readdir($handle))) {
			$files[] = $filename;
		}
		sort($files);
		list_files($files, $dir, $video, __FUNCTION__, $level);
		closedir($handle);
	} else return false;

	/* Alternative implementation (PHP5 only) */
	// if ($files = scandir($dir)) {
	// 	list_files($files, $dir, $video, __FUNCTION__, $level);
	// } else return false;
}