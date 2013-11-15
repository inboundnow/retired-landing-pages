<?php
/**
* WordPress Landing Page Config File
* Template Name:  Tubelar Template
*
* @package  WordPress Landing Pages
* @author 	David Wells
*/

do_action('lp_global_config'); // The lp_global_config function is for global code added by 3rd party extensions

//gets template directory name to use as identifier - do not edit - include in all template files
$key = lp_get_parent_directory(dirname(__FILE__));

//adds template data to global array for use with landing page plugin - edit theme category and description only.

//EDIT - START - defines template information - helps categorizae template and provides additional popup information
$lp_data[$key]['category'] = "Video"; 
$lp_data[$key]['description'] = "Tubelar Template"; 
$lp_data[$key]['version'] = "1.0.1"; 
$lp_data[$key]['thumbnail'] = LANDINGPAGES_URLPATH.'templates/'.$key.'/thumbnail.png'; 

//DO NOT EDIT - adds template to template selection dropdown
$lp_data[$key]['value'] = $key;
$lp_data[$key]['label'] = ucwords(str_replace('-',' ',$key));


//************************************************
// Add User Options to Your Landing Page Template
//************************************************
// Textfield Example
// Add a text input field to the landing page options panel
$lp_data[$key]['options'][] =
	lp_add_option($key,"text","yt-video","http://www.youtube.com/watch?v=_OBlgSz8sSM","Youtube Background Video URL","Paste in the URL of the Youtube Video here", $options=null);

// Dropdown Example
// Add a dropdown toggle to the landing page options panel
$options = array('lp_right'=>'Sidebar on right','lp_left'=>'Sidebar on left');
$lp_data[$key]['options'][] =
	lp_add_option($key,"dropdown","sidebar","lp_right","Sidebar Layout","Align sidebar to the left or the right", $options);

// Add Colorpicker
$lp_data[$key]['options'][] =
	lp_add_option($key,"colorpicker","submit-button-color","11b709","Submit Button Color","Use this setting to change the template's submit button color.", $options=null);

// Add Colorpicker
$lp_data[$key]['options'][] =
	lp_add_option($key,"colorpicker","text-color","ffffff","Text Color","Use this setting to change the template's text color", $options=null);

// Add Colorpicker
$lp_data[$key]['options'][] =
	lp_add_option($key,"colorpicker","box-color","000000","Content Background Color","Use this setting to change the content area's background color", $options=null);

// Select Background Type Setting
$options = array('transparent'=>'Transparent Background', 'solid'=>'Solid');
$lp_data[$key]['options'][] =
	lp_add_option($key,"dropdown","clear-bg-settings","transparent","Background Color Settings","Decide how you want the content background to be", $options);

// Add Media Uploader
$lp_data[$key]['options'][] =
	lp_add_option($key,"media","logo","/wp-content/plugins/landing-pages/templates/tubelar/assets/img/inbound-now-logo.png","Logo Image","Upload Your Logo (300x110px)", $options=null);

// Add Radio Button
$options = array('1' => 'on','0'=>'off');
$lp_data[$key]['options'][] =
	lp_add_option($key,"radio","display-social","1","Display Social Media Share Buttons","Toggle social sharing on and off", $options);

// Add Radio Button
$options = array('1' => 'on','0'=>'off');
$lp_data[$key]['options'][] =
	lp_add_option($key,"radio","controls","1","Show Play Controls","Toggle display of background video controls on or off", $options);