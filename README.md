# Simple web radio player

This is a simple and minimalist radio player for webpage, with a cool features, includes:
* Lightweight: Working with pure Java Script,
* Stations info and image logo is stored on mysql database
* Smartphone friendly
* Buffer Meter
* Smooth volume bar
* Simple to add, edit and delete stations
* Shows music name, artist, album logo (icecast server only) and bitrate info.

To install on your server (WEB+PHP), copy all files from the app directory to the html directory.

To use it via Docker, you can use the compose.yml example below:

```
docker compose -f Compose.yml up -d --force-recreate
```

Use "radio-config.php" file to add, remove and edit radio stations.

The function playing now, bitrate, etc., depends on the server that is transmitting the radio, in this case, for now, it is only compatible with icecast servers with icy or ogg metadata. Even so, radios broadcast via shoutcast should play normally, but without any additional information.

Known issues:
* Play/Pause using Android API does not work properly.
* Blank or unknown images appear as error.
* Depending on the location of the radio, some characters may appear strange.
* Sometimes (rarely), the artist and song name may appear as "undefined".

Future improvements:
* Shoutcast support.
