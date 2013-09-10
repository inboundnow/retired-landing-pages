<?php
/**
 * Utility Functions
 */

add_action( 'init', 'inbound_meta_debug' );
if (!function_exists('inbound_meta_debug')) {
	function inbound_meta_debug(){
	//print all global fields for post
	if (isset($_GET['debug'])) {
			global $wpdb;
			$data   =   array();
			$wpdb->query("
			  SELECT `meta_key`, `meta_value`
				FROM $wpdb->postmeta
				WHERE `post_id` = ".$_GET['post']."
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

// Fix SEO Title Tags to not use the_title
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

// Add Custom Class to Landing Page Nav Menu to hide/remove
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

///////// Remove all base css from the current active wordpress theme in landing pages
//currently removes all css from wp_head and re-enqueues the admin bar css.
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
				$wp_styles->queue = array();
				//wp_register_style( 'admin-bar' );
				wp_enqueue_style( 'admin-bar' );
			}	
		}	
	}

}
// Remove all body_classes from custom landing page templates - disabled but you can use the function above to model native v non-native template conditionals.
//add_action('wp','landingpage_remove_plugin_filters');

function landingpage_remove_plugin_filters() {

    global $wp_filter;
    global $wp;
	
    if ($wp->query_vars["post_type"] == 'landing-page') {
       add_filter('body_class','landing_body_class_names');
    }
}   

function landing_body_class_names($classes) {
	global $post;
	
	if('landing-page' == get_post_type() ) 
	{
		$arr = array();
		$template_id = get_post_meta($post->ID, 'lp-selected-template', true);
		$arr[] = 'template-' . $template_id;
	}
	
    return $arr;
}

?>