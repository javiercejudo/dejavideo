<?php

define('TOP_TITLE', "<!--<a href='.#listing'>DejaVideo</a> by <a href='https://twitter.com/javiercejudo'>@javiercejudo</a>-->");
define('DATA', 'data'); // default: 'data'
define('SCREEN_DIRECTORY_SEPARATOR', DIRECTORY_SEPARATOR); // default: DIRECTORY_SEPARATOR
define('DEPTH', 2); // set DEPTH to (-1) for infinite depth

$ARRAY_MIME_TYPES_CODECS = array (
	'video/mp4'       => 'avc1.42E01E, mp4a.40.2',
	'video/webm'      => 'vp8, vorbis',
	'video/ogg'       => 'theora, vorbis',
	'application/ogg' => 'theora, vorbis'
);

define('HIDE_LIST_WHEN_VIDEO_SELECTED', true);    // default: true
define('ONLY_FOLDERS_WITH_ACCEPTED_FILES', true); // default: true
define('ONLY_ACCEPTED_FILES', true);              // default: true
define('DISPLAY_NAMES', true);                    // default: true

$ARRAY_DISPLAY_NAMES = array (
	'/(.*)s([0-9]{2})e([0-9]{2}).*/i'       => '$1 S$2 E$3', // Covers S01E01 form
	'/([^0-9]+)([0-9]{1,2})x([0-9]{2}).*/i' => '$1 S$2 E$3', // Covers 10x01 form
	'/([^\(\[]*)[\(\[]?([1-2][0-9]{3}).*/'  => '$1 ($2)'     // Covers movies with year
);

define('VIDEOJS', true); // default: false