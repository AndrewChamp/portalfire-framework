<?php


ob_start();	


/**
 * Includes all defines and instantiates the debug object.
 */
	require_once('config/config.php');
	$debug = debug::obtain();
	
	
/**
 * Display & logging of PHP errors.
 */ 
	ini_set("log_errors" , "1");
	ini_set("display_errors" , ($debug->dev ? "1" : "0"));

		
/**
 * Checks for PHP version number.
 * If the framework runs w/ no errors after you install then you can remove this if you like.
 */
	$debug->versionCheck('5.3.0');


/**
 * Loading of required classes & autoloading of classes only when they are instantiated.
 */
	require_once(PATH.VERSION.CORE.'class.crud.php');
	require_once(PATH.VERSION.CORE.'class.core.php');
	require_once('config/functions.php');
	
	spl_autoload_register(function($class){
		$directorys = array(PATH.VERSION.MODULES, INSTALL.THEME.'modules/');
        foreach($directorys as $directory):
            if(file_exists($directory.'class.'.$class.'.php')):
                require_once($directory.'class.'.$class.'.php');
				return;
            endif;
        endforeach;
	});


/**
 * Output info from database table.
 */
	$crud = crud::obtain(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
	$core = core::obtain($crud, TABLE_CONFIGURATION, $_GET['page']);
	
	
/**
 * Instantiate plugins/modules for the app here.
 */
	$sitemap = sitemap::obtain($crud, SITE_NAME, SITE_URL, SITE_DESCRIPTION);
	$humans = new humans(SITE_NAME, SITE_URL, SITE_CREATED, VERSION);

	
/**
 * Outputting the page.
 */
	include_once($core->header);
	$core->frame();
	include_once($core->footer);
	print $core->upTimeMarker;
	$debug->debugBar();


/**
 * Generate Sitemaps & robots.txt file.
 */
	//Examples:
	//$sitemap->build(TABLE_CONTENT, "active = '1'");
	//$sitemap->build(TABLE_BLOG, "active = '1' AND live_date <= NOW()");
	//$sitemap->build(TABLE_SERVICES, "active = '1'");
	$sitemap->robots();


ob_end_flush();


?>