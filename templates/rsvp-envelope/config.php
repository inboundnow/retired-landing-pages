<?php
/**
* WordPress Landing Page Config File
* Template Name:  RSVP Envelope Template
*
* @package  WordPress Landing Pages
* @author 	David Wells
*/

do_action('lp_global_config'); // The lp_global_config function is for global code added by 3rd party extensions

//gets template directory name to use as identifier - do not edit - include in all template files
$key = lp_get_parent_directory(dirname(__FILE__)); 

//adds template data to global array for use with landing page plugin - edit theme category and description only. 

//EDIT - START - defines template information - helps categorizae template and provides additional popup information
$lp_data[$key]['category'] = "Miscellaneous"; 
$lp_data[$key]['description'] = "RSVP Envelope Template"; 
$lp_data[$key]['version'] = "1.0.0.1"; 
$lp_data[$key]['features'][] = lp_list_feature("Demo Link","http://demo.inboundnow.com/go/rsvp-envelope-lander-preview/"); 
$lp_data[$key]['features'][] = lp_list_feature("This template is great for sending out invitations to events."); 
$lp_data[$key]['thumbnail'] = LANDINGPAGES_URLPATH.'templates/'.$key.'/thumbnail.png'; 


//DO NOT EDIT - adds template to template selection dropdown 
$lp_data[$key]['value'] = $key; 
$lp_data[$key]['label'] = ucwords(str_replace('-',' ',$key)); 


//************************************************
// Add User Options to Your Landing Page Template
//************************************************
// Add Colorpicker
$lp_data[$key]['options'][] = 
	lp_add_option($key,"colorpicker","body-color","CCCCCC","Template body color","Use this setting to change the template's body background color", $options=null);
// Add Colorpicker
$lp_data[$key]['options'][] = 
	lp_add_option($key,"colorpicker","headline-color","ffffff","Headline Color","Use this setting to change the template's headline text color", $options=null);	
// Add Colorpicker
$lp_data[$key]['options'][] = 
	lp_add_option($key,"colorpicker","text-color","7C7873","Text Color","Use this setting to change the template's text color", $options=null);	

// Add Colorpicker
$lp_data[$key]['options'][] = 
	lp_add_option($key,"colorpicker","form-text-color","7C7873","Form Text Color","Use this setting to change the template's form text color", $options=null);	

// Radio Button Example
// Add a radio button option to your theme's options panel.	
$options = array('1' => 'on','0'=>'off');
$lp_data[$key]['options'][] = 
	lp_add_option($key,"radio","display-social","1","Display Social Media Share Buttons","Toggle social sharing on and off", $options);

// Add a dropdown toggle to the landing page options panel	
$options = array('right'=>'Envelope on right', 'left'=>'Envelope on left');
$lp_data[$key]['options'][] = 
	lp_add_option($key,"dropdown","sidebar","right","Sidebar Layout","Align sidebar to the left or the right", $options);	
	
// Media Uploaded Example
// Add a media uploader field to your landing page options	
$lp_data[$key]['options'][] = 
	lp_add_option($key,"media","media-example","","Background Image","Enter an URL or upload an image for the banner.", $options=null);