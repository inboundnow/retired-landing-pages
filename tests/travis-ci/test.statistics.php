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

    function test_reset_landing_page_stats() {

        $landing_pages = get_posts( array(
            'post_type'=> 'landing-page'
        ));
        echo 2;
        print_r($landing_pages);

    }

}

?>
