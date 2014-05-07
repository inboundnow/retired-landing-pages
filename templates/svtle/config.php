<?php
/**
* Template Name:  Svtle Template
* @package  WordPress Landing Pages
* @author 	David Wells
*/

do_action('lp_global_config'); // global config action hook

//gets template directory name to use as identifier - do not edit - include in all template files
$key = lp_get_parent_directory(dirname(__FILE__));

$lp_data[$key]['info'] =
array(
	'data_type' => 'template', // Template Data Type
	'version' => "1.0.1", // Version Number
	'label' => "Svbtle", // Nice Name
	'category' => 'v1, 2 column layout', // Template Category
	'demo' => 'http://demo.inboundnow.com/go/sbvtle-lander-preview/', // Demo Link
	'description'  => 'Clean and minimalistic design for a straight forward conversion page.' // template description
);

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
        'options' => array('1' => 'on','0'=>'off'),
        'context'  => 'normal' // Context in screen for organizing options
        ),
    array(
        'label' => 'Sidebar Layout',
        'description' => "Align sidebar to the left or the right",
        'id'  => 'sidebar',
        'type'  => 'dropdown',
        'default'  => 'left',
        'options' => array('left'=>'Sidebar on left', 'right'=>'Sidebar on right'),
        'context'  => 'normal'
        ),
    array(
        'label' => 'Submit Button Background Color',
        'description' => "Submit Button Background Color",
        'id'  => 'submit-button-color',
        'type'  => 'colorpicker',
        'default'  => '5baa1e',
        'context'  => 'normal'
        ),
    array(
        'label' => 'Logo Image',
        'description' => "Upload Your Logo (300x110px)",
        'id'  => 'logo',
        'type'  => 'media',
        'default'  => '/wp-content/plugins/landing-pages/templates/svtle/assets/images/inbound-logo.png',
        'context'  => 'normal'
        ),
    array(
        'label' => 'Content Area Background Color',
        'description' => "Content Area Background Color",
        'id'  => 'body-color',
        'type'  => 'colorpicker',
        'default'  => 'ffffff',
        'context'  => 'normal'
        ),
    array(
        'label' => 'Content Area Text Color',
        'description' => "Use this setting to change the template's text color",
        'id'  => 'page-text-color',
        'type'  => 'colorpicker',
        'default'  => '4D4D4D',
        'context'  => 'normal'
        ),
	array(
        'label' => 'Sidebar color',
        'description' => "Use this setting to change the template's sidebar color",
        'id'  => 'sidebar-color',
        'type'  => 'colorpicker',
        'default'  => 'ffffff',
        'context'  => 'normal'
        ),
	array(
        'label' => "Sidebar Text Color",
        'description' => "Use this setting to change the template's sidebar text color",
        'id'  => 'sidebar-text-color',
        'type'  => 'colorpicker',
        'default'  => '000000',
        'context'  => 'normal'
        ),
  	array(
        'label' => 'Header Color',
        'description' => "Use this setting to change the template's header color",
        'id'  => 'header-color',
        'type'  => 'colorpicker',
        'default'  => 'ffffff',
        'context'  => 'normal'
        ),
   array(
        'label' => 'Display form below content on mobile?',
        'description' => "Toggle this on to render the form below the content in the mobile view",
        'id'  => 'mobile-form',
        'type'  => 'radio',
        'default'  => 'off',
        'options' => array('on' => 'on','off'=>'off'),
        'context'  => 'normal'
        )
    );