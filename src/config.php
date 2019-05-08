<?php
// HTTP
define('HTTP_SERVER', 'http://domain.com/');

// HTTPS
define('HTTPS_SERVER', 'https://domain.com/');

// DIR
define('DIR_ROOT', str_replace('\\', '/', realpath(dirname(__FILE__))) . '/');
define('DIR_APPLICATION', DIR_ROOT . 'catalog/');
define('DIR_SYSTEM', DIR_ROOT . 'system/');
define('DIR_IMAGE', DIR_ROOT . 'image/');
define('DIR_LANGUAGE', DIR_APPLICATION . 'language/');
define('DIR_TEMPLATE', DIR_APPLICATION . 'view/theme/');
define('DIR_CONFIG', DIR_SYSTEM . 'config/');
define('DIR_STORAGE', DIR_ROOT . '../storage/');
define('DIR_CACHE', DIR_STORAGE . 'cache/');
define('DIR_DOWNLOAD', DIR_STORAGE . 'download/');
define('DIR_LOGS', DIR_STORAGE . 'logs/');
define('DIR_MODIFICATION', DIR_STORAGE . 'modification/');
define('DIR_SESSION', DIR_STORAGE . 'session/');
define('DIR_UPLOAD', DIR_STORAGE . 'upload/');

// ERR
define('ERR_DISPLAY', true);
define('ERR_LOG', true);
define('ERR_FILENAME', 'error.log');

// DATE
define('DATE_TIMEZONE', 'PRC');

// DB
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_DATABASE', 'op_openphp');
define('DB_PORT', '3306');
define('DB_PREFIX', 'op_');
define('DB_AUTOSTART', true);
