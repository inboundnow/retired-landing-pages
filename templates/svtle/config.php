<?php
/**
* WordPress Landing Page Config File
* Template Name:  Svtle Template
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
$lp_data[$key]['features'][] = lp_list_feature("Demo Link","http://demo.inboundnow.com/go/sbvtle-lander-preview/"); 
// Add a live demo link to illustration the page functionality to the user
$lp_data[$key]['features'][] = lp_list_feature("Clean and minimalistic design for a straight forward conversion page."); 
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
$options = array('left'=>'Sidebar on left', 'right'=>'Sidebar on right');
$lp_data[$key]['options'][] = 
	lp_add_option($key,"dropdown","sidebar","left","Sidebar Layout","Align sidebar to the left or the right", $options);

// Add Colorpicker
$lp_data[$key]['options'][] = 
	lp_add_option($key,"colorpicker","submit-button-color","5baa1e","Submit Button Background Color","Use this setting to change the template's submit button color.", $options=null);		

// Add a media uploader field to your landing page options	
$lp_data[$key]['options'][] = 
	lp_add_option($key,"media","logo","/wp-content/plugins/landing-pages/templates/svtle/assets/images/inbound-logo.png","Logo Image","Upload Your Logo (300x110px)", $options=null);
// Add Colorpicker
$lp_data[$key]['options'][] = 
	lp_add_option($key,"colorpicker","body-color","ffffff","Content Area Background Color","Use this setting to change the template's main content area color", $options=null);

// Add Colorpicker
$lp_data[$key]['options'][] = 
	lp_add_option($key,"colorpicker","page-text-color","4D4D4D","Content Area Text Color","Use this setting to change the template's text color", $options=null);	

// Add Colorpicker
// This is called in the template's index.php file with lp_get_value($post, $key, 'sidebar-color'); */
$lp_data[$key]['options'][] = 
	lp_add_option($key,"colorpicker","sidebar-color","ffffff","Sidebar color","Use this setting to change the template's sidebar color", $options=null);
// Add Colorpicker
$lp_data[$key]['options'][] = 
	lp_add_option($key,"colorpicker","sidebar-text-color","000000","Sidebar Text Color","Use this setting to change the template's sidebar text color", $options=null);	

// Add Colorpicker
$lp_data[$key]['options'][] = 
	lp_add_option($key,"colorpicker","header-color","ffffff","Header Color","Use this setting to change the template's header color", $options=null);

// Add a radio button option to your theme's options panel.	
$options = array('on' => 'on','off'=>'off');
$lp_data[$key]['options'][] = 
	lp_add_option($key,"radio","mobile-form","off","Display form below content on mobile?","Toggle this on to render the form below the content in the mobile view", $options);