<?php

/**
 * Tests to test that that testing framework is testing tests. Meta, huh?
 *
 * @package wordpress-plugins-tests
 */
class WP_Test_WordPress_Plugin_Tests extends WP_UnitTestCase {

	/**
	* Run a simple test to ensure that the tests are running
	*/
	function test_tests() {
		$this->assertTrue( true );
	}

	/**
	* Ensure landing pages is active
	*/
	function test_lading_pages_activated() {
		$this->assertTrue( is_plugin_active( 'landing-pages/landing-pages.php' ) );
	}
	
	/**
	* Ensure that the Leads has been installed and activated.
	*/
	function test_leads_activated() {
		$this->assertTrue( is_plugin_active( 'leads/wordpress-leads.php' ) );
	}
	
	/**
	* Ensure calls to action plugin is active
	*/
	function test_calls_to_action_activated() {
		$this->assertTrue( is_plugin_active( 'cta/wordpress-cta.php' ) );
	}
	
	/**
	* Deactivate Calls to Action
	*/
	function test_deactivate_calls_to_action() {
		deactivate_plugins( 'cta/wordpress-cta.php' );
		
		if (!is_plugin_active( 'cta/wordpress-wordpress.php' ) ) {
			$this->assertTrue( true );
		} else {
			$this->assertTrue( false );
		}
		
	}
	
	/**
	* Deactivate Leads
	*/
	function test_deactivate_leads() {
		deactivate_plugins( 'leads/wordpress-leads.php' );
		
		if (!is_plugin_active( 'leads/wordpress-leads.php' ) ) {
			$this->assertTrue( true );
		} else {
			$this->assertTrue( false );
		}
		
	}
}

?>