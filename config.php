<?php

define('DATA', 'data'); // folder data/ in this directory

$ARRAY_MIME_TYPES_CODECS = array (
	'video/mp4'       => 'avc1.42E01E, mp4a.40.2',
	'video/webm'      => 'vp8, vorbis',
	'video/ogg'       => 'theora, vorbis',
	'application/ogg' => 'theora, vorbis'
);

define('ONLY_FOLDERS_WITH_ACCEPTED_FILES', true);
define('ONLY_ACCEPTED_FILES', false);