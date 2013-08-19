<?php
/**
* WordPress Landing Page Config File
* Template Name:  Super Slick Template
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
$lp_data[$key]['description'] = "Super Slick Template"; 
$lp_data[$key]['version'] = "1.0.0.1"; 
$lp_data[$key]['features'][] = lp_list_feature("Demo Link","http://demo.inboundnow.com/go/super-slick-lander-preview/"); 
$lp_data[$key]['features'][] = lp_list_feature("SuperSlick is great for showcasing a hero image or video on your landing page."); 
$lp_data[$key]['thumbnail'] = LANDINGPAGES_URLPATH.'templates/'.$key.'/thumbnail.png'; 


//DO NOT EDIT - adds template to template selection dropdown 
$lp_data[$key]['value'] = $key; 
$lp_data[$key]['label'] = ucwords(str_replace('-',' ',$key)); 


//************************************************
// Add User Options to Your Landing Page Template
//************************************************
// Add Colorpicker
$lp_data[$key]['options'][] = 
	lp_add_option($key,"colorpicker","headline-color","000000","Headline Text Color","Use this setting to change the template's headline text color", $options=null);	

// Add a text input field
$lp_data[$key]['options'][] = 
	lp_add_option($key,"text","sub-headline","Sub Headline Goes Here","Sub Headline Text","Sub headline text goes here", $options=null);

// Add Colorpicker
$lp_data[$key]['options'][] = 
	lp_add_option($key,"colorpicker","sub-headline-color","a3a3a3","Sub Headline Text Color","Use this setting to change the template's headline text color", $options=null);	

// Add a Colorpicker
$lp_data[$key]['options'][] = 
	lp_add_option($key,"colorpicker","top-color","ffffff","Top Main Background Color","Use this setting to change the template's body color", $options=null);

// Add a Colorpicker
$lp_data[$key]['options'][] = 
	lp_add_option($key,"colorpicker","top-text-color","000000","Top Area Text Color","Use this setting to change the template's Top Text Color", $options=null);	

// Add a dropdown toggle to the landing page options panel	
$options = array('left'=>'Form on left', 'right'=>'Form on right');
$lp_data[$key]['options'][] = 
	lp_add_option($key,"dropdown","form-placement","left","Top Area Layout","Do you want the conversion/form area on the right or left?", $options);	

// Add Colorpicker
$lp_data[$key]['options'][] = 
	lp_add_option($key,"colorpicker","submit-button-color","5baa1e","Submit Button Background Color","Use this setting to change the template's submit button color.", $options=null);

// Add WYSIWYG editor
$lp_data[$key]['options'][] = 
	lp_add_option($key,"wysiwyg","wysiwyg-content","This is the bottom area text","Bottom Area Content","This is the content in the bottom of the page", $options=null);

// Add a Colorpicker
$lp_data[$key]['options'][] = 
	lp_add_option($key,"colorpicker","bottom-text-color","000000","Bottom Text Color","Use this setting to change the template's Bottom Text Color", $options=null);	

// Add a Colorpicker
$lp_data[$key]['options'][] = 
	lp_add_option($key,"colorpicker","bottom-color","ffffff","Bottom Background Color","Use this setting to change the template's Bottom Background Color", $options=null);

// Add a Radio button
$options = array('1' => 'on','0'=>'off');
$lp_data[$key]['options'][] = 
	lp_add_option($key,"radio","display-social","0","Display Social Media Share Buttons","Toggle social sharing on and off", $options);