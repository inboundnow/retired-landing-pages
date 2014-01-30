<?php
/*
Plugin Name: Landing Pages
Plugin URI: http://www.inboundnow.com/landing-pages/
Description: The first true all-in-one Landing Page solution for WordPress, including ongoing conversion metrics, a/b split testing, unlimited design options and so much more!
Version:  1.4.6
Author: Inbound Now
Author URI: http://www.inboundnow.com/
Text Domain: landing-pages
Domain Path: shared/languages/landing-pages/
*/

define('LANDINGPAGES_CURRENT_VERSION', '1.4.6' );
define('LANDINGPAGES_URLPATH', WP_PLUGIN_URL.'/'.plugin_basename( dirname(__FILE__) ).'/' );
define('LANDINGPAGES_PATH', WP_PLUGIN_DIR.'/'.plugin_basename( dirname(__FILE__) ).'/' );
define('LANDINGPAGES_PLUGIN_SLUG', plugin_basename( dirname(__FILE__) ) );
define('LANDINGPAGES_FILE', __FILE__ );
define('LANDINGPAGES_STORE_URL', 'http://www.inboundnow.com/landing-pages/' );
$uploads = wp_upload_dir();
define('LANDINGPAGES_UPLOADS_PATH', $uploads['basedir'].'/landing-pages/templates/' );
define('LANDINGPAGES_UPLOADS_URLPATH', $uploads['baseurl'].'/landing-pages/templates/' );
if ( !defined( 'LANDINGPAGES_TEXT_DOMAIN' ) ) {
  define('LANDINGPAGES_TEXT_DOMAIN', 'landing-pages' );
}
define('INBOUNDNOW_LABEL', 'inboundnow-legacy' );


if (is_admin())
	if(!isset($_SESSION)){@session_start();}


/* load core files */
switch (is_admin()) :
	case true :
		/* loads admin files */
		// include_once('modules/module.cron.php'); not ready yet
		include_once('modules/module.language-support.php');
		include_once('modules/module.javascript-admin.php');
		include_once('modules/module.activate.php');
		include_once('modules/module.global-settings.php');
		include_once('modules/module.clone.php');
		include_once('modules/module.extension-updater.php');
		include_once('modules/module.extension-licensing.php');
		include_once('modules/module.admin-menus.php');
		include_once('modules/module.welcome.php');
		include_once('modules/module.install.php');
		include_once('modules/module.alert.php');
		include_once('modules/module.metaboxes.php');
		include_once('modules/module.landing-page.php');
		include_once('modules/module.load-extensions.php');
		include_once('modules/module.post-type.php');
		include_once('modules/module.track.php');
		include_once('modules/module.ajax-setup.php');
		include_once('modules/module.utils.php');
		include_once('modules/module.sidebar.php');
		include_once('modules/module.widgets.php');
		include_once('modules/module.cookies.php');
		include_once('modules/module.ab-testing.php');
		include_once('modules/module.click-tracking.php');
		include_once('modules/module.templates.php');
		include_once('modules/module.store.php');
		include_once('modules/module.customizer.php');


		BREAK;

	case false :
		/* load front-end files */
		include_once('modules/module.javascript-frontend.php');
		include_once('modules/module.post-type.php');
		include_once('modules/module.track.php');
		include_once('modules/module.ajax-setup.php');
		include_once('modules/module.utils.php');
		include_once('modules/module.sidebar.php');
		include_once('modules/module.widgets.php');
		include_once('modules/module.cookies.php');
		include_once('modules/module.ab-testing.php');
		include_once('modules/module.click-tracking.php');
		include_once('modules/module.landing-page.php');
		include_once('modules/module.customizer.php');

		BREAK;
endswitch;



/* Inbound Core Shared Files. Lead files take presidence */
add_action( 'plugins_loaded', 'inbound_load_shared_landing_pages' , 11 );
function inbound_load_shared_landing_pages(){

	/* Check if Shared Files Already Loaded */
	if (defined('INBOUDNOW_SHARED'))
		return;

	/* Define Shared Constant for Load Prevention*/
	define('INBOUDNOW_SHARED','loaded');

	/* Singleton Shared Class Loads */
	include_once('shared/inbound-shortcodes/inbound-shortcodes.php');  // Shared Shortcodes
	include_once('shared/classes/menu.class.php');  // Inbound Marketing Menu
	include_once('shared/classes/feedback.class.php');  // Inbound Feedback Form
	include_once('shared/classes/debug.class.php');  // Inbound Debug & Scripts Class
	include_once('shared/classes/compatibility.class.php');  // Inbound Compatibility Class
	include_once('shared/tracking/store.lead.php'); // Lead Storage from landing pages
	include_once('shared/classes/form.class.php');  // Mirrored forms
	include_once('shared/inboundnow/inboundnow.extend.php'); // Legacy
	include_once('shared/inboundnow/inboundnow.extension-licensing.php'); // Inboundnow Package Licensing
	include_once('shared/inboundnow/inboundnow.extension-updating.php'); // Inboundnow Package Updating
	include_once('shared/inboundnow/inboundnow.global-settings.php'); // Inboundnow Global Settings


}

/* lagacy - Conditional check LP active */
function lp_check_active()
{
	return 1;
}


