<?php
/*
Plugin Name: Landing Pages
Plugin URI: http://www.inboundnow.com/landing-pages/
Description: The first true all-in-one Landing Page solution for WordPress, including ongoing conversion metrics, a/b split testing, unlimited design options and so much more!
Version:  1.5.5
Author: Inbound Now
Author URI: http://www.inboundnow.com/
Text Domain: landing-pages
Domain Path: shared/languages/landing-pages/
*/

define('LANDINGPAGES_CURRENT_VERSION', '1.5.5' );
define('LANDINGPAGES_URLPATH', WP_PLUGIN_URL.'/'.plugin_basename( dirname(__FILE__) ).'/' );
define('LANDINGPAGES_PATH', WP_PLUGIN_DIR.'/'.plugin_basename( dirname(__FILE__) ).'/' );
define('LANDINGPAGES_PLUGIN_SLUG', plugin_basename( dirname(__FILE__) ) );
define('LANDINGPAGES_FILE', __FILE__ );
define('LANDINGPAGES_STORE_URL', 'http://www.inboundnow.com/' );
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
	include_once('modules/module.metaboxes-global.php');
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

add_action( 'init', 'inbound_load_shared_lp_init' , 11 );
function inbound_load_shared_lp_init(){

}


/* Inbound Core Shared Files. Lead files take presidence */
add_action( 'plugins_loaded', 'inbound_load_shared_landing_pages' , 11 );
function inbound_load_shared_landing_pages(){

  /* Check if Shared Files Already Loaded */
  if (defined('INBOUDNOW_SHARED'))
    return;

  /* Define Shared Constant for Load Prevention*/
  define('INBOUDNOW_SHARED','loaded');

  /* Singleton Shared Class Loads */
  include_once('shared/shortcodes/inbound-shortcodes.php');  // Shared Shortcodes
  include_once('shared/classes/class.menu.php');  // Inbound Marketing Menu
  include_once('shared/classes/class.feedback.php');  // Inbound Feedback Form
  include_once('shared/classes/class.debug.php');  // Inbound Debug & Scripts Class
  include_once('shared/classes/class.compatibility.php');  // Inbound Compatibility Class
  include_once('shared/classes/class.form.php');  // Mirrored forms
  include_once('shared/tracking/store.lead.php'); // Lead Storage from landing pages

  include_once('shared/extend/inboundnow.extend.php');
  include_once('shared/extend/inboundnow.extension-licensing.php'); // Legacy - Inboundnow Package Licensing
  include_once('shared/extend/inboundnow.extension-updating.php'); // Legacy -Inboundnow Package Updating
  include_once('shared/extend/inboundnow.global-settings.php'); // Inboundnow Global Settings
  include_once('shared/assets/assets.loader.class.php');  // Load Shared CSS and JS Assets
  include_once('shared/functions/global.shared.functions.php'); // Global Shared Utility functions
  include_once('shared/functions/global.leads.cpt.php'); // Shared Lead functionality
  include_once('shared/metaboxes/template.metaboxes.php');  // Shared Shortcodes

}

/* lagacy - Conditional check LP active */
function lp_check_active()
{
  return 1;
}

/* Function to check This has been loaded for the tests */
function landingpages_is_active() {
  return true;
}

/* Function to check plugin code is running in travis */
function inbound_travis_check() {
  echo '*** Landing Pages Plugin is Running on Travis ***';
  return true;
}
