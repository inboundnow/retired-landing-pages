<?php


// REGISTER LANDING PAGES ACTIVATION
register_activation_hook( LANDINGPAGES_FILE , 'landing_page_activate');

function landing_page_activate($wp = '3.6', $php = '5.3', $cta = '1.2.1', $leads = '1.2.1')
{
	global $wp_version;
	if ( version_compare( phpversion(), $php, '<' ) ) {
	    $flag = 'PHP';
        $php_version = phpversion();
        $version = 'PHP' == $flag ? $php : $wp;
    	wp_die( __('<p>The <strong>WordPress Landing Pages</strong> plugin requires '.$flag.'  version '.$php.' or greater.</p> Your server is running version '. $php_version . '. Please Contact your hosting provider to update your PHP version. PHP 5.3 came out in December of 2010.'  , 'landing-pages') , __( 'Plugin Activation Error' , 'landing-pages') ,  array( 'response'=>200, 'back_link'=>TRUE ) );
		deactivate_plugins( basename( __FILE__ ) );
	} elseif ( version_compare( $wp_version, $wp, '<' ) ) {
	    $flag = 'WordPress';
	    wp_die( __('<p>The <strong>WordPress Landing Pages</strong> plugin requires'.$flag.'  version '.$wp.' or greater.</p>' , 'landing-pages'), __('Plugin Activation Error' , 'landing-pages'),  array( 'response'=>200, 'back_link'=>TRUE ) );
	    deactivate_plugins( basename( __FILE__ ) );
	} elseif (defined('WP_CTA_CURRENT_VERSION') && version_compare( WP_CTA_CURRENT_VERSION, $cta, '<' )) {
		$flag = __('WordPress Calls to Action' , 'landing-pages');
		wp_die( __('<p>The <strong>WordPress Landing Pages</strong> plugin requires '.$flag.'  version '.$cta.' or greater. <br><br>Please Update WordPress Call to Action Plugin to update & install WordPress Landing Pages</p>' , 'landing-pages') , __('Plugin Activation Error' , 'landing-pages') ,  array( 'response'=>200, 'back_link'=>TRUE ) );
	} elseif (defined('WPL_CURRENT_VERSION') && version_compare( WPL_CURRENT_VERSION, $leads, '<' )) {
		$flag = 'WordPress Leads';
		wp_die( __('<p>The <strong>WordPress Landing Pages</strong> plugin requires '.$flag.'  version '.$leads.' or greater. <br><br>Please Update WordPress Leads Plugin to update & install WordPress Landing Pages</p>' , 'landing-pages' ) , __( 'Plugin Activation Error' , 'landing-pages') ,  array( 'response'=>200, 'back_link'=>TRUE ) );
	} elseif (defined('LP_HOMEPAGE_CURRENT_VERSION') && version_compare( LP_HOMEPAGE_CURRENT_VERSION, '1.0.8', '<' )) {
		$flag = 'Homepage Addon';
		wp_die( __('<p>The <strong>WordPress Landing Pages</strong> plugin requires '.$flag.'  version 1.0.8 or greater. <br><br>Please Update Homepage Addon to update & install WordPress Landing Pages</p>' , 'landing-pages' ) , __( 'Plugin Activation Error' , 'landing-pages') ,  array( 'response'=>200, 'back_link'=>TRUE ) );
	} else {
		// Activate Plugin
		// Add Upgraded From Option
		$current_version = get_option( 'landing_page_version' );

		if ( $current_version )
			update_option( 'lp_version_upgraded_from', $current_version );

		add_option( 'lp_global_css', '', '', 'no' );
		add_option( 'lp_global_js', '', '', 'no' );
		add_option( 'lp_global_lp_slug', 'go', '', 'no' );
		update_option( 'lp_activate_rewrite_check', '1');
		update_option( 'landing_page_version', LANDINGPAGES_CURRENT_VERSION );
		set_transient( '_landing_page_activation_redirect', true, 30 );
		//global $wp_rewrite;
		//$wp_rewrite->flush_rules();
	}

    if (is_plugin_active('leads/wordpress-leads.php')) {
    	add_option( 'Leads_Activated', true );
	} else {
		delete_option( 'Leads_Activated');
	}

	do_action('lp_activate_update_db');
}

/* DB & FILESTRUCTURE MODIFIFCATION ACTIONS */
add_action('lp_activate_update_db', 'landing_pages_migrate_depreciated_templates');
function landing_pages_migrate_depreciated_templates()
{
	/* move copy of legacy core templates to the uploads folder and delete from core templates directory */
	$templates_to_move = array('rsvp-envelope','super-slick');
	chmod(LANDINGPAGES_UPLOADS_PATH, 0755);

	$template_paths = lp_get_core_template_paths();
	if (count($template_paths)>0)
	{
		foreach ($template_paths as $name)
		{
			if (in_array( $name, $templates_to_move ))
			{
				$old_path = LANDINGPAGES_PATH."templates/$name/";
				$new_path = LANDINGPAGES_UPLOADS_PATH."$name/";

				/*
				echo "oldpath: $old_path<br>";
				echo "newpath: $new_path<br>";
				*/

				@mkdir($new_path , 0775);
				chmod($old_path , 0775);

				lp_move_template_files( $old_path , $new_path );

				rmdir($old_path);
			}
		}
	}
}

function lp_move_template_files( $old_path , $new_path )
{

	$files = scandir($old_path);

	if (!$files)
		return;

	foreach ($files as $file) {
		if (in_array($file, array(".",".."))) continue;

		if ($file==".DS_Store")
		{
			unlink($old_path.$file);
			continue;
		}

		if (is_dir($old_path.$file))
		{
			@mkdir($new_path.$file.'/' , 0775);
			chmod($old_path.$file.'/' , 0775);
			lp_move_template_files( $old_path.$file.'/' , $new_path.$file.'/' );
			rmdir($old_path.$file);
			continue;
		}

		/*
		echo "oldfile:".$old_path.$file."<br>";
		echo "newfile:".$new_path.$file."<br>";
		*/

		if (copy($old_path.$file, $new_path.$file)) {
			unlink($old_path.$file);
		}
	}
	$delete = (isset($delete)) ? $delete : false;
	if (!$delete)
		return;

}


/* DEACTIVATION FUNCTIONS */
register_deactivation_hook( LANDINGPAGES_FILE , 'landing_page_deactivate');

function landing_page_deactivate()
{
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}