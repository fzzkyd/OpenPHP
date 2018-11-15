<?php
// Version
define('VERSION', '1.0.0');

// Configuration
require_once('config.php');

// Startup
require_once(DIR_SYSTEM . 'startup.php');

start('admin');