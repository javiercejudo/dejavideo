# DejaVideo

Requires PHP 5.4.0.

Check the demo page at [javiercejudo.kodingen.com/labs/dejavideo/](http://javiercejudo.kodingen.com/labs/dejavideo/).

Stream your own videos easily, either on your private network or to the 
world using HTML5 video. I use the app to share all my videos from my main 
device to any devicesin the house connected to the Wi-Fi, including tablets 
and smartphones.

## Features:

- Responsive design with beautiful columns for desktop, smartphones and tablets.
- Support for [Videojs](http://videojs.com/). <sup>*</sup>
- Autodetects captions (`.vtt` files must have the same name as the
video except the extension, and must be placed either in the same
directory or in a subfolder `subs/`).
- Added controls for video playback. <sup>*</sup>
- Intuitive additions to Video.js: full screen on double click (or pinch on touch 
screens thanks to [Hammer.js](http://eightmedia.github.com/hammer.js/)), 
autohide for control bar… <sup>*</sup>
- Custom start time by adding a number of seconds after the hash (ie. `url#60`
would make the video start at minute 1). The URL gets periodical 
updates so you can keep the link and start where you left off. <sup>*</sup>
- Convenient renaming of filenames via regular expressions (pattern - replacement).
- Fully functional without JavaScript.
- Folder contents count and file details (size and modification date).
- Recent files bar that scrolls horizontally by dragging it.
- Indefinitely recursive listings.

\* This feature requires JavaScript.

## Video support: <sup>*</sup>

- Theora (usually with `.ogv` or `.ogg` filename extensions)
- H.264, (`.mp4`, `.mkv`, `.3gp`)
- V8 (`.webm`)

\* Actual support depends on the browser of choice. Learn more at
    [http://diveintohtml5.info/video.html#what-works](http://diveintohtml5.info/video.html#what-works).

## How to install:

Copy the application on a folder on your web root and put your videos 
inside the `data/` folder (alternatively, you can create a symlink to any
folder on your system), organised in subfolders or however you prefer.
Access the app by a local URL like `192.168.?.?/dejavideo`. Enjoy!
