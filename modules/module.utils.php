<?php

/**
 * Utility Functions
 */
 
/* REMOTE CURL CONNECTION - WE MAY SHOULD DEPRECIATE IN FAVOR OF WP_REMOTE_GET*/
if (!function_exists('lp_remote_connect')) {
function lp_remote_connect($url)
{
	$method1 = ini_get('allow_url_fopen') ? "Enabled" : "Disabled";
	if ($method1 == 'Disabled')
	{
		//do curl
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "$url");
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
		curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
		curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
		$string = curl_exec($ch);
	}
	else
	{
		$string = file_get_contents($url);
	}
	
	return $string;
}
}


add_action( 'init', 'inbound_meta_debug' );
if (!function_exists('inbound_meta_debug')) {
	function inbound_meta_debug()
	{
		//print all global fields for post
		if (isset($_GET['debug']) && ( isset($_GET['post']) && is_numeric($_GET['post']) ) )
		{
			global $wpdb;
			$data   =   array();
			$wpdb->query("
			  SELECT `meta_key`, `meta_value`
				FROM $wpdb->postmeta
				WHERE `post_id` = ".mysql_real_escape_string($_GET['post'])."
			");

			foreach($wpdb->last_result as $k => $v){
				$data[$v->meta_key] =   $v->meta_value;
			};
			if (isset($_GET['post']))
			{
				echo "<pre>";
				print_r( $data);
				echo "</pre>";
			}
		}
	}
}

/* Fix SEO Title Tags to not use the_title */
//add_action('wp','landingpage_seo_title_filters');
function landingpage_seo_title_filters() {

    global $wp_filter;
    global $wp;
	print_r($wp);exit;
    if (strstr())
	{
       add_filter('wp_title', 'lp_fix_seo_title', 100);
    }
}

function lp_fix_seo_title()
{
	if ('landing-page' == get_post_type())
	{
		global $post;
	if (get_post_meta($post->ID, '_yoast_wpseo_title', true)) {
		$seotitle = get_post_meta($post->ID, '_yoast_wpseo_title', true) . " ";
	// All in one seo get_post_meta($post->ID, '_aioseop_title', true) for future use
	} else {
		$seotitle = $seotitle = get_post_meta($post->ID, 'lp-main-headline', true) . " "; }
	}
	return $seotitle;
}

/* Add Custom Class to Landing Page Nav Menu to hide/remove */
// remove_filter( 'wp_nav_menu_args', 'lp_wp_nav_menu_args' ); // Removes navigation hide
add_filter( 'wp_nav_menu_args', 'lp_wp_nav_menu_args' );
function lp_wp_nav_menu_args( $args = '' )
{
	global $post;
	if ( 'landing-page' == get_post_type() ) {
		$nav_status = get_post_meta($post->ID, 'default-lp_hide_nav', true);
		if ($nav_status === 'off' || empty($nav_status)) {
			if (isset($args['container_class']))
			{
				$current_class = " ".$args['container_class'];
			}

			$args['container_class'] = "custom_landing_page_nav{$current_class}";

			$args['echo'] = false; // works!
		}
	}


	return $args;
}

/* Remove all base css from the current active wordpress theme in landing pages */
/* currently removes all css from wp_head and re-enqueues the admin bar css. */
add_action('wp_print_styles', 'lp_remove_all_styles', 100);
function lp_remove_all_styles()
{
	if (!is_admin())
	{
		if ( 'landing-page' == get_post_type() )
		{
			global $post;
			$template = get_post_meta($post->ID, 'lp-selected-template', true);

			if (strstr($template,'-slash-'))
			{
				$template = str_replace('-slash-','/',$template);
			}

			$my_theme =  wp_get_theme($template);

			if ($my_theme->exists()||$template=='default')
			{
				return;
			}
			else
			{
				global $wp_styles;
				$wp_styles->queue = array('');
				//wp_register_style( 'admin-bar' );
				wp_enqueue_style( 'admin-bar' );
			}
		}
	}

}

/* Remove all body_classes from custom landing page templates - disabled but you can use the function above to model native v non-native template conditionals. */
//add_action('wp','landingpage_remove_plugin_filters');
function landingpage_remove_plugin_filters() {

    global $wp_filter;
    global $wp;

    if ($wp->query_vars["post_type"] == 'landing-page') {
       add_filter('body_class','landing_body_class_names');
    }
}

function landing_body_class_names($classes)
{
	global $post;

	if('landing-page' == get_post_type() )
	{
		$arr = array();
		$template_id = get_post_meta($post->ID, 'lp-selected-template', true);
		$arr[] = 'template-' . $template_id;
	}

    return $arr;
}


add_filter( 'wpseo_metabox_prio', 'lp_wpseo_priority'); 
function lp_wpseo_priority(){return 'low';}

add_action( 'in_admin_header', 'lp_in_admin_header');
function lp_in_admin_header() 
{
	global $post; 
	global $wp_meta_boxes;
	
	if (isset($post)&&$post->post_type=='landing-page') 
	{
		unset( $wp_meta_boxes[get_current_screen()->id]['normal']['core']['postcustom'] ); 
	}
}


?>