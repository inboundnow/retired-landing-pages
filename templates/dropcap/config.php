<?php
/**
 * Template Name: Dropcap
 * @package  WordPress Landing Pages
 * @author   David Wells
 */

//gets template directory name to use as identifier - do not edit - include in all template files
$key = lp_get_parent_directory(dirname(__FILE__)); 

do_action('lp_global_config');

$lp_data[$key]['info'] = 
array(
	'version' => "2.0.0", // Version Number
	'label' => "Dropcap", // Nice Name
	'category' => 'Miscellaneous', // Template Category
	'demo' => 'http://demo.inboundnow.com/go/dropcap-lander-preview/', // Demo Link
	'description'  => 'Create a great looking quote styled landing page' // template description
);

// Define Meta Options for template
// These values are returned in the template's index.php file with lp_get_value($post, $key, 'text-box-id') function
$lp_data[$key]['settings'] = 
array(
    array(  
        'label' => 'Text color', // Label of field
        'description' => "Use this setting to change the Text Color", // field description
        'id' => 'text-color', // metakey.
        'type'  => 'colorpicker', // text metafield type
        'default'  => 'ffffff', // default content
        'context'  => 'normal' // Context in screen for organizing options
        ),
    array(
        'label' => 'Content Background Color',
        'description' => "Use this setting to change the Content Area Background Color",
        'id'  => 'content-background', 
        'type'  => 'colorpicker',
        'default'  => '000000',
        'context'  => 'normal'
        ),
    array(
        'label' => 'Conversion Area Text Color',
        'description' => "Use this setting to change the Conversion Area text Color",
        'id'  => 'form-text-color', 
        'type'  => 'colorpicker',
        'default'  => 'ffffff',
        'context'  => 'normal'
        ),
    /* Background Settings */
    array(
        'label' => 'Background Settings',
        'description' => "Set the template's background",
        'id'  => 'background-style',
        'type'  => 'dropdown',
        'default'  => 'fullscreen',
        'options' => array('fullscreen'=>'Fullscreen Image', 'tile'=>'Tile Background Image', 'color' => 'Solid Color', 'repeat-x' => 'Repeat Image Horizontally', 'repeat-y' => 'Repeat Image Vertically', 'custom' => 'Custom CSS'),
        'context'  => 'normal'
        ),
    array(
        'label' => 'Background Image',
        'description' => "Enter an URL or upload an image for the banner.",
        'id'  => 'background-image', 
        'type'  => 'media',
        'default'  => 'on',	
        'context'  => 'normal'
        ),
    array(
        'label' => 'Background Color',
        'description' => "Use this setting to change the templates background color",
        'id'  => 'background-color',
        'type'  => 'colorpicker',
        'default'  => '186d6d',
        'context'  => 'normal'
        )
    );