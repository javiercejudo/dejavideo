<?php 
require '../config.php';
require '../functions.php';

$path = $_POST['path'];
$recent_files = get_recent_files(ROOT . DS . $path, 10, false);
echo print_recent_files($recent_files, $path, true);