<?php

date_default_timezone_set('Australia/Sydney');
define('ROOT', dirname(__FILE__));

define('ENVIRONMENT', 'dev');             // default: live; other values: dev
define('OPTIMISED_SUFFIX', '_optimised'); // default: '_optimised'

define('TOP_TITLE', "<!--<a href='.#listing'>DejaVideo</a> by <a href='https://twitter.com/javiercejudo'>@javiercejudo</a>-->");
define('DATA', 'data');                                 // default: 'data'
define('POSTERS', 'data/posters');                      // default: 'data/posters'
define('DEFAULT_POSTER', 'img/dejavideo.png');          // default: 'img/dejavideo.png'
define('DS', DIRECTORY_SEPARATOR);                      // default: DIRECTORY_SEPARATOR
define('SDS', '/');                                     // default: DS
define('DEPTH', 2);                                     // default: 2; set DEPTH to (-1) for infinite depth
define('DISPLAY_FILE_COUNT', false);                    // default: true
define('REAL_FILE_COUNT', DISPLAY_FILE_COUNT && false); // default: DISPLAY_FILE_COUNT && false
define('DISPLAY_FILE_DETAILS', true);                   // default: true
define('AGO_NUMBER_OF_UNITS', 1);                       // default: 2; e.g. {weeks} {days} ago makes 2 units
define('SECONDS_OLD_BEFORE_SHOWING', 5);                // default: 5;
define('MAX_SIZE_RECENT_FILES', 50);                    // default: 50;
define('DEFAULT_ELLIPSIS', '…');                        // default: '…';

$ARRAY_MIME_TYPES_CODECS = array(
	'video/mp4'       => 'avc1.42E01E, mp4a.40.2',
	'video/webm'      => 'vp8, vorbis',
	'video/ogg'       => 'theora, vorbis',
	'application/ogg' => 'theora, vorbis',

	// The following would need plugins in any browser
	// 'video/mpeg'      => '',
	// 'video/x-msvideo' => '',
	// 'video/x-matroska'=> '',
	// 'application/octet-stream'=> ''
);

define('HIDE_LIST_WHEN_VIDEO_SELECTED', true);                           // default: true
define('ONLY_ACCEPTED_FILES', true);                                     // default: true
define('ONLY_FOLDERS_WITH_ACCEPTED_FILES', true && ONLY_ACCEPTED_FILES); // default: true && ONLY_ACCEPTED_FILES
define('DISPLAY_NAMES', true);                                           // default: true

$ARRAY_DISPLAY_NAMES = array(
	// pattern => replacement
	'/([^\(\[]*)[\(\[]?(18[789][0-9]{1}|19[0-9]{2}|20[0-3][0-9]{1})\.(0[0-9]|1[0-2])\.(0[0-9]|1[0-9]|2[0-9]|3[0-1]).*/'  => '$1 $4/$3/$2', // Covers movies with year
	'/([0-9]{2})-([0-9]{2})-(.*)\.mp4/i' => '$3',                                 // Covers 01-01-description
	'/(.*)s([0-9]{2})e([0-9]{2}).*/i' => '$1 S$2 E$3',                            // Covers S01E01
	'/([^0-9]+)([0-9]{1})x([0-9]{2}).*/i' => '$1 S0$2 E$3',                       // Covers 1x01
	'/([^0-9]+)([0-9]{2})x([0-9]{2}).*/i' => '$1 S$2 E$3',                        // Covers 10x01
	'/([^\(\[]*)[\(\[]?(18[789][0-9]|19[0-9]{2}|20[0-3][0-9]).*/'  => '$1 ($2)',  // Covers movies with year
	'/(^[0-9]{2}\.)(.*)/' => '$2',                                                // Covers 01. Folder name
	'/' . preg_quote(DATA, '/') . '/' => 'Home',                                  // Covers DATA folder, the root
	'/(.*)\.(mp4|ogv|ogg|webm)$/i' => '$1',                                       // Covers file extension removal for other supported files
	'/[\._]/' => ' '                                                              // spaces everywhere!
);

define('VIDEOJS', true); // default: true

define('DOWNLOAD_ICON', '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" class="svg_icon" x="0px" y="0px" width="100px" height="100px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve"><g id="Your_Icon"><polygon points="73.966,39.457 61.732,39.457 61.736,15.518 37.2,15.518 37.2,39.457 25.991,39.457 50.185,63.492" style="fill:#cccccc;"/><polygon points="73.987,60.495 73.987,72.49 26.013,72.49 26.013,60.495 14.018,60.495 14.018,84.482 85.982,84.482 85.982,60.495" style="fill:#cccccc;"/></g></svg>');
define('CLOSE_ICON',    '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" class="svg_icon" x="0px" y="0px" width="100px" height="100px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve"><g id="Your_Icon"><g><g><path d="M50,95C25.187,95,5,74.813,5,50C5,25.187,25.187,5,50,5c24.813,0,45,20.187,45,45C95,74.813,74.813,95,50,95z M50,15     c-19.299,0-35,15.701-35,35s15.701,35,35,35s35-15.701,35-35S69.299,15,50,15z" style="fill:#cccccc;"/></g><polygon points="73.535,33.536 66.465,26.464 50,42.929 33.536,26.464 26.464,33.536 42.929,50 26.464,66.465 33.536,73.535     50,57.07 66.465,73.535 73.535,66.465 57.07,50   " style="fill:#cccccc;"/></g></g></svg>');