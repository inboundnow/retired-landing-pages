<?php
/**
* WordPress Landing Page Config File
* Template Name:  Simple Two Column Template
*
* @package  WordPress Landing Pages
* @author 	David Wells
*/

do_action('lp_global_config'); // The lp_global_config function is for global code added by 3rd party extensions

//gets template directory name to use as identifier - do not edit - include in all template files
$key = lp_get_parent_directory(dirname(__FILE__));

$lp_data[$key]['info'] =
array(
	'data_type' => 'template', // Template Data Type
	'version' => "1.0.1", // Version Number
	'label' => "Simple Two Column", // Nice Name
	'category' => 'v1, 2 column layout', // Template Category
	'demo' => 'http://demo.inboundnow.com/go/simple-two-column/', // Demo Link
	'description'  => 'Two column landing page template.' // template description
);


//************************************************
// Add User Options to Your Landing Page Template
//************************************************

// Define Meta Options for template
// These values are returned in the template's index.php file with lp_get_value($post, $key, 'field-id') function
$lp_data[$key]['settings'] =
array(
    array(
        'label' => 'Display Social Media Share Buttons', // Label of field
        'description' => "Display Social Media Share Buttons", // field description
        'id' => 'display-social', // metakey.
        'type'  => 'radio', // text metafield type
        'default'  => '1', // default content
        'options' => array('1' => 'on','0'=>'off'), // options for radio
        'context'  => 'normal' // Context in screen for organizing options
        ),
    array(
        'label' => "Sidebar Layout",
        'description' => "","Align sidebar to the left or the right",
        'id'  => 'sidebar',
        'type'  => 'dropdown',
        'default'  => 'left',
        'options' => array('right'=>'Sidebar on right','left'=>'Sidebar on left'),
        'context'  => 'normal'
        ),

    array(
        'label' => 'Submit Button Color',
        'description' => "Submit Button Background Color",
        'id'  => 'submit-button-color',
        'type'  => 'colorpicker',
        'default'  => '5baa1e',
        'context'  => 'normal'
        ),
    array(
        'label' => 'Main Content Area Background Color',
        'description' => "Use this setting to change the template's main content area background color",
        'id'  => 'content-color',
        'type'  => 'colorpicker',
        'default'  => 'ffffff',
        'context'  => 'normal'
        ),
    array(
        'label' => 'Main Content Area Text Color',
        'description' => "Content Text Color",
        'id'  => 'content-text-color',
        'type'  => 'colorpicker',
        'default'  => '6F6F6F',
        'context'  => 'normal'
        ),
    array(
        'label' => 'Sidebar Background Color',
        'description' => "Sidebar Background Color",
        'id'  => 'sidebar-color',
        'type'  => 'colorpicker',
        'default'  => '2A4480',
        'context'  => 'normal'
        ),
    array(
        'label' => 'Sidebar Text Color',
        'description' => "Use this setting to change the sidebar text color",
        'id'  => 'sidebar-text-color',
        'type'  => 'colorpicker',
        'default'  => 'ffffff',
        'context'  => 'normal'
        ),
    array(
        'label' => 'Background Color',
        'description' => "Use this setting to change the template's background color",
        'id'  => 'body-color',
        'type'  => 'colorpicker',
        'default'  => 'BABBBE',
        'context'  => 'normal'
        ),
);
