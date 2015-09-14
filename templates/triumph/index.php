<?php
/**
* Template Name: Triumph
* @package  WordPress Landing Pages
* @author   Inbound Template Generator
*/

/* Declare Template Key */
$key = basename(dirname(__FILE__));
$path = LANDINGPAGES_UPLOADS_URLPATH ."$key/";
$url = plugins_url();


/* Include ACF Field Definitions  */
include_once(LANDINGPAGES_PATH.'templates/'.$key.'/config.php');

/* Enqueue Styles and Scripts */
function triumph_enqueue_scripts() {
	//wp_enqueue_script( 'jquery' );
	//wp_enqueue_script( 'acacia-bootstrap-js', plugins_url('assets/js/bootstrap.min.js', __FILE__),'','', true );
	
	//wp_enqueue_style( 'acacia-bootstrap-css', plugins_url('assets/css/bootstrap.css', __FILE__) );
}

add_action('wp_enqueue_scripts', 'triumph_enqueue_scripts');

/* Define Landing Pages's custom pre-load hook for 3rd party plugin integration */
do_action('wp_head');

if (have_posts()) : while (have_posts()) : the_post();

$post_id = get_the_ID();
?>

<!DOCTYPE html>


</html>
<?php

endwhile; endif;