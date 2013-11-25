<?php

// Create Sub-menu
add_action('admin_menu', 'lp_add_menu');

function lp_add_menu()
{
	//echo 1; exit;
	if (current_user_can('manage_options'))
	{

		add_submenu_page('edit.php?post_type=landing-page', __('Forms' , INBOUNDNOW_LABEL ), __('Create Forms' , INBOUNDNOW_LABEL ), 'manage_options', 'inbound-forms-redirect',100);

		add_submenu_page('edit.php?post_type=landing-page',__('Templates' , INBOUNDNOW_LABEL ), __('Manage Templates' , INBOUNDNOW_LABEL ), 'manage_options', 'lp_manage_templates','lp_manage_templates',100);

		add_submenu_page('edit.php?post_type=landing-page', __('Get Addons' , INBOUNDNOW_LABEL ), __('Get Addons' , INBOUNDNOW_LABEL ), 'manage_options', 'lp_store','lp_store_display',100);

		add_submenu_page('edit.php?post_type=landing-page', __('Global Settings' , INBOUNDNOW_LABEL ), __('Global Settings' , INBOUNDNOW_LABEL ), 'manage_options', 'lp_global_settings','lp_display_global_settings');

	}
}
