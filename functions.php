<?php

function get_extension ($path) {
	$info = pathinfo($path);
	return $info['extension'];
}
function get_filename ($path) {
	$info = pathinfo($path);
	return $info['basename'];
}

function format_bytes($a_bytes) {
	if ($a_bytes < 1024) {
		return $a_bytes .'&nbsp;B';
	} elseif ($a_bytes < 1048576) {
		return round($a_bytes / 1024, 2) .'&nbsp;KiB';
	} elseif ($a_bytes < 1073741824) {
		return round($a_bytes / 1048576, 2) . '&nbsp;MiB';
	} elseif ($a_bytes < 1099511627776) {
		return round($a_bytes / 1073741824, 2) . '&nbsp;GiB';
	}
}

function format_date ($unix_timestamp) {
	return date('Y-m-d', $unix_timestamp);
}

function time_ago($tm, $rcs = 1, $c_level = 1) {
	// credit: http://css-tricks.com/snippets/php/time-ago-function/
	$cur_tm = time(); $dif = $cur_tm-$tm;
	$pds = array('second','minute','hour','day','week','month','year','decade');
	$lngh = array(1,60,3600,86400,604800,2630880,31570560,315705600,3157056000);
	for($v = sizeof($lngh)-1; ($v >= 0)&&(($no = $dif/$lngh[$v])<=1); $v--); if($v < 0) $v = 0; $_tm = $cur_tm-($dif%$lngh[$v]);

	$no = floor($no); if($no <> 1) $pds[$v] .='s'; $x=sprintf("%d %s ",$no,$pds[$v]);
	if((($rcs-1 >= 1)&&($c_level <= $rcs-1) || $rcs == 0)&&($v >= 1)&&(($cur_tm-$_tm) > 0)) $x .= time_ago($_tm, $rcs, $c_level+1);
	if ($no < 5 && strpos($pds[$v], 'second') !== false)
		return "Downloading…";
	if ($rcs <= $c_level || $v == 0)
		return $x . ' ago';
	return $x;
}

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

function is_safe_dir ($dir) {
	return is_dir($dir) && 
	       substr($dir, 0, 1) != '.' && 
	       substr($dir, 0, 1) != '/' && 
	       !preg_match('/[\\/]\.{2}/', $dir);
}

function get_subtitles ($video) {
	$info = pathinfo($video);
	$subtitles = $info['dirname'] . DIRECTORY_SEPARATOR . 'subs' .  DIRECTORY_SEPARATOR . $info['filename'] . '.vtt';
	if (is_file($subtitles)) return $subtitles;
	$subtitles = $info['dirname'] . DIRECTORY_SEPARATOR . 'subs' .  DIRECTORY_SEPARATOR . $info['filename'] . '.srt';
	if (is_file($subtitles)) return $subtitles;
	$subtitles = $info['dirname'] . DIRECTORY_SEPARATOR . $info['filename'] . '.vtt';
	if (is_file($subtitles)) return $subtitles;
	$subtitles = $info['dirname'] . DIRECTORY_SEPARATOR . $info['filename'] . '.srt';
	if (is_file($subtitles)) return $subtitles;
	return false;
}

function get_poster ($video) {
	$info = pathinfo($video);
	$poster = $info['dirname'] . DIRECTORY_SEPARATOR . 'posters' .  DIRECTORY_SEPARATOR . $info['filename'] . '.jpg';
	if (is_file($poster)) return $poster;
	$poster = $info['dirname'] . DIRECTORY_SEPARATOR . $info['filename'] . '.jpg';
	if (is_file($poster)) return $poster;
	$poster = POSTERS . DIRECTORY_SEPARATOR . $info['filename'] . '.jpg';
	if (is_file($poster)) return $poster;
	if (is_file(DEFAULT_POSTER)) return DEFAULT_POSTER;
	return false;
}

function print_recent_files ($recent_files, $dir, $ajax = false) {
	$print = '';
	// $print .= "<ol id='top_recent' class='top_recent' style='display: none;'>";
	// $print .= "<li class='item_recent'>Recent:";
	foreach ($recent_files as $path_to_file => $file_md) {
		if($ajax) $path_to_file = substr($path_to_file, strpos($path_to_file, DATA));
		$print .= "<li class='item_recent'><a href='?v=" . rawurlencode($path_to_file) . "&amp;d=" . $dir . "'>" . get_display_name(get_filename($path_to_file)) . "</a>";
	}
	// $print .= "</ol>";
	return $print;
}

function add_recent_file ($pathname, $file_md, $max_date, $recent_files, $amount) {
	$num_files = count($recent_files);
	if($file_md > $max_date || $num_files < $amount) {
		$recent_files[$pathname] = $file_md;
		arsort($recent_files);
		if($num_files > $amount) {
			array_pop($recent_files);
		}
		return $recent_files;
	} 
	return false;
}

function get_recent_files ($path = DATA, $amount = 3) {
	$dir = new DirectoryIterator($path);
	$recent_files = array();
	$max_date = 0;
	foreach($dir as $file){
		$pathname = $file->getPathname();
		if(is_file($pathname) 
		  && accepted_mime_type(get_mime_type($pathname)) 
		  && substr($file->getFilename(), 0, 1) != "." 
		  && !preg_match('/\.part$/i', $file->getFilename())
		  && time() - filemtime($pathname) > 5) {
			$file_md = filemtime($pathname);
			if ($aux = add_recent_file($pathname, $file_md, $max_date, $recent_files, $amount)) {
				$recent_files = $aux;
				$max_date = end($recent_files);
			}
		}
		if(is_dir($pathname) && !$file->isDot()) {
			$rec_recent_files = get_recent_files($pathname, $amount);
			foreach ($rec_recent_files as $pathname => $file_md) {
				if ($aux = add_recent_file($pathname, $file_md, $max_date, $recent_files, $amount)) {
					$recent_files = $aux;
					$max_date = end($recent_files);
				}
			}
		}
	}
	return $recent_files;
}

function display_current_location ($dir) {
	$path_trail = '';
	$current_location = '';
	$tokens = array_filter(explode(DS, $dir));
	foreach ($tokens as $token) {
		$path_trail .= $token;
		$dir_active = ($token !== end($tokens)) ? '' : ' dir_active';
		$current_location .= "<a class='dir$dir_active' href='?v=" . rawurlencode($path_trail) . "'>" . get_display_name($token);
		if (DISPLAY_FILE_COUNT) {
			$current_location .= " <span class='file_count'>(" . count_files($path_trail) . ")</span>";
		}
		$current_location .= "</a>";
		if ($token !== end($tokens)) {
			$current_location .= ' ' . SDS . ' ';
			$path_trail .= DS;
		}
	}
	return $current_location;
}

function get_display_name($filename) {
	if (!DISPLAY_NAMES) return $filename;
	foreach ($GLOBALS["ARRAY_DISPLAY_NAMES"] as $pattern => $replacement) {
		$display_name = preg_replace($pattern, $replacement, $filename);
		if (strcmp($filename, $display_name) !== 0)	{
			return preg_replace('/[\.\-_]/', ' ', $display_name);
		}
	}
	return $filename;
}

function count_files($path, $count_files = false) {
	$dir = new DirectoryIterator($path);
	$n = 0;
	foreach($dir as $file){
		if(is_file($path.DS.$file) && accepted_mime_type(get_mime_type($path.DS.$file)) && substr($file, 0, 1) != ".") {
			$n++;
		}
		if(is_safe_dir($path.DS.$file) && !$file->isDot()) {
			$GLOBALS['found'] = 0;
			if (contains_supported_mime_types($path.DS.$file)) {
				if (!$count_files) $n++;
				else $n += count_files($path.DS.$file, true);
			}
		}
	}
	return $n;
}

function scandir_grouped ($dir, $sorting_order = SCANDIR_SORT_ASCENDING) {
	$files = scandir($dir, $sorting_order);
	$no_dirs = $dirs = array();
    foreach($files as $filename) {
		if (!is_dir($dir . "/" . $filename)) $no_dirs[] = $filename;
		else $dirs[] = $filename;
    }
    return array_merge($no_dirs, $dirs);
}

function contains_supported_mime_types ($dir) {
	if ($GLOBALS['found']) return true;
	$files = scandir_grouped($dir, SCANDIR_SORT_NONE);
	foreach ($files as $filename) {
		if ($filename != "." && $filename != ".." && substr($filename, 0, 1) != ".") {
			$path_to_file = $dir . "/" . $filename;
			if (!is_dir($path_to_file)) {
				if (accepted_mime_type(get_mime_type($path_to_file))) {
					$GLOBALS['found'] = 1;
					return true;
				}
			} else {
				contains_supported_mime_types($path_to_file);
			}
		}
	}
	return $GLOBALS['found'];
}

function list_files ($files, $dir, $video, $list_directory, $level) {
	if (DEPTH > -1 && $level > DEPTH) return 0;
	if ($level === 1) {
		echo '<div id="top_recent_wrapper" class="tr_placeholder">';
		echo '<ol id="top_recent" class="top_recent" id="tr_placeholder"><li class="item_recent" id="recent_tag">Recent:</li><li class="item_recent" id="loading_tag">Loading…</li></ol>';
		echo '</div>';
		echo '<script>';
		echo 'document.getElementById("listing").style.display = "none";';
		echo '</script>';
	}
	echo "<ul class='level-$level'>";
	foreach ($files as $filename) {
		if ($filename != "." && $filename != ".." && substr($filename, 0, 1) != ".") {
			$new_dir = $dir . "/" . $filename;
			if (!is_dir($new_dir)) {
				if (accepted_mime_type(get_mime_type($new_dir))) {
					$is_current = ($new_dir === $video) ? ' current' : '';
					echo "<li>";
					echo "<p class='file'>";
					echo "<a class='$is_current' href='?v=" . rawurlencode($new_dir) . "&amp;d=" . rawurlencode($GLOBALS['dir']) . "' title='" . $filename . "'>";
					echo get_display_name($filename);
					echo "</a>";
					if (DISPLAY_FILE_DETAILS && time() - filemtime($new_dir) > 5) {
						echo "<br><span class='file_details'>" . format_bytes(filesize($new_dir));
						echo " - " . time_ago(filemtime($new_dir), AGO_NUMBER_OF_UNITS) . "</span>";
					}
					echo "</p>";
					echo "</li>";
				} else {
					if (!ONLY_ACCEPTED_FILES) {
						echo "<li>";
						echo "<p class='file unsupported' title='" . $filename . "'>" . get_display_name($filename) . " [" . get_mime_type($new_dir) . " unsupported]</p>";
						echo "</li>";
					}
				}
			} else {
				$GLOBALS['found'] = 0;
				if (!ONLY_FOLDERS_WITH_ACCEPTED_FILES || contains_supported_mime_types($new_dir)) {
					echo "<li>";
					echo "<p>";
					echo "<a class='dir' href='?v=" . rawurlencode($new_dir) . "'>";
					echo get_display_name($filename);
					if (DISPLAY_FILE_COUNT) {
						echo " <span class='file_count'>(" . count_files($new_dir) . ")</span>";
					}
					echo "</a>";
					echo "</p>";
					$list_directory($new_dir, $video, $level + 1);
					echo "</li>";
				}
			}
		}
	}
	echo "</ul>";
}

function list_directory ($dir, $video, $level) {
	if ($files = scandir_grouped($dir, SCANDIR_SORT_ASCENDING)) {
		list_files($files, $dir, $video, __FUNCTION__, $level);
	} else return false;
}