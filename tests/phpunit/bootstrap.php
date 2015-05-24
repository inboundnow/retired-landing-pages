<?php
/**
 * Bootstrap the plugin unit testing environment.
 *
 * Edit 'active_plugins' setting below to point to your main plugin file.
 *
 * @package wordpress-plugin-tests
 */

/* needed for testcase.php */
define( 'WP_TESTS_FORCE_KNOWN_BUGS', false );

/* include testcase.php from WordPress's tests repo (on travis build ) */
require '../../../../tests/phpunit/includes/testcase.php';