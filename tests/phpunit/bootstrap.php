<?php
/**
 * Bootstrap the plugin unit testing environment.
 *
 * @package wordpress-plugin-tests
 */

/* load wp environemnt */
require '../../../wp-load.php';

/* load plugins */
require '../../../wp-admin/includes/plugin.php';

/**
*  Replacement for wp_remote_get
*  processes javascript through PhantomJs
*/
function inbound_remote_get( $url ) {
	$response = wp_remote_get( 
		add_query_arg( 
			array( 'url' => urlencode( $url ) ) , 
			LANDINGPAGES_URLPATH . 'tests/phantomjs/server.php'
		) 
	);
	
	return $response;	
} 



