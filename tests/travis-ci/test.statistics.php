<?php

/**
 * Tests to test that that testing framework is testing tests. Meta, huh?
 *
 * @package wordpress-plugins-tests
 */
class Tests_Statistics extends WP_UnitTestCase {

    /**
     * setup
     */
     function setUp() {
         /* includes */
         include_once LANDINGPAGES_PATH . 'modules/module.install.php';
         include_once LANDINGPAGES_PATH . 'classes/class.statistics.php';

         $lp_id = inbound_create_default_post_type();
         echo "\r\n";
         echo $lp_id."\r\n";

         /*  clear the stats */
         $variations = Landing_Pages_Statistics::get_variations( $lp_id );
         print_r($variations);
     }





    /**
     * Set landing page stats to zero for testing
     */
    function test_reset_landing_page_stats() {
        echo 2;
        echo get_option( 'siteurl' );
        print_r( get_option( 'lp_settings_general' ) );
        $landing_page = get_post( 4 );
        var_dump($landing_page);

    }

}


