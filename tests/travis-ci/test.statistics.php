<?php

/**
 * Tests to test that that testing framework is testing tests. Meta, huh?
 *
 * @package wordpress-plugins-tests
 */
class Tests_Statistics extends WP_UnitTestCase {

    /**
     * Check if landing-page post type exists
     */
    function test_check_if_landing_page_post_type_exist() {
        $this->assertTrue(post_type_exists( 'landing-page' ));
    }

    /**
     * creates a dummy landing page for testing
     */
    function test_create_dummy_landing_page() {
        /* load the class used to create the dummy landing page */
        include_once LANDINGPAGES_PATH . 'modules/module.install.php';

        /* create a landing page */

        $this->lp_id =  inbound_create_default_post_type();
        echo $this->lp_id;
        $this->assertTrue( $this->lp_id );
    }


    /**
     * Set landing page stats to zero for testing
     */
    function test_reset_landing_page_stats() {

        $landing_pages = get_posts( array(
            'post_type'=> 'landing-page',
            'post_status' => 'draft'
        ));

        print_r($landing_pages);

        $landing_pages = get_posts( array(
            'post_type'=> 'post',
            'post_status' => 'draft'
        ));

        print_r($landing_pages);

    }

}

?>
