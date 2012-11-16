# DejaVideo

Check the demo page at [http://javiercejudo.kodingen.com/labs/dejavideo/](http://javiercejudo.kodingen.com/labs/dejavideo/).

Stream your own videos easily, either on your private network or to the 
world using HTML5 video.

I use the app to share all my videos from my main device to any devices
in the house connected to the Wi-Fi, including tablets and smartphones.

## Features:

- Indefinitely recursive listings.
- Support for Videojs
- Autodetects captions (`.vtt` files must have the same name as the
video except the extension, and must be placed either in the same
directory or in a subfolder `subs/`).
- Custom controls.
- Intuitive additions to Video.js: full screen on double click, autohide for
control bar…
- Fully functional without JavaScript.
- Responsive design with beautiful columns.

## Video support: <sup>*</sup>

- Theora (usually with `.ogv` or `.ogg` filename extensions)
- H.264, (`.mp4`, `.mkv`, `.3gp`)
- V8 (`.webm`)

\* Actual support depends on the browser of choice. Learn more at:
    http://diveintohtml5.info/video.html#what-works

## How to install:

Copy the application on a folder on your web root and put your videos 
inside the `data/` folder (alternatively, you can create a symlink to any
folder on your system), organised in subfolders or however you prefer.
Access the app by a local URL like `192.168.?.?/dejavideo`.

Requires PHP 5.2.0.
