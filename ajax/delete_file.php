<?php 
require '../config.php';
require '../functions.php';

$path = $_POST['path'];

if (substr($path, 0, strlen(DATA)) == DATA && delete_file($path)) {
	echo 1;
	exit;
}
echo 0;
