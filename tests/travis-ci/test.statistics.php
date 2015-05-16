<?php

/**
 * Tests to test that that testing framework is testing tests. Meta, huh?
 *
 * @package wordpress-plugins-tests
 */
class Tests_Statistics extends WP_UnitTestCase {

    var $lp_id;

    /**
     * setup
     */
     function setUp() {
         /* includes */
         include_once LANDINGPAGES_PATH . 'modules/module.install.php';
         include_once LANDINGPAGES_PATH . 'classes/class.statistics.php';

         $this->lp_id = inbound_create_default_post_type();

         /*  clear the stats */
         $variations = Landing_Pages_Statistics::get_variations($this->lp_id );
         foreach ($variations as $vid) {
             Landing_Pages_Statistics::set_impression_count( $this->lp_id , $vid, 0 );
             Landing_Pages_Statistics::set_conversion_count( $this->lp_id , $vid, 0 );
         }
     }





    /**
     * Set landing page stats to zero for testing
     */
    function read_statistics() {
        /* includes */
        include_once LANDINGPAGES_PATH . 'classes/class.statistics.php';

        echo 'static var'. $this->lp_id;
        $stats = Landing_Pages_Statistics::read_statistics( $this->lp_id );
        print_r($stats);

    }

}


