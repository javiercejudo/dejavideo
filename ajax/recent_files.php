<?php 
require '../config.php';
require '../functions.php';

$path = $_GET['path'];
$recent_files = get_recent_files(ROOT . DS . $path, 20, false);
if (substr($path, 0, strlen(DATA)) == DATA) {
	echo print_recent_files($recent_files, $path, true);
} else {
	echo '<li class="item_recent replaceable">The recent files could not be loaded.</li>';
}