<?php 
/*****************************************/
// Template Title:  Simple Two Column Template
// Plugin: Landing Pages - Inboundnow.com
/*****************************************/

/* Include Shareme Library */
include_once(LANDINGPAGES_PATH.'libraries/library.shareme.php');

/* Declare Template Key */
$key = lp_get_parent_directory(dirname(__FILE__)); 
$path = LANDINGPAGES_URLPATH.'templates/'.$key.'/';
$url = plugins_url();
/* Define Landing Pages's custom pre-load hook for 3rd party plugin integration */
do_action('lp_init');

/* Load $post data */
if (have_posts()) : while (have_posts()) : the_post();
    
    /* Pre-load meta data into variables */
    
    $content_color = lp_get_value($post, $key, 'content-color'); 
    $body_color = lp_get_value($post, $key, 'body-color');
    $sidebar_color = lp_get_value($post, $key, 'sidebar-color'); 
    $text_color = lp_get_value($post, $key, 'content-text-color');
    $sidebar_text_color = lp_get_value($post, $key, 'sidebar-text-color');
    $headline_color = lp_get_value($post, $key, 'headline-color');
    $logo = lp_get_value($post, $key, 'logo');
    $sidebar = lp_get_value($post, $key, 'sidebar'); 
    $social_display = lp_get_value($post, $key, 'display-social');
    $submit_button_color = lp_get_value($post, $key, 'submit-button-color'); 
	//prepare content
	$content = lp_content_area($post,null,true);
    // Get Colorscheme
    $submit_color_scheme = inbound_color_scheme($submit_button_color, 'int');
   
    // Get lighter submit color
    $top_grad_submit = inbound_color($submit_color_scheme, 35);

    $RBG_array = inbound_Hex_2_RGB($submit_button_color);
    $red = $RBG_array['r'];
    $green = $RBG_array["g"];
    $blue = $RBG_array["b"];
    
    $RBG_array_1 = inbound_Hex_2_RGB($top_grad_submit);
    $red_1 = $RBG_array_1['r'];
    $green_1 = $RBG_array_1["g"];
    $blue_1 = $RBG_array_1["b"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US"><head profile="http://gmpg.org/xfn/11"><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title><?php wp_title(); ?></title>
<link rel="stylesheet" href="<?php echo $path; ?>assets/css/style.css" type="text/css" media="screen">
<?php wp_enqueue_script('sharrre', LANDINGPAGES_URLPATH . 'js/sharrre/jquery.sharrre-1.3.3.min.js', array('jquery')); ?>

<style media="screen" type="text/css">

   <?php if ($sidebar_color !="") {
            echo "#right { background-color: #$sidebar_color;}"; // change sidebar color
        }
        ?> <?php if ($content_color !="") {
            echo "#left {background-color: #$content_color;}"; // change header color
        }
        ?> <?php if ($body_color !="") {
            echo "body {background-color: #$body_color;}"; // Change Body BG color 
        }
        ?> <?php if ($text_color !="") {
            echo "#left-content {color: #$text_color;}";
        }
        ?>
        <?php if ($sidebar_text_color !="") {
            echo "#right-content {color: #$sidebar_text_color;} input[type=\"text\"], input[type=\"email\"] {
                                        border: 1px solid #$sidebar_text_color;
                                        opacity: 0.8;} ";
        }
        ?>
        <?php if ($sidebar === "left" ) {  echo "#right {left:0px; -webkit-box-shadow: 18px 0px 29px rgba(50, 50, 50, 0.55); -moz-box-shadow:    18px 0px 29px rgba(50, 50, 50, 0.55); box-shadow: 18px 0px 29px rgba(50, 50, 50, 0.55);} #left {right: 0;} #left-content {padding-left: 40px;} #social-share-buttons {margin-left: -115px !important;}";
        } else { echo "#left {left: 0;}"; }
        ?>
         <?php if ($submit_button_color != "") {
          echo"input[type='submit'] {
               background: -moz-linear-gradient(rgba($red_1,$green_1,$blue_1, 0.5), rgba($red,$green,$blue, 0.7));
               background: -ms-linear-gradient(rgba($red_1,$green_1,$blue_1, 0.5), rgba($red,$green,$blue, 0.7));
               background: -o-linear-gradient(rgba($red_1,$green_1,$blue_1, 0.5), rgba($red,$green,$blue, 0.7));
               background: -webkit-gradient(linear, 0 0, 0 100%, from(rgba($red_1,$green_1,$blue_1, 0.5)), to(rgba($red,$green,$blue, 0.7)));
               background: -webkit-linear-gradient(rgba($red_1,$green_1,$blue_1, 0.5), rgba($red,$green,$blue, 0.7));
               background: linear-gradient(rgba($red_1,$green_1,$blue_1, 0.5), rgba($red,$green,$blue, 0.7));
                border: 1px solid #000;}";
           }
        ?> 
</style>
<?php /* Load all functions hooked to lp_head including global js and global css */
			wp_head(); // Load Regular WP Head
			do_action('lp_head'); // Load Custom Landing Page Specific Header Items
		?>

</head>
<body>
     
<div class="container">
         

<div id="content-wrapper">

 <?php if ($social_display==="1" ) { // Show Social Media Icons?>
    <?php lp_social_media("vertical"); // print out social media buttons?>
 <?php  } ?>


<div id="right">
	<div id="right-content">
 <?php lp_conversion_area(); /* Print out form content */ ?>
	</div> <!-- end right-content -->
</div> <!-- end left-content -->

<div id="left">
	<div id="left-content">
<h1><?php lp_main_headline(); ?></h1>
<?php echo $content; ?>
	</div> <!-- end left-content -->
</div> <!-- end left -->
 <style type="text/css">

 .sharrre .button {
width: 60px;
padding: 4px;
}
</style> 

</div><!-- end content-wrapper -->

 </div><!-- end container -->
 <?php break; endwhile; endif; // end wordpress loop
    do_action('lp_footer'); // load landing pages footer hook
    wp_footer(); // load normal wordpress footer ?>

</body>
</html>