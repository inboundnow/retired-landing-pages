<?php
/**
 * Bootstrap the plugin unit testing environment.
 *
 * Edit 'active_plugins' setting below to point to your main plugin file.
 *
 * @package wordpress-plugin-tests
 */

// Activates this plugin in WordPress so it can be tested.
$GLOBALS['wp_tests_options'] = array(
	  'active_plugins' => array(
		'landing-pages/landing-pages.php',
		'cta/wordpress-cta.php',
		'leads/wordpress-leads.php',
	  ),
);


/**
*  Load WordPress's testing environment boostrap.php. This is not shipped with the git repo but is unloaded into the travis build unless WP_DEVELOP_DIR is set with a custom locatin.
*/
if( false !== getenv( 'WP_DEVELOP_DIR' ) ) {
	require getenv( 'WP_DEVELOP_DIR' ) . '/tests/phpunit/includes/bootstrap.php';
} else {
	require '../../../../tests/phpunit/includes/bootstrap.php';
}
 
/**
*  WordPress Dev Environment rebuilds the datbase on bootstrap.
*/
update_option( 'siteurl' , 'http://inboundsoon.dev' );
update_option( 'home' , 'http://inboundsoon.dev' );
?>