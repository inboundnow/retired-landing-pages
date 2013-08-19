<?php
/*
 * Template Name: Dropcap
 * @package  WordPress Landing Pages
 * @author   Your Name Here!
 */

//gets template directory name to use as identifier - do not edit - include in all template files
$key = lp_get_parent_directory(dirname(__FILE__)); 

//adds template data to global array for use with landing page plugin - edit theme category and description only. 

//EDIT - START - defines template information - helps categorizae template and provides additional popup information
$lp_data[$key]['category'] = "Miscellaneous"; 
$lp_data[$key]['version'] = "1.0.0.1"; 
$lp_data[$key]['description'] = "This template illustrates capabilities of this plugin's templating system.."; 
$lp_data[$key]['features'][] = lp_list_feature("Demo Link","http://demo.inboundnow.com/go/dropcap-lander-preview/"); 
$lp_data[$key]['features'][] = lp_list_feature("Dropcap is a template for a simple landing page with a large headline callout."); 
$lp_data[$key]['thumbnail'] = LANDINGPAGES_URLPATH.'templates/'.$key.'/thumbnail.png'; 
//thumbnail

//DO NOT EDIT - adds template to template selection dropdown 
$lp_data[$key]['value'] = $key; //do not edit this
$lp_data[$key]['label'] = ucwords(str_replace('-',' ',$key)); //do not edit this


//************************************************
// Add User Options to Your Landing Page Template
//************************************************

// Add a Colorpicker
$lp_data[$key]['options'][] = 
	lp_add_option($key,"colorpicker","text-color","ffffff","Text color","Use this setting to change the Text Color", $options=null);

// Add a Colorpicker
$lp_data[$key]['options'][] = 
	lp_add_option($key,"colorpicker","content-background","000000","Content Background Color","Use this setting to change the Content Area Background Color", $options=null);

// Add a Colorpicker
$lp_data[$key]['options'][] = 
	lp_add_option($key,"colorpicker","form-text-color","ffffff","Conversion Area Text Color","Use this setting to change the Conversion Area text Color", $options=null);

/* Template Background Settings */
// Select Background Type Setting
$options = array('fullscreen'=>'Fullscreen Image', 'tile'=>'Tile Background Image', 'color' => 'Solid Color', 'repeat-x' => 'Repeat Image Horizontally', 'repeat-y' => 'Repeat Image Vertically', 'custom' => 'Custom CSS');
$lp_data[$key]['options'][] = 
	lp_add_option($key,"dropdown","background-style","fullscreen","Background Settings","Decide how you want the bodies background to be", $options);	
// Full Screen Image Setting
$lp_data[$key]['options'][] = 
	lp_add_option($key,"media","background-image","","Background Image","Enter an URL or upload an image for the banner.", $options=null);
// Solid Backgound Color Setting
$lp_data[$key]['options'][] = 
	lp_add_option($key,"colorpicker","background-color","186d6d","Background Color","Use this setting to change the templates background color", $options=null);
/* Template End Background Settings */
do_action('lp_global_config');