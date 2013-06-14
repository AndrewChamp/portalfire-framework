<?php

/**
 * Database credentials
 */
	define('DB_SERVER', "localhost");
	define('DB_USER', "");
	define('DB_PASSWORD', "");
	define('DB_DATABASE', "");

	
/**
 * Framework Setup
 */
	define('INSTALL', dirname(__DIR__));  // dirname(dirname(__FILE__))
	define('PATH', '/home/username/portalfire/');
	define('VERSION', '1.0');
	define('CORE', '/core/');
	define('MODULES', '/modules/');
	define('SITE_NAME', 'Your Site');
	define('SITE_URL', 'http://domain.com');
	

/**
 * Development & Theme
 */
	define('CACHE_VERSION', '1.0.0');
	define('DEVELOPMENT', false);
	define('TAKEDOWN', false);
	
	require_once(PATH.VERSION.CORE.'class.debug.php');
	$debug = debug::obtain();
	if(DEVELOPMENT && $debug->dev):
		define('THEME', '/themes/default/');
	else:
		define('THEME', '/themes/default/');
	endif;

	
/**
 * Tables being used
 */
	define('TABLE_CONFIGURATION', 'configuration');
	define('TABLE_CONTENT', 'content');
	define('TABLE_ERROR', 'error');

	
/**
 * Site Setup
 */
	define('GOOGLE_ANALYTICS', 'UA-00000000-00');
	define('ANALYTICS_URL', 'domain.com');
	define('SITE_DESCRIPTION', 'Your site description goes here.');
	define('SITE_CREATED', '2013-04-05');
	define('ALLOW_PHP', false);

	
?>