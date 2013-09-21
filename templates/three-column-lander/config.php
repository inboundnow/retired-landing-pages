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
	'version' => "1.0.1", // Version Number
	'label' => "3 Column Lander", // Nice Name
	'category' => 'Miscellaneous', // Template Category
	'demo' => 'http://demo.inboundnow.com/go/half-and-half-lander-preview/', // Demo Link
	'description'  => 'Half and Half is a template with two content areas on each side of the page. One side has your conversion area and the other your content on the page.' // template description
);

// Define Meta Options for template
// These values are returned in the template's index.php file with lp_get_value($post, $key, 'field-id') function
$lp_data[$key]['settings'] = 
array(
    array(
        'label' => "Conversion Area Placement",
        'description' => "Where do you want to place the conversion area?",
        'id'  => 'conversion_area', 
        'type'  => 'dropdown',
        'default'  => 'middle',
        'options' => array('right'=>'Conversion Area on right', 'middle'=>'Conversion Area in middle', 'left'=>'Conversion Area on left', 'custom'=>'Custom. [lp_conversion_area] Shortcode Placement'),
        'context'  => 'normal'
        ),
    array(
        'label' => 'Left Content Background Color',
        'description' => "Content Background Color",
        'id'  => 'left-content-bg-color', 
        'type'  => 'colorpicker',
        'default'  => 'A39485',
        'context'  => 'normal'
        ),
    array(
        'label' => 'Left Content Text Color',
        'description' => "Content Text Color",
        'id'  => 'left-content-text-color',
        'type'  => 'colorpicker',
        'default'  => 'ffffff',
        'context'  => 'normal'
        ),
     array(
        'label' => 'Left Content',
        'description' => "Left Content Area",
        'id'  => 'left-content-area', // called in template's index.php file with lp_get_value($post, $key, 'wysiwyg-id');
        'type'  => 'wysiwyg',
        'default'  => '',                
        'context'  => 'normal'
        ),
    array(
        'label' => 'Middle Content Background Color',
        'description' => "Content Background Color. The content of this area is controlled by the main editor above",
        'id'  => 'middle-content-bg-color', 
        'type'  => 'colorpicker',
        'default'  => 'F3F1EF',
        'context'  => 'normal'
        ),
    array(
        'label' => 'Middle Content Text Color',
        'description' => "Content Text Color. The content of this area is controlled by the main editor above",
        'id'  => 'middle-content-text-color',
        'type'  => 'colorpicker',
        'default'  => '000000',
        'context'  => 'normal'
        ),
     array(
        'label' => 'Right Content Background Color',
        'description' => "Content Background Color",
        'id'  => 'right-content-bg-color', 
        'type'  => 'colorpicker',
        'default'  => 'A39485',
        'context'  => 'normal'
        ),
    array(
        'label' => 'Right Content Text Color',
        'description' => "Content Text Color",
        'id'  => 'right-content-text-color',
        'type'  => 'colorpicker',
        'default'  => 'ffffff',
        'context'  => 'normal'
        ),
    array(
        'label' => 'Right Content',
        'description' => "Right Content Area",
        'id'  => 'right-content-area', // called in template's index.php file with lp_get_value($post, $key, 'wysiwyg-id');
        'type'  => 'wysiwyg',
        'default'  => '',                
        'context'  => 'normal'
        )
);	