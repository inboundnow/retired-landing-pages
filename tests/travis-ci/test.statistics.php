<?php

/**
 * Tests to test that that testing framework is testing tests. Meta, huh?
 *
 * @package wordpress-plugins-tests
 */
class Tests_Statistics extends WP_UnitTestCase {

    /**
     * Run a simple test to ensure that the tests are running
     */
    function test_tests() {
        $this->assertTrue( true );
    }

    function test_check_if_landing_page_post_type_exist() {
        //lp_ab_testing_wp_insert_post_data
        $this->assertTrue(post_type_exists( 'landing-page' ));
    }

    function test_reset_landing_page_stats() {

        $landing_pages = get_posts( array(
            'post_type'=> 'landing-page'
        ));

        print_r($landing_pages);

    }

}

?>
