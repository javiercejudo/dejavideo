<?php 
header('Content-Type: text/html; charset=utf-8');
$time_start = microtime(true);
require 'config.php';
require 'functions.php';
require 'initialize.php';
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0">
	<title>
		<?php get_page_title($video, $dir) ?> - DejaVideo by Javier Cejudo
	</title>
	<link href="vendor/css/normalize-2.0.1<?= OPTIMISED_SUFFIX ?>.css" rel="stylesheet">
	<?php if (VIDEOJS && $video) echo '<link href="vendor/css/video-3.2.0.min.css" rel="stylesheet">'; ?>
	<link href="css/styles<?= OPTIMISED_SUFFIX ?>.css" rel="stylesheet">
</head>
<body>
	<div class="display_container">
		<?php include 'display.php'	?>
	</div>
<?php 
if ($list) {
	echo "<input id='current_dir' type='hidden' value='" . $dir . "'>";
	echo "<div id='listing' class='listing_container'>";
	list_directory($dir, $video, 1);
	$time_end = microtime(true);
	$execution_time = $time_end - $time_start;
	echo "<p class='footer standard_box'>© Javier Cejudo " . date('Y') . ".";
	echo " <a href='https://github.com/javiercejudo/DejaVideo/'>Fork on Github</a>.";	
	if (ENVIRONMENT === 'dev')
		echo " <br>Up to this point, the total execution time was " . number_format($execution_time, 4) . " seconds.";
	echo "</p></div>";	
}
?>
<script src="vendor/js/jquery-1.8.2.min.js"></script>
<?php 
if (VIDEOJS && $video) echo '<script src="vendor/js/video-3.2.0.min.js"></script>';
// if (DISPLAY_FILE_DETAILS) echo '<script src="vendor/js/jquery.timeago-0.11.4.js"></script>'; 
?>
<script src="vendor/js/modernizr.custom-2.6.2.min.js"></script>
<script src="vendor/js/hammer-0.6.3<?= OPTIMISED_SUFFIX ?>.js"></script>
<script src="vendor/js/jquery.timeago-0.11.4<?= OPTIMISED_SUFFIX ?>.js"></script>
<script src="js/main<?= OPTIMISED_SUFFIX ?>.js"></script>
</body>
</html>
