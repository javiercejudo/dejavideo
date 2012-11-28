<?php 
require '../config.php';
require '../functions.php';

$path = $_POST['path'];
$recent_files = get_recent_files('../' . $path, 10);
echo print_recent_files($recent_files, $path, true);