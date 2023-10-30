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

Future improvements:

* Shoutcast support.
