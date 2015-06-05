<?php

/**
 * Test design to juse phantomjs to interact with front end. This test is disabled in favor for codeception tests
 *
 * @package wordpress-plugins-tests
 */
class Tests_Statistics extends PHPUnit_Framework_TestCase {

    var $lp_id;
    var $variations;

    /**
     * setup
     */
    function setUp() {
		return;
        /* includes */
        include_once LANDINGPAGES_PATH . 'modules/module.install.php';
        include_once LANDINGPAGES_PATH . 'classes/class.statistics.php';

        $this->lp_id = inbound_install_example_lander();
        /*  clear the stats */
        $this->variations = Landing_Pages_Statistics::get_variations($this->lp_id );
        foreach ($this->variations as $vid) {
            Landing_Pages_Statistics::set_impression_count( $this->lp_id , $vid, 0 );
            Landing_Pages_Statistics::set_conversion_count( $this->lp_id , $vid, 0 );
        }		
    }

	/**
	*  Tear down
	*/
	function tearDown() {	
		return;
		//delete_option('lp_settings_general');
		//wp_delete_post( $this->lp_id , false );
	}
	
	
    /**
     * Test is Landing_Pages_Statistics::read_statistics works
     */
    function test_read_statistics() {
		return;
		
        /* includes */
        include_once LANDINGPAGES_PATH . 'classes/class.statistics.php';

        $stats = Landing_Pages_Statistics::read_statistics( $this->lp_id );

        $this->assertEquals( count($stats) , 3 );
        $this->assertEquals( $stats['impressions'][0] , 0 );
        $this->assertEquals( $stats['conversions'][0] , 0 );
        $this->assertEquals( $stats['impressions'][1] , 0 );
        $this->assertEquals( $stats['conversions'][1] , 0 );
    }

    /**
     * launch a landing page
     */
    function test_landing_page_read() {
		return;
		
        /* includes */
        include_once LANDINGPAGES_PATH . 'classes/class.statistics.php';

        $permalink = get_post_permalink( $this->lp_id , false ); 
		echo $permalink."\r\n";	
		$permalink = 'http://local.wordpress.dev/go/ab-testing-landing-page-example-104/?lp-variation-id=1';
		$permalink = 'http://local.wordpress.dev/';
        print_r(inbound_remote_get( $permalink ));   
		/*
		sleep(5);
        $response = inbound_remote_get( $permalink );
		sleep(5);
        $response = inbound_remote_get( $permalink );
		sleep(5);
        $response = inbound_remote_get( $permalink );
		sleep(5);
        $response = inbound_remote_get( add_query_arg( array('lp-variation-id'=> 0  ) , $permalink ) );
		sleep(5);
        $response = inbound_remote_get( add_query_arg( array('lp-variation-id'=> 1  ) , $permalink ) );
		sleep(5);
		*/
        $stats = Landing_Pages_Statistics::read_statistics( $this->lp_id );
        print_r($stats);
		
        $this->assertEquals( $stats['impressions'][0] , 3 );
        $this->assertEquals( $stats['conversions'][0] , 0 );
        $this->assertEquals( $stats['impressions'][1] , 3 );
        $this->assertEquals( $stats['conversions'][1] , 0 );
    }
}


