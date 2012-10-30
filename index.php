<?php 

header('Content-Type: text/html; charset=utf-8');

require 'config.php';
require 'functions.php';

$video   = ''; // consider defaulting to toturial video
$n_video = 'none';
$v_type  = '';
$v_codec = '';
if(isset($_GET['v']) && is_file($_GET['v'])) {
	$video   = $_GET['v'];
	$n_video = $video;
	$v_type  = get_mime_type($video);
	$v_codec = get_codec($v_type);
}

?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8" />
	<title>DejaVideo by Javier Cejudo</title>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
	<div class="player">
		<video width="720" height="445" controls="controls" autoplay="autoplay" poster="img/dejavideo.png">
			<source src="<?= $video ?>" type='<?= $v_type ?>;  codecs="<?= $v_codec ?>"'>
			Your browser does not support the video tag.
		</video>
		<p>
			Current video: 
			<?php 
			echo "<span class='current' title='" . $n_video . "'>" . basename($n_video) . "</span>";
			if ($video) {
				echo " <a href='$video'>[download]</a>";
				echo " <a href='.'>[close]</a>";
			}
			?>
		</p>
	</div>
<?php list_directory(DATA, $video, 1) ?>
</body>
</html>
