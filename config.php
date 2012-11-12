<?php

define('TOP_TITLE', "<!--<a href='.#listing'>DejaVideo</a> by <a href='https://twitter.com/javiercejudo'>@javiercejudo</a>-->");
define('DATA', 'data'); // default: 'data'

$ARRAY_MIME_TYPES_CODECS = array (
	'video/mp4'       => 'avc1.42E01E, mp4a.40.2',
	'video/webm'      => 'vp8, vorbis',
	'video/ogg'       => 'theora, vorbis',
	'application/ogg' => 'theora, vorbis'
);

define('DEPTH', 2); // set DEPTH to (-1) for infinite depth

define('HIDE_LIST_WHEN_VIDEO_SELECTED', true);    // default: true
define('ONLY_FOLDERS_WITH_ACCEPTED_FILES', true); // default: true
define('ONLY_ACCEPTED_FILES', true);              // default: true
define('DISPLAY_NAMES', true);                    // default: true

define('SCREEN_DIRECTORY_SEPARATOR', DIRECTORY_SEPARATOR); // default: DIRECTORY_SEPARATOR

define('VIDEOJS', false); // default: false
