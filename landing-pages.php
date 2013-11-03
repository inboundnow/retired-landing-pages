<?php
/*
Plugin Name: Landing Pages
Plugin URI: http://www.inboundnow.com/landing-pages/
Description: The first true all-in-one Landing Page solution for WordPress, including ongoing conversion metrics, a/b split testing, unlimited design options and so much more!
Version:  1.3.1
Author: David Wells, Hudson Atwell
Author URI: http://www.inboundnow.com/
*/

define('LANDINGPAGES_CURRENT_VERSION', '1.3.1' );
define('LANDINGPAGES_URLPATH', WP_PLUGIN_URL.'/'.plugin_basename( dirname(__FILE__) ).'/' );
define('LANDINGPAGES_PATH', WP_PLUGIN_DIR.'/'.plugin_basename( dirname(__FILE__) ).'/' );
define('LANDINGPAGES_PLUGIN_SLUG', 'landing-pages' );
define('LANDINGPAGES_STORE_URL', 'http://www.inboundnow.com/landing-pages/' );
$uploads = wp_upload_dir();
define('LANDINGPAGES_UPLOADS_PATH', $uploads['basedir'].'/landing-pages/templates/' );
define('LANDINGPAGES_UPLOADS_URLPATH', $uploads['baseurl'].'/landing-pages/templates/' );
$current_url = "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]."";

/* load frontend-only and load global core files */
include_once('functions/functions.global.php');
include_once('modules/module.post-type.php');
include_once('modules/module.track.php');
include_once('modules/module.ajax-setup.php');
include_once('modules/module.utils.php');
include_once('modules/module.sidebar.php');
include_once('modules/module.widgets.php');
include_once('modules/module.cookies.php');
include_once('modules/module.ab-testing.php');
add_action('init', 'lp_click_track_redirect', 11); // Click Tracking init
include_once('modules/module.click-tracking.php');


/* Inbound Core Shared Files. Lead files take presidence */
add_action( 'plugins_loaded', 'inbound_load_shared_landing_pages' );
function inbound_load_shared_landing_pages(){
	include_once('shared/tracking/store.lead.php'); // Lead Storage from landing pages
	include_once('shared/classes/form.class.php');  // Mirrored forms
	include_once('shared/inboundnow/inboundnow.extension-licensing.php'); // Inboundnow Package Licensing
	include_once('shared/inboundnow/inboundnow.extension-updating.php'); // Inboundnow Package Updating
}
include_once('shared/inbound-shortcodes/inbound-shortcodes.php');  // Shared Shortcodes

if (is_admin())
{
if(!isset($_SESSION)){@session_start();}

include_once('functions/functions.admin.php');
include_once('modules/module.global-settings.php');
include_once('modules/module.clone.php');
include_once('modules/module.extension-updater.php');
include_once('modules/module.extension-licensing.php');
include_once('modules/module.install.php');
include_once('modules/module.alert.php');
}

// REGISTER LANDING PAGES ACTIVATION
register_activation_hook(__FILE__, 'landing_page_activate');

function landing_page_activate()
{

	add_option( 'lp_global_css', '', '', 'no' );
	add_option( 'lp_global_js', '', '', 'no' );
	add_option( 'lp_global_lp_slug', 'go', '', 'no' );
	update_option( 'lp_activate_rewrite_check', '1');

	//global $wp_rewrite;
	//$wp_rewrite->flush_rules();

}

register_deactivation_hook(__FILE__, 'landing_page_deactivate');

function landing_page_deactivate()
{
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}


//LOAD FUNCTIONS THAT WILL BE USED BY NATIVE TEMPLATES
add_action('lp_init', 'inbound_include_template_functions');

if (!function_exists('inbound_include_template_functions')) {
	function inbound_include_template_functions(){
		include_once('shared/functions.templates.php');
	}
}

// PREPARE LANDING PAGE TEMPLATE DATA
if (is_admin())
{
	include_once('load.extensions.php');
	include_once('modules/module.metaboxes.php');
}


// Hook function that will apply css, js
add_action('wp_head','landing_pages_insert_custom_head');
function landing_pages_insert_custom_head() {
	global $post;

   if (isset($post)&&'landing-page'==$post->post_type)
   {

		$custom_css_name = apply_filters('lp_custom_css_name','lp-custom-css');
		$custom_js_name = apply_filters('lp_custom_js_name','lp-custom-js');
		$custom_css = get_post_meta($post->ID, $custom_css_name, true);
		$custom_js = get_post_meta($post->ID, $custom_js_name, true);

		//Print Custom CSS
		if (!stristr($custom_css,'<style'))
		{
			echo '<style type="text/css" id="lp_css_custom">'.$custom_css.'</style>';
		}
		else
		{
			echo $custom_css;
		}
		//Print Custom JS
		if (!stristr($custom_js,'<script'))
		{
			echo '<script type="text/javascript" id="lp_js_custom">jQuery(document).ready(function($) {
			'.$custom_js.' });</script>';
		}
		else
		{
			echo $custom_js;
		}
   }
}


add_filter('the_content','landing_pages_add_conversion_area', 20);
add_filter('get_the_content','landing_pages_add_conversion_area', 20);
function landing_pages_add_conversion_area($content)
{

	if ('landing-page'==get_post_type() && !is_admin())
	{

		global $post;

		remove_action('the_content', 'landing_pages_add_conversion_area');

		$key = get_post_meta($post->ID, 'lp-selected-template', true);
		$key = apply_filters('lp_selected_template',$key);

		if (strstr($key,'-slash-'))
		{
			$key = str_replace('-slash-','/',$key);
		}

		$my_theme =  wp_get_theme($key);
		//echo $key;
		if ($my_theme->exists()||$key=='default')
		{

			global $post;
		    $wrapper_class = "";

			get_post_meta($post->ID, "default-conversion-area-placement", true);


			$position = get_post_meta($post->ID, "{$key}-conversion-area-placement", true);

			$position = apply_filters('lp_conversion_area_position', $position, $post, $key);

			$_SESSION['lp_conversion_area_position'] = $position;

			$conversion_area = lp_conversion_area(null,null,true,true);


			$standardize_form = get_option( 'lp-main-landing-page-auto-format-forms' , 0); // conditional to check for options
			if ($standardize_form)
			{
				$wrapper_class = lp_discover_important_wrappers($conversion_area);
				$conversion_area = lp_rebuild_attributes($conversion_area);
			}

			$conversion_area = "<div id='lp_container' class='$wrapper_class'>".$conversion_area."</div>";

			if ($position=='top')
			{
				$content = $conversion_area.$content;
			}
			else if ($position=='bottom')
			{
				$content = $content.$conversion_area;
			}
			else if ($position=='widget')
			{
				$content = $content;
			}
			else
			{
				$conversion_area = str_replace("id='lp_container'","id='lp_container' class='lp_form_$position' style='float:$position'",$conversion_area);
				$content = $conversion_area.$content;

			}

		}

	}


	return $content;
}


if (is_admin())
{
	include_once('modules/module.templates.php');
	include_once('modules/module.store.php');

	// Create Sub-menu

	add_action('admin_menu', 'lp_add_menu');

	function lp_add_menu()
	{
		//echo 1; exit;
		if (current_user_can('manage_options'))
		{

			add_submenu_page('edit.php?post_type=landing-page', 'Forms', 'Create Forms', 'manage_options', 'inbound-forms-redirect',100);

			add_submenu_page('edit.php?post_type=landing-page', 'Templates', 'Manage Templates', 'manage_options', 'lp_manage_templates','lp_manage_templates',100);

			add_submenu_page('edit.php?post_type=landing-page', 'Get Addons', 'Get Addons', 'manage_options', 'lp_store','lp_store_display',100);

			add_submenu_page('edit.php?post_type=landing-page', 'Global Settings', 'Global Settings', 'manage_options', 'lp_global_settings','lp_display_global_settings');

			// Add settings page for frontend editor
    		add_submenu_page('edit.php?post_type=landing-page', __('Editor','Editor'), __('Editor','Editor'), 'manage_options', 'lp-frontend-editor', 'lp_frontend_editor_screen');

		}
	}

}

// MAKE SURE WE USE THE RIGHT TEMPLATE
add_filter('single_template', 'lp_custom_template');

function lp_custom_template($single) {
    global $wp_query, $post, $query_string;
	//echo 2;exit;
	if ($post->post_type == "landing-page")
	{
		$template = get_post_meta($post->ID, 'lp-selected-template', true);
		$template = apply_filters('lp_selected_template',$template);


		if (isset($template))
		{

			if (strstr($template,'-slash-'))
			{
				$template = str_replace('-slash-','/',$template);
			}

			$my_theme =  wp_get_theme($template);

			if ($my_theme->exists())
			{
				return "";
			}
			else if ($template!='default')
			{
				$template = str_replace('_','-',$template);
				//echo LANDINGPAGES_URLPATH.'templates/'.$template.'/index.php'; exit;
				if (file_exists(LANDINGPAGES_PATH.'templates/'.$template.'/index.php'))
				{
					//query_posts ($query_string . '&showposts=1');
					return LANDINGPAGES_PATH.'templates/'.$template.'/index.php';
				}
				else
				{
					//query_posts ($query_string . '&showposts=1');
					return LANDINGPAGES_UPLOADS_PATH.$template.'/index.php';
				}
			}
		}
	}

    return $single;
}

// LOAD THE TEMLATE CUSTOMIZER MODULE
include_once('modules/module.customizer.php');