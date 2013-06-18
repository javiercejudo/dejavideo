<?php 
require '../config.php';
require '../functions.php';

$path = $_GET['path'];
if (substr($path, 0, strlen(DATA)) == DATA) {
	$recent_files = get_recent_files(ROOT . DS . $path, MAX_AMOUNT_RECENT_FILES, false);
	echo print_recent_files($recent_files, $path, true);
} else {
	echo '<li class="item_recent replaceable">The recent files could not be loaded.</li>';
}