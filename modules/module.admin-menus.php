<?php

// Create Sub-menu
add_action('admin_menu', 'lp_add_menu');

function lp_add_menu()
{
	//echo 1; exit;
	if (current_user_can('manage_options'))
	{

		add_submenu_page('edit.php?post_type=landing-page', __('Forms' , LANDINGPAGES_TEXT_DOMAIN), __('Create Forms' , LANDINGPAGES_TEXT_DOMAIN), 'manage_options', 'inbound-forms-redirect',100);

		add_submenu_page('edit.php?post_type=landing-page',__('Templates' , LANDINGPAGES_TEXT_DOMAIN), __('Manage Templates' , LANDINGPAGES_TEXT_DOMAIN), 'manage_options', 'lp_manage_templates','lp_manage_templates',100);

		add_submenu_page('edit.php?post_type=landing-page', __('Get Addons' , LANDINGPAGES_TEXT_DOMAIN), __('Get Addons' , LANDINGPAGES_TEXT_DOMAIN), 'manage_options', 'lp_store','lp_store_display',100);

		add_submenu_page('edit.php?post_type=landing-page', __('Global Settings' , LANDINGPAGES_TEXT_DOMAIN), __('Global Settings' , LANDINGPAGES_TEXT_DOMAIN), 'manage_options', 'lp_global_settings','lp_display_global_settings');

	}
}
