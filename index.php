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
	<title>
		<?php get_page_title($video, $dir) ?> - DejaVideo by Javier Cejudo
	</title>
	<link href="vendor/css/normalize-2.0.1.css" rel="stylesheet">
	<?php if (VIDEOJS && $video) echo '<link href="vendor/css/video-3.2.0.min.css" rel="stylesheet">'; ?>
	<link href="css/styles.css?v=<?= time() ?>" rel="stylesheet">
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
	echo "</div>";
}
?>
<script src="vendor/js/jquery-1.8.2.min.js"></script>
<?php if (VIDEOJS && $video) echo '<script src="vendor/js/video-3.2.0.min.js"></script>'; ?>
<script src="vendor/js/modernizr.custom-2.6.2.min.js"></script>
<script src="vendor/js/hammer-0.6.3.js"></script>
<script src="js/main.js?v=<?= time() ?>"></script>
</body>
</html>
