<?php 
require '../config.php';
require '../functions.php';

$path = $_POST['path'];

if (substr($path, 0, strlen(DATA)) == DATA) {
	if (delete_file($path)) {
		echo 1;
	} else {
		echo 0;
	}
} else {
	echo 0;
}
