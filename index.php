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
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>DejaVideo by Javier Cejudo</title>
	<?php if (VIDEOJS && $video) echo '<link href="http://vjs.zencdn.net/c/video-js.css" rel="stylesheet">'; ?>
	<link href="css/styles.css" rel="stylesheet">
</head>
<body>
	<div class="display_container">
		<?php include 'display.php'	?>
	</div>
<?php 
if ($list) {
	echo "<div id='listingOFF' class='listing_container'>";
	list_directory($dir, $video, 1);
	echo "</div>";
}
?>
<script src="vendor/jquery-1.8.2.min.js"></script>
<script src="js/main.js"></script>
<?php if (VIDEOJS && $video) echo '<script src="http://vjs.zencdn.net/c/video.js"></script>'; ?>
</body>
</html>
