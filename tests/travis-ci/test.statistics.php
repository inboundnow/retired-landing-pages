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
    function test_create_demo_lander() {
        /* load the class used to create the dummy landing page */
        include_once LANDINGPAGES_PATH . 'modules/module.install.php';
        $options = get_option("lp_settings_general");
        print_r($options);
        $this->lp_id = $options['default_landing_page'];
        echo 'here' . $this->lp_id . "\r\n";;
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
            'ID'=> $this->lp_id
        ));

        print_r($landing_pages);

    }

}

?>
