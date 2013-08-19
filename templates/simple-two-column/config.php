<?php
/**
* WordPress Landing Page Config File
* Template Name:  Simple Two Column Template
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
// Add Landing Page to a specific category. 
$lp_data[$key]['version'] = "1.0.0.1"; 
// Add version control to your template.
$lp_data[$key]['description'] = "This template illustrates capabilities of this plugin's templating system.."; 
// Add description visible to the user
$lp_data[$key]['features'][] = lp_list_feature("Demo Link","http://demo.inboundnow.com/go/simple-two-column-lander-preview/"); 
// Add a live demo link to illustration the page functionality to the user
$lp_data[$key]['features'][] = lp_list_feature("This is a standard template with a main content area and a sidebar for a conversion form. There are numerous options to change the color scheme to fit your brand."); 
// Description of the landing page visible to the user.
$lp_data[$key]['thumbnail'] = LANDINGPAGES_URLPATH.'templates/'.$key.'/thumbnail.png'; 
// Thumbnail


//DO NOT EDIT - adds template to template selection dropdown 
$lp_data[$key]['value'] = $key; //do not edit this
$lp_data[$key]['label'] = ucwords(str_replace('-',' ',$key)); //do not edit this


//************************************************
// Add User Options to Your Landing Page Template
//************************************************

// Add a radio button option to your theme's options panel.	
$options = array('1' => 'on','0'=>'off');
$lp_data[$key]['options'][] = 
	lp_add_option($key,"radio","display-social","1","Display Social Media Share Buttons","Toggle social sharing on and off", $options);

// Add a dropdown toggle to the landing page options panel	
$options = array('right'=>'Sidebar on right', 'left'=>'Sidebar on left' );
$lp_data[$key]['options'][] = 
	lp_add_option($key,"dropdown","sidebar","right","Sidebar Layout","Align sidebar to the left or the right", $options);	

// Add Colorpicker
// This is called in the template's index.php file with lp_get_value($post, $key, 'sidebar-color'); */
$lp_data[$key]['options'][] = 
	lp_add_option($key,"colorpicker","sidebar-color","2A4480","Sidebar color","Use this setting to change the template's sidebar color", $options=null);

// Add Colorpicker
$lp_data[$key]['options'][] = 
	lp_add_option($key,"colorpicker","submit-button-color","5baa1e","Submit Button Background Color","Use this setting to change the template's submit button color.", $options=null);		

// Add Colorpicker
$lp_data[$key]['options'][] = 
	lp_add_option($key,"colorpicker","content-color","1240AB","Main Content Area Color","Use this setting to change the template's main content area background color", $options=null);

// Add Colorpicker
$lp_data[$key]['options'][] = 
	lp_add_option($key,"colorpicker","body-color","06266F","Background color","Use this setting to change the template's background color", $options=null);

// Add Colorpicker
$lp_data[$key]['options'][] = 
	lp_add_option($key,"colorpicker","content-text-color","ffffff","Content Text Color","Use this setting to change the content text color", $options=null);	

// Add Colorpicker
$lp_data[$key]['options'][] = 
	lp_add_option($key,"colorpicker","sidebar-text-color","ffffff","Sidebar Text Color","Use this setting to change the sidebar text color", $options=null);