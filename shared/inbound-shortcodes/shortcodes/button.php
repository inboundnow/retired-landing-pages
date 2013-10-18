<?php
/**
*   Button Shortcode
*   ---------------------------------------------------------------------------
*   @author 	: Rifki A.G
*   @copyright	: Copyright (c) 2013, FreshThemes
*                 http://www.freshthemes.net
*                 http://www.rifki.net
*   --------------------------------------------------------------------------- */

/* 	Shortcode generator config
 * 	----------------------------------------------------- */
	$shortcodes_config['button'] = array(
		'no_preview' => false,
		'options' => array(
			'content' => array(
				'name' => __('Label', INBOUND_LABEL),
				'desc' => __('Enter the button text label.', INBOUND_LABEL),
				'type' => 'text',
				'std' => 'Button Text'
			),
			'size' => array(
				'name' => __('Button Size', INBOUND_LABEL),
				'desc' => __('Select the button size.', INBOUND_LABEL),
				'type' => 'select',
				'options' => array(
					'small' => 'Small',
					'normal' => 'Normal',
					'large' => 'Large'
				),
				'std' => 'normal'
			),
			'color' => array(
				'name' => __('Button Color', INBOUND_LABEL),
				'desc' => __('Select the button color.', INBOUND_LABEL),
				'type' => 'select',
				'options' => array(
					'default' => 'Default',
					'black' => 'Black',
					'blue' => 'Blue',
					'brown' => 'Brown',
					'green' => 'Green',
					'orange' => 'Orange',
					'pink' => 'Pink',
					'purple' => 'Purple',
					'red' => 'Red',
					'silver' => 'Silver',
					'yellow' => 'Yellow',
					'white' => 'White'
				),
				'std' => 'default'
			),
			'icon' => array(
				'name' => __('Icon', INBOUND_LABEL),
				'desc' => __('Select an icon.', INBOUND_LABEL),
				'type' => 'select',
				'options' => $fontawesome,
				'std' => ''
			),
			'url' => array(
				'name' => __('Link Destination', INBOUND_LABEL),
				'desc' => __('Enter the destination URL.', INBOUND_LABEL),
				'type' => 'text',
				'std' => ''
			),
			'blank' => array(
				'name' => __('Link Targeting', INBOUND_LABEL),
				'checkbox_text' => __('Check to open the link in the new tab.', INBOUND_LABEL),
				'desc' => '',
				'type' => 'checkbox',
				'std' => '1'
			),
		),
		'shortcode' => '[button size="{{size}}" color="{{color}}" icon="{{icon}}" url="{{url}}" blank="{{blank}}"]{{content}}[/button]',
		'popup_title' => __('Insert Button Shortcode', INBOUND_LABEL)
	);

/* 	Add shortcode
 * 	----------------------------------------------------- */
	add_shortcode('button', 'fresh_shortcode_button');

	function fresh_shortcode_button( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'size' => '',
			'color' => '',
			'icon' => '',
			'url' => '',
			'blank' => ''
		), $atts));

		$class = "button $color $size";
		$icon = '<i class="icon-'. $icon .'"></i>&nbsp;';
		$target = ($blank) ? ' target="_blank"' : '';

		return '<a class="'. $class .'" href="'. $url .'"'. $target .'>'. $icon . $content .'</a>';
	}