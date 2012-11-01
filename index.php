<?php 
header('Content-Type: text/html; charset=utf-8');
require 'config.php';
require 'functions.php';
require 'initialize.php';
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8" />
	<title>DejaVideo by Javier Cejudo</title>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
	<div class="display_container">
		<?php include 'display.php'	?>
	</div>
<?php 
if ($list) {
	echo "<div id='listingOFF'>";
	list_directory($dir, $video, 1);
	echo "</div>";
}?>
<script src="vendor/jquery-1.8.2.min.js" type="text/javascript"></script>
<script src="js/main.js" type="text/javascript"></script>
</body>
</html>
