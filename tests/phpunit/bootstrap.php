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

/* include testcase.php from WordPress's tests repo (on travis build ) */
require '../../../../tests/phpunit/includes/testcase.php';

global $wp_rewrite;
$wp_rewrite->set_permalink_structure('/%postname%/');
$wp_rewrite->flush_rules();