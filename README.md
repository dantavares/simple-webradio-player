# Simple web radio player

This is a simple and minimalist radio player for webpage, with a cool features, includes:
* Lightweight: Working with pure Java Script,
* Stations info and image logo is stored on mysql database
* Smartphone friendly
* Buffer Meter
* Smooth volume bar
* Simple to add, edit and delete stations
* Shows music name, artist, album logo (icecast server only) and bitrate info.

To install on your server, simple copy all files on a folder, import a "radio.sql" file on your mysql database and set a user and password on "db-connect.php". You can improve a security access creating a supplementary files on apache server (if you are using apache), here a example of .htaccess:

```
#.htaccess
<files db-connect.php>
    order allow,deny
    deny from all
</files>

<files radio-config.php>
    AuthType Basic
    AuthName "Acesso Restrito"
    AuthUserFile /var/www/html/radio/.htpasswd
    Require valid-user
</files>
```
In this case, you need to create your personal user and password using a 'htpasswd' command on apache server.

The function playing now, bitrate, etc., depends on the server that is transmitting the radio, in this case, for now, it is only compatible with icecast servers with icy or ogg metadata. Even so, radios broadcast via shoutcast should play normally, but without any additional information.

Known issues:
* Play/Pause using Android API does not work properly.
* Blank or unknown images appear as error.
* Depending on the location of the radio, some characters may appear strange.
* Sometimes (rarely), the artist and song name may appear as "undefined".

Future improvements:
* Shoutcast support.
