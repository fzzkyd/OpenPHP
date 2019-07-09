<?php
// Site
$_['site_url']              = HTTP_SERVER;
$_['site_ssl']              = HTTPS_SERVER;

// Database
$_['db_engine']             = DB_DRIVER; // mpdo, mssql, mysql, mysqli or postgre
$_['db_hostname']           = DB_HOSTNAME;
$_['db_username']           = DB_USERNAME;
$_['db_password']           = DB_PASSWORD;
$_['db_database']           = DB_DATABASE;
$_['db_port']               = DB_PORT;
$_['db_autostart']          = DB_AUTOSTART;

// Session
$_['session_autostart']     = true;

// Template
$_['template_cache']        = true;

// Error
$_['error_display']         = ERR_DISPLAY;
$_['error_log']             = ERR_LOG;
$_['error_filename']        = ERR_FILENAME;

// Actions
$_['action_default']        = 'common/dashboard';
$_['action_router']         = 'startup/router';
$_['action_error']          = 'error/not_found';

// Action Pre Events
$_['action_pre_action']     = array(
    'startup/startup',
	'startup/error'
);

// Action Events
$_['action_event']          = array(
	'controller/*/before' => array(
		// 0 => 'event/debug/before',
		100 => 'event/language/before'
	),
	'controller/*/after' => array(
		// 0 => 'event/debug/after',
		100 => 'event/language/after'
	),
	'view/*/before' => array(
		500  => 'event/language',
	)
);
