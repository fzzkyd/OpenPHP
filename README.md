# OpenPHP

## Overview

The OpenPHP framework is extracted from OpenCart and modifies some of the code.
Thanks to the contributors to the OpenCart project.

## Install

These instructions are for a manual installation using FTP, cPanel or other web hosting Control Panel.

- Linux Install -

1. Upload all of the files and folders to your server from the this folder, place them in your web root. Then set the run directory to the "src" folder.

2. Modify the configuration information in config.php and admin/config.php.

3. For Linux/Unix make sure the following folders and files are writable.

		chmod 0755 or 0777 storage/cache/
		chmod 0755 or 0777 storage/download/
		chmod 0755 or 0777 storage/logs/
		chmod 0755 or 0777 storage/modification/
		chmod 0755 or 0777 storage/session/
		chmod 0755 or 0777 storage/upload/
		chmod 0755 or 0777 storage/vendor/
		chmod 0755 or 0777 src/image/
		chmod 0755 or 0777 src/image/cache/
		chmod 0755 or 0777 src/image/catalog/

		If 0755 does not work try 0777.

4. Make sure you have installed a MySQL Database which has a user assigned to it
	DO NOT USE YOUR ROOT USERNAME AND ROOT PASSWORD

5. Visit the site homepage e.g. http://www.example.com

- Windows Install -

1. Upload all of the files and folders to your server from the this folder, place them in your web root. Then set the run directory to the "src" folder.

2. Modify the configuration information in config.php and admin/config.php.

3. For Windows make sure the following folders and files permissions allow Read and Write.

		storage/cache/
		storage/download/
		storage/logs/
		storage/modification/
		storage/session/
		storage/upload/
		storage/vendor/
		src/image/
		src/image/cache/
		src/image/catalog/

4. Make sure you have installed a MySQL Database which has a user assigned to it
	DO NOT USE YOUR ROOT USERNAME AND ROOT PASSWORD

5. Visit the site homepage e.g. http://www.example.com

 - Notes -

## License

[GNU General Public License version 3 (GPLv3)](http://www.gnu.org/licenses/gpl-3.0.en.html)

## Thanks

[OpenCart](https://github.com/opencart/opencart)
