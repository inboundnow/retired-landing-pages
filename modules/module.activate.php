<?php


// REGISTER LANDING PAGES ACTIVATION
register_activation_hook( LANDINGPAGES_FILE , 'landing_page_activate');

function landing_page_activate($wp = '3.6', $php = '5.2.4', $cta = '1.1.1', $leads = '1.1.1')
{
	global $wp_version;
	if ( version_compare( PHP_VERSION, $php, '<' ) ) 
	{
	    $flag = 'PHP';
	    $version = 'PHP' == $flag ? $php : $wp;
		wp_die('<p>The <strong>WordPress Landing Pages</strong> plugin requires'.$flag.'  version '.$php.' or greater.</p>','Plugin Activation Error',  array( 'response'=>200, 'back_link'=>TRUE ) );
		deactivate_plugins( basename( __FILE__ ) );
	} 
	elseif ( version_compare( $wp_version, $wp, '<' ) ) 
	{
	    $flag = 'WordPress';
	    wp_die('<p>The <strong>WordPress Landing Pages</strong> plugin requires'.$flag.'  version '.$wp.' or greater.</p>','Plugin Activation Error',  array( 'response'=>200, 'back_link'=>TRUE ) );
	    deactivate_plugins( basename( __FILE__ ) );
	} 
	elseif (defined('WP_CTA_CURRENT_VERSION') && version_compare( WP_CTA_CURRENT_VERSION, $cta, '<' ))
	{
		$flag = 'WordPress Calls to Action';
		wp_die('<p>The <strong>WordPress Landing Pages</strong> plugin requires '.$flag.'  version '.$cta.' or greater. <br><br>Please Update WordPress Call to Action Plugin to update WordPress Landing Pages</p>','Plugin Activation Error',  array( 'response'=>200, 'back_link'=>TRUE ) );
	} 
	elseif (defined('LEADS_CURRENT_VERSION') && version_compare( LEADS_CURRENT_VERSION, $leads, '<' ))
	{
		$flag = 'WordPress Leads';
		wp_die('<p>The <strong>WordPress Landing Pages</strong> plugin requires '.$flag.'  version '.$leads.' or greater. <br><br>Please Update WordPress Leads Plugin to update WordPress Landing Pages</p>','Plugin Activation Error',  array( 'response'=>200, 'back_link'=>TRUE ) );
	} 
	else 
	{
		// Activate Plugin
		// Add Upgraded From Option
		$current_version = get_option( 'landing_page_version' );
		
		if ( $current_version ) 
		{
			update_option( 'lp_version_upgraded_from', $current_version );
		}
		
		add_option( 'lp_global_css', '', '', 'no' );
		add_option( 'lp_global_js', '', '', 'no' );
		add_option( 'lp_global_lp_slug', 'go', '', 'no' );
		
		update_option( 'lp_activate_rewrite_check', '1');
		update_option( 'landing_page_version', LANDINGPAGES_CURRENT_VERSION );
		
		set_transient( '_landing_page_activation_redirect', true, 30 );
		//global $wp_rewrite;
		//$wp_rewrite->flush_rules();
	}
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
