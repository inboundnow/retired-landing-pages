<?php
/**
 * Bootstrap the plugin unit testing environment.
 *
 * @package wordpress-plugin-tests
 */

/* load wp */
require '../../../wp-load.php';
require '../../../wp-admin/includes/plugin.php';

/* needed for testcase.php */
define( 'WP_TESTS_FORCE_KNOWN_BUGS', false );

/* include from VVV vagrant server */
if( DB_NAME == 'wordpress_default' ) {
	require '../../../../wordpress-develop/tests/phpunit/includes/testcase.php';
}
/* Include from Travis Ci DOT Org server (this location is setup in Travis.yml */
else {
	require '../../../../tests/phpunit/includes/testcase.php';
}

