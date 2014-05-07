<?php
/**
* Template Name: Simple-Solid
* @package  WordPress Landing Pages
* @author   Inbound Template Generator!
* WordPress Landing Page Config File
*/
do_action('lp_global_config');
$key = lp_get_parent_directory(dirname(__FILE__));

$path = (preg_match("/uploads/", dirname(__FILE__))) ? LANDINGPAGES_UPLOADS_URLPATH . $key .'/' : LANDINGPAGES_URLPATH.'templates/'.$key.'/';

/* Configures Template Information */
$lp_data[$key]['info'] = array(
    'data_type' => 'template',
    'version' => '1.0',
    'label' => 'Simple Solid Lite',
    'category' => '1 Column',
    'demo' => '',
    'description' => 'This is an auto generated template from Inbound Now'
);

/* Configures Template Editor Options */
$lp_data[$key]['settings'] = array(
 array(
   'label' => "Default Content",
   'description' => "This is the default content from template.",
   'id' => "default-content",
   'type' => "default-content",
   'default' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae mauris arcu, eu pretium nisi. Praesent fringilla ornare ullamcorper. Pellentesque diam orci, sodales in blandit ut, placerat quis felis. Vestibulum at sem massa, in tempus nisi. Vivamus ut fermentum odio. Etiam porttitor faucibus volutpat. Vivamus vitae mi ligula, non hendrerit urna. Suspendisse potenti. Quisque eget massa a massa semper mollis.",
 ),
 array(
   'label' => "Logo",
   'description' => "Logo",
   'id' => "logo",
   'type' => "media",
   'default' => $path . "/images/inbound-logo.png",
   'selector' => ".logo a",
 ),
 array(
   'label' => "Top Right Area",
   'description' => "",
   'id' => "social-media-options",
   'type' => "textarea",
   'default' => '[social_share style="bar" align="horizontal" heading_align="inline" heading="Share This" facebook="1" twitter="1" google_plus="1" linkedin="1" pinterest="0" /]',
   'selector' => ".inner .network",
 ),
 array(
     'label' => 'Submit Button Color',
     'description' => '',
     'id'  => 'submit-color',
     'type'  => 'colorpicker',
     'default'  => '27ae60',
     'context'  => 'normal'
     ),
 array(
   'label' => "Copyright Text",
   'description' => "Copyright Text",
   'id' => "copyright-text",
   'type' => "text",
   'default' => "© 2013 Your Company | All Right Reserved",
   'selector' => ".cf.container .foot-left",
 ),
array(
'label' => 'Background Settings',
          'description' => 'Set the template\'s background',
          'id'  => 'background-style',
          'type'  => 'dropdown',
          'default'  => 'color',
          'options' => array('fullscreen'=>'Fullscreen Image', 'tile'=>'Tile Background Image', 'color' => 'Solid Color', 'repeat-x' => 'Repeat Image Horizontally', 'repeat-y' => 'Repeat Image Vertically', 'custom' => 'Custom CSS'),
          'context'  => 'normal'
          ),
      array(
          'label' => 'Background Image',
          'description' => 'Enter an URL or upload an image for the banner.',
          'id'  => 'background-image',
          'type'  => 'media',
          'default'  => '',
          'context'  => 'normal'
          ),
      array(
          'label' => 'Background Color',
          'description' => 'Use this setting to change the templates background color',
          'id'  => 'background-color',
          'type'  => 'colorpicker',
          'default'  => '186d6d',
          'context'  => 'normal'
          ),
);
