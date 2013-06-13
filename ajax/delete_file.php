<?php 
require '../config.php';
require '../functions.php';

$path = $_POST['path'];

if (substr($path, 0, strlen(DATA)) == DATA) {
	echo json_encode(delete_file($path));
	return;
}

$result = array();
$result['success'] = false;

echo json_encode($result);
