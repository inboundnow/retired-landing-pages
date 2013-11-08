<?php

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
	