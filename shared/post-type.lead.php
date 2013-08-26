<?php 
if (!post_type_exists('wp-lead'))
{
	add_action('init', 'lp_wpleads_register');
	function lp_wpleads_register() {
		//echo $slug;exit;
		$labels = array(
			'name' => _x('Leads', 'post type general name'),
			'singular_name' => _x('Lead', 'post type singular name'),
			'add_new' => _x('Add New', 'Lead'),
			'add_new_item' => __('Add New Lead'),
			'edit_item' => __('Edit Lead'),
			'new_item' => __('New Leads'),
			'view_item' => __('View Leads'),
			'search_items' => __('Search Leads'),
			'not_found' =>  __('Nothing found'),
			'not_found_in_trash' => __('Nothing found in Trash'),
			'parent_item_colon' => ''
		);

		$args = array(
			'labels' => $labels,
			'public' => false,
			'publicly_queryable' => false,
			//'show_ui' => true,
			'show_ui' => false,
			'query_var' => true,
			//'menu_icon' => WPL_URL . '/images/leads.png',
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array('custom-fields','thumbnail')
		  );

		register_post_type( 'wp-lead' , $args );
		//flush_rewrite_rules( false );

	}
}