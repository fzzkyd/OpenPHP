# OpenPHP

## Overview

The OpenPHP framework was extracted from OpenCart and made some adjustments, thanks to the OpenCart development team.

## License

[GNU General Public License version 3 (GPLv3)](http://www.gnu.org/licenses/gpl-3.0.en.html)

## Install

These instructions are for a manual installation using FTP, cPanel or other web hosting Control Panel.

- Linux Install -

1. Upload all of the files and folders to your server from the "Upload" folder, place them in your web root. The web root is different on some servers, cPanel it should be public_html/ and on Plesk it should be httpdocs/.

2. Modify the configuration information in config.php and admin/config.php.

3. For Linux/Unix make sure the following folders and files are writable.

		chmod 0755 or 0777 system/storage/cache/
		chmod 0755 or 0777 system/storage/download/
		chmod 0755 or 0777 system/storage/logs/
		chmod 0755 or 0777 system/storage/modification/
		chmod 0755 or 0777 system/storage/session/
		chmod 0755 or 0777 system/storage/upload/
		chmod 0755 or 0777 system/storage/vendor/
		chmod 0755 or 0777 image/
		chmod 0755 or 0777 image/cache/
		chmod 0755 or 0777 image/catalog/
		chmod 0755 or 0777 config.php
		chmod 0755 or 0777 admin/config.php

		If 0755 does not work try 0777.

4. Make sure you have installed a MySQL Database which has a user assigned to it
	DO NOT USE YOUR ROOT USERNAME AND ROOT PASSWORD

5. Visit the site homepage e.g. http://www.example.com

- Windows Install -

1. Upload all the files and folders to your server from the "Upload" folder. This can be to anywhere of your choice. e.g. /wwwroot/store or /wwwroot

2. Modify the configuration information in config.php and admin/config.php.

3. For Windows make sure the following folders and files permissions allow Read and Write.

		system/storage/cache/
		system/storage/download/
		system/storage/logs/
		system/storage/modification/
		system/storage/session/
		system/storage/upload/
		system/storage/vendor/
		image/
		image/cache/
		image/catalog/
		config.php
		admin/config.php

4. Make sure you have installed a MySQL Database which has a user assigned to it
	DO NOT USE YOUR ROOT USERNAME AND ROOT PASSWORD

5. Visit the site homepage e.g. http://www.example.com

 - Notes -

Godaddy Issues

If your hosting on godaddy you might need to rename the php.ini to user.ini

It seems godadddy has started changing the industry standard names of files.