<?php
/**
* WordPress Landing Page Config File
* Template Name:  Demo Template
* @package  WordPress Landing Pages
* @author 	David Wells
*/

do_action('lp_global_config'); // The lp_global_config function is for global code added by 3rd party extensions

//gets template directory name to use as identifier - do not edit - include in all template files
$key = lp_get_parent_directory(dirname(__FILE__)); 

// Add in global templata data
//EDIT - START - defines template information - helps categorize template and provides additional popup information
// Add Landing Page to a specific category. 
$lp_data[$key]['category'] = "Miscellaneous"; 
// Add version control to your template.
$lp_data[$key]['version'] = "1.0.0.1"; 
// Add description visible to the user
$lp_data[$key]['description'] = "This is your template's description.."; 
// Add a live demo link to illustration the page functionality to the user
$lp_data[$key]['features'][] = lp_list_feature("Demo Link","http://demo.inboundnow.com/go/demo-template-preview/"); 
// Description of the landing page visible to the user.
$lp_data[$key]['features'][] = lp_list_feature("The Demo theme is here to help developers and designs implment thier own designs into the landing page plugin. Study this template to learn about Landing Page Plugin's templating system and to assist in building new templates."); 
// Thumbnail SRC
$lp_data[$key]['thumbnail'] = LANDINGPAGES_URLPATH.'templates/'.$key.'/thumbnail.png'; 
//EDIT - END

//DO NOT EDIT - adds template to template selection dropdown 
$lp_data[$key]['value'] = $key; //do not edit this
$lp_data[$key]['label'] = ucwords(str_replace('-',' ',$key)); //do not edit this

//*************************************************************************************************
/* Add User Options to Your Landing Page Template Below */
// For more on adding meta-boxes to templates head to:
// http://plugins.inboundnow.com/docs/dev/creating-templates/template-config/
//*************************************************************************************************

// ADD IN META BOX OPTIONS TO YOUR TEMPLATE BELOW

/* Textfield Example */
// Add a text input field to the landing page options panel	
// This is called in the template's index.php file with lp_get_value($post, $key, 'text-box-id'); 
$lp_data[$key]['options'][] = 
	lp_add_option($key,"text","text-box-id","Default Text Here","Text Field Label","Text field Description", $options=null);

/* Textarea Example */
// Add a text area input field to the landing page options	
// This is called in the template's index.php file with lp_get_value($post, $key, 'textarea-id'); 
$lp_data[$key]['options'][] = 
	lp_add_option($key,"textarea","textarea-id","Default text in textarea","Textarea Label","Textarea description to the user", $options=null);

/* Colorpicker Example */
// Add a colorpicker option to your template's options panel. 
// This is called in the template's index.php file with lp_get_value($post, $key, 'color-picker-id'); 
$lp_data[$key]['options'][] = 
	lp_add_option($key,"colorpicker","color-picker-id","ffffff","ColorPicker Label","Colorpicker field description", $options=null);

/* Radio Button Example */
// Add a radio button option to your theme's options panel.	
// This is called in the template's index.php file with lp_get_value($post, $key, 'display-navigation'); 
$options = array('1' => 'on','0'=>'off');
$lp_data[$key]['options'][] = 
	lp_add_option($key,"radio","radio-id-here","1","Radio Label","Radio field description", $options);

/* Checkbox Example */
// Add a checkbox option to your theme's option panel.
// To add additional checkbox options, add additional values into the array.
// This is called in the template's index.php file with lp_get_value($post, $key, 'checkbox-id-here'); 
$options = array('option_on'=>'on');
$lp_data[$key]['options'][] = 
	lp_add_option($key,"checkbox","checkbox-id-here","on","Example Checkbox Label","Example Checkbox Description", $options);	

/* Dropdown Example */
// Add a dropdown toggle to the landing page options panel	
// To add additional dropdown options, add additional values into the array.
// This is called in the template's index.php file with lp_get_value($post, $key, 'dropdown-id-here'); 
$options = array('right'=>'Float right','left'=>'Float left', 'default'=>'Default option');
$lp_data[$key]['options'][] = 
	lp_add_option($key,"dropdown","dropdown-id-here","default","Dropdown Label","Dropdown option description", $options);	

/* Date Picker Example */
// Add a colorpicker option to your theme's options panel. 
// This is called in the template's index.php file with lp_get_value($post, $key, 'date-picker-id'); 
$lp_data[$key]['options'][] = 
	lp_add_option($key,"datepicker","date-picker","2013-12-27","Date Picker Label","Date Picker Description", $options=null);

/* WYSIWYG Example */
// Add visual/html editor to landing page options	
// This is called in the template's index.php file with lp_get_value($post, $key, 'wysiwyg-id'); 
$lp_data[$key]['options'][] = 
	lp_add_option($key,"wysiwyg","wysiwyg-id","Default WYSIWYG content","Main Content Box 2","Main Content Box 2", $options=null);

/* Media Uploaded Example */
// Add a media uploader field to your landing page options	
// This is called in the template's index.php file with lp_get_value($post, $key, 'wysiwyg-id'); 
$lp_data[$key]['options'][] = 
	lp_add_option($key,"media","media-id","/wp-content/plugins/landing-pages/templates/path-to-image-place-holder.png","File/Image Upload Label","File/Image Upload Description", $options=null);