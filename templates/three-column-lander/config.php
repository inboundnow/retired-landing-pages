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
	'label' => "3 Column Lander", // Nice Name
	'category' => '3 column layout, Responsive, V2', // Template Category
	'demo' => 'http://demo.inboundnow.com/go/half-and-half-lander-preview/', // Demo Link
	'description'  => 'Half and Half is a template with two content areas on each side of the page. One side has your conversion area and the other your content on the page.' // template description
);

// Define Meta Options for template
// These values are returned in the template's index.php file with lp_get_value($post, $key, 'field-id') function
$lp_data[$key]['settings'] =
array(
    array(
      'label' => "Default Content",
      'description' => "This is the default content from template.",
      'id' => "default-content",
      'type' => "default-content",
      'default' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae mauris arcu, eu pretium nisi. Praesent fringilla ornare ullamcorper. Pellentesque diam orci, sodales in blandit ut, placerat quis felis. Vestibulum at sem massa, in tempus nisi. Vivamus ut fermentum odio. Etiam porttitor faucibus volutpat. Vivamus vitae mi ligula, non hendrerit urna. Suspendisse potenti. Quisque eget massa a massa semper mollis.",
    ),
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
        'label' => 'Submit Button Color',
        'description' => "Submit Button Color",
        'id'  => 'submit-button-color',
        'type'  => 'colorpicker',
        'default'  => '33B96B',
        'context'  => 'normal'
        ),
    array(
        'label' => 'Left Content Background Color',
        'description' => "Content Background Color",
        'id'  => 'left-content-bg-color',
        'type'  => 'colorpicker',
        'default'  => '0B61A4',
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
        'default'  => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae mauris arcu, eu pretium nisi. Praesent fringilla ornare ullamcorper. Pellentesque diam orci, sodales in blandit ut, placerat quis felis. Vestibulum at sem massa, in tempus nisi. Vivamus ut fermentum odio. Etiam porttitor faucibus volutpat. Vivamus vitae mi ligula, non hendrerit urna. Suspendisse potenti. Quisque eget massa a massa semper mollis.',
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
        'default'  => '0B61A4',
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
        'default'  => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae mauris arcu, eu pretium nisi. Praesent fringilla ornare ullamcorper. Pellentesque diam orci, sodales in blandit ut, placerat quis felis. Vestibulum at sem massa, in tempus nisi. Vivamus ut fermentum odio. Etiam porttitor faucibus volutpat. Vivamus vitae mi ligula, non hendrerit urna. Suspendisse potenti. Quisque eget massa a massa semper mollis.',
        'context'  => 'normal'
        )
);