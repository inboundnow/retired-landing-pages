<?php
/**
* Template Name:  Half and Half Template
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
	'label' => "Half and Half", // Nice Name
	'category' => 'v1, 2 column layout', // Template Category
	'demo' => 'http://demo.inboundnow.com/go/half-and-half-lander-preview/', // Demo Link
	'description'  => 'Half and Half is a template with two content areas on each side of the page. One side has your conversion area and the other your content on the page.' // template description
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
        'options' => array('1' => 'on','0'=>'off'), // options for radio
        'context'  => 'normal' // Context in screen for organizing options
        ),
    array(
        'label' => "Page Layout",
        'description' => "Align Conversion/Form Area to the left or the right",
        'id'  => 'sidebar',
        'type'  => 'dropdown',
        'default'  => 'left',
        'options' => array('right'=>'Conversion Area on right','left'=>'Conversion Area on left'),
        'context'  => 'normal'
        ),
    array(
        'label' => 'Content Background Color',
        'description' => "Content Background Color",
        'id'  => 'content-color',
        'type'  => 'colorpicker',
        'default'  => 'ffffff',
        'context'  => 'normal'
        ),
    array(
        'label' => 'Content Text Color',
        'description' => "Content Text Color",
        'id'  => 'content-text-color',
        'type'  => 'colorpicker',
        'default'  => '000000',
        'context'  => 'normal'
        ),
    array(
        'label' => 'Conversion Area Background Color',
        'description' => "Conversion Area Background Color",
        'id'  => 'sidebar-color',
        'type'  => 'colorpicker',
        'default'  => 'EE6E4C',
        'context'  => 'normal'
        ),
    array(
        'label' => 'Submit Button Background Color',
        'description' => "Submit Button Background Color",
        'id'  => 'submit-button-color',
        'type'  => 'colorpicker',
        'default'  => '38A6F0',
        'context'  => 'normal'
        ),
	array(
        'label' => 'Conversion Area Text Color',
        'description' => "Conversion Area Text Color",
        'id'  => 'sidebar-text-color',
        'type'  => 'colorpicker',
        'default'  => 'ffffff',
        'context'  => 'normal'
        )
);