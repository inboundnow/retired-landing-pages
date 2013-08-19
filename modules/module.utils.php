<?php
/* 
function add_first_and_last($output) {
  $output = preg_replace('/class="menu-item/', 'class="first-menu-item menu-item', $output, 1);
  $output = substr_replace($output, 'class="last-menu-item menu-item', strripos($output, 'class="menu-item'), strlen('class="menu-item'));
  return $output;
}
add_filter('wp_nav_menu', 'add_first_and_last');
//Filtering a Class in Navigation Menu Item
add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);
function special_nav_class($classes, $item){
     if ( 'landing-page' == get_post_type() ) {
             $classes[] = 'lp_explode_menu';
     }
     return $classes;
}*/

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
	if('landing-page' == get_post_type() ) {
 	$arr = array();
    $template_id = get_post_meta($post->ID, 'lp-selected-template', true);
    $arr[] = 'template-' . $template_id;
 }
    return $arr;
}