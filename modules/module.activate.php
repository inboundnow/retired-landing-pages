<?php


// REGISTER LANDING PAGES ACTIVATION
register_activation_hook( LANDINGPAGES_FILE , 'landing_page_activate');

function landing_page_activate()
{
	//delete_transient( '_landing_page_activation_redirect' );
	add_option( 'lp_global_css', '', '', 'no' );
	add_option( 'lp_global_js', '', '', 'no' );
	add_option( 'lp_global_lp_slug', 'go', '', 'no' );
	update_option( 'lp_activate_rewrite_check', '1');
	set_transient( '_landing_page_activation_redirect', true, 30 );
	//global $wp_rewrite;
	//$wp_rewrite->flush_rules();

}

register_deactivation_hook( LANDINGPAGES_FILE , 'landing_page_deactivate');

function landing_page_deactivate()
{
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}

/* CHECKS TO MAKE SURE THIS PLUGIN IS EXISTS - LEGACY CODE USED BY OTHER INBOUNDNOW PLUGINS AND EXTENSIONS */
function lp_check_active()
{	
	return 1;
}
