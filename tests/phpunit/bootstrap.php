<?php
/**
 * Bootstrap the plugin unit testing environment.
 *
 * @package wordpress-plugin-tests
 */

/* load wp */
require  ABSPATH . '/wp-load.php';

/* needed for testcase.php */
define( 'WP_TESTS_FORCE_KNOWN_BUGS', false );

/* include testcase.php from WordPress's tests repo (on travis build ) */
require '../../../../tests/phpunit/includes/testcase.php';