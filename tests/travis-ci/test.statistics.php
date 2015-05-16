<?php

/**
 * Tests to test that that testing framework is testing tests. Meta, huh?
 *
 * @package wordpress-plugins-tests
 */
class Tests_Statistics extends WP_UnitTestCase {

    /**
     * creates a dummy landing page for testing
     */
    function setUp() {
        /* load the class used to create the dummy landing page */
        include_once LANDINGPAGES_PATH . 'modules/module.install.php';

        $option_name = "lp_settings_general";
        $option_key = "default_landing_page";
        $current_user = wp_get_current_user();
        add_option( $option_name, '' );

        //update_user_meta( get_current_user_id(), 'tgmpa_dismissed_notice', 0 ); // Clean dismiss settings
        //delete_option( 'lp_settings_general' );
        $lp_default_options = get_option($option_name);

        print_r($lp_default_options);
        /* create a landing page */
        $this->lp_id =  inbound_create_default_post_type();
        echo 'here' . $this->lp_id;
    }


    /**
     * Check if landing-page post type exists
     */
    function test_check_if_landing_page_post_type_exist() {
        $this->assertTrue(post_type_exists( 'landing-page' ));
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
