<?php
/**
*   Inbound Forms Shortcode Options
*   Forms code found in /shared/classes/form.class.php
*/

	$shortcodes_config['quick-forms'] = array(
		'no_preview' => false,
		'options' => array(
			'insert_default' => array(
						'name' => __('Insert Saved Form', INBOUND_LABEL),
						'desc' => __('Insert a Saved Form', INBOUND_LABEL),
						'type' => 'select',
						'options' => $form_names,
						'std' => 'none',
						'class' => 'main-form-settings',
			),
			'helper-block-one' => array(
					'name' => __('Name Name Name',  INBOUND_LABEL),
					'desc' => __('<span class="switch-to-form-builder button">Switch to form builder</span>',  INBOUND_LABEL),
					'type' => 'helper-block',
					'std' => '',
					'class' => 'helper-div',
			),
		),
		'shortcode' => '[inbound_forms id="{{insert_default}}" redirect="{{insert_default}}"]',
		'popup_title' => __('Quick Insert Inbound Form Shortcode',  INBOUND_LABEL)
	);
