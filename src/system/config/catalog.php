<?php
// Site
$_['site_url']               = HTTP_SERVER;
$_['site_ssl']               = HTTPS_SERVER;

// Url
$_['url_autostart']          = false;

// Database
$_['db_engine']              = DB_DRIVER; // mpdo, mssql, mysql, mysqli or postgre
$_['db_hostname']            = DB_HOSTNAME;
$_['db_username']            = DB_USERNAME;
$_['db_password']            = DB_PASSWORD;
$_['db_database']            = DB_DATABASE;
$_['db_port']                = DB_PORT;
$_['db_autostart']           = DB_AUTOSTART;

// Session
$_['session_autostart']      = true;
$_['session_engine']         = 'file';
$_['session_name']           = 'OPSESSID';

// Template
$_['template_engine']        = 'twig';
$_['template_directory']     = 'default/template/';
$_['template_cache']         = true;

// Autoload Libraries
$_['library_autoload']   	 = array();

// Error
$_['error_display']          = ERR_DISPLAY;
$_['error_log']              = ERR_LOG;
$_['error_filename']         = ERR_FILENAME;

// Actions
$_['action_default']         = 'common/home';
$_['action_router']          = 'startup/router';
$_['action_error']           = 'error/not_found';

// Actions
$_['action_pre_action']      = array(
	'startup/session',
	'startup/startup',
	'startup/error'
);

// Action Events
$_['action_event']           = array(
	'controller/*/before' => array(
		// 0 => 'event/debug/before',
		100 => 'event/language/before'
	),
	'controller/*/after' => array(
		// 0 => 'event/debug/after',
		100 => 'event/language/after'
	),
	'view/*/before' => array(
		500  => 'event/language'
	)
);
