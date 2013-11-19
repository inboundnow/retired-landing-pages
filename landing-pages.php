<?php
/*
Plugin Name: Landing Pages
Plugin URI: http://www.inboundnow.com/landing-pages/
Description: The first true all-in-one Landing Page solution for WordPress, including ongoing conversion metrics, a/b split testing, unlimited design options and so much more!
Version:  1.3.5
Author: David Wells, Hudson Atwell
Author URI: http://www.inboundnow.com/
*/

define('LANDINGPAGES_CURRENT_VERSION', '1.3.5' );
define('LANDINGPAGES_URLPATH', WP_PLUGIN_URL.'/'.plugin_basename( dirname(__FILE__) ).'/' );
define('LANDINGPAGES_PATH', WP_PLUGIN_DIR.'/'.plugin_basename( dirname(__FILE__) ).'/' );
define('LANDINGPAGES_PLUGIN_SLUG', 'landing-pages' );
define('LANDINGPAGES_FILE', __FILE__ );
define('LANDINGPAGES_STORE_URL', 'http://www.inboundnow.com/landing-pages/' );
$uploads = wp_upload_dir();
define('LANDINGPAGES_UPLOADS_PATH', $uploads['basedir'].'/landing-pages/templates/' );
define('LANDINGPAGES_UPLOADS_URLPATH', $uploads['baseurl'].'/landing-pages/templates/' );
$current_url = "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]."";

if (is_admin())
	if(!isset($_SESSION)){@session_start();}


/* load core files */
switch (is_admin()) :
	case true :
		/* loads admin files */
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

/* Singleton Shared Class Loads */
include_once('shared/inbound-shortcodes/inbound-shortcodes.php');  // Shared Shortcodes

/* Inbound Core Shared Files. Lead files take presidence */
add_action( 'plugins_loaded', 'inbound_load_shared_landing_pages' );
function inbound_load_shared_landing_pages(){
	include_once('shared/tracking/store.lead.php'); // Lead Storage from landing pages
	include_once('shared/classes/form.class.php');  // Mirrored forms
	include_once('shared/inboundnow/inboundnow.extension-licensing.php'); // Inboundnow Package Licensing
	include_once('shared/inboundnow/inboundnow.extension-updating.php'); // Inboundnow Package Updating
}