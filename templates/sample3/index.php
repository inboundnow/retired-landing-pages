<?php
/**
 * Template Name: Qobo Sample 1 Template
 *
 * @package    WordPress Landing Pages
 * @author    Constantinos Christoforou
 * @version    1.0
 */

/* Step 1: Declare Template Key. This will be automatically detected for you */
$key = lp_get_parent_directory(dirname(__FILE__));
$path = (preg_match("/uploads/", dirname(__FILE__))) ? LANDINGPAGES_UPLOADS_URLPATH . $key . '/' : LANDINGPAGES_URLPATH . 'templates/' . $key . '/'; // This defines the path to your template folder. /wp-content/uploads/landing-pages/templates by default

/* Define Landing Pages's custom pre-load hook for 3rd party plugin integration */
do_action('lp_init');

/* Load Regular WordPress $post data and start the loop */
if (have_posts()) : while (have_posts()) :
the_post();

/**
 * Step 2: Pre-load meta data into variables.
 * - These are defined in this templates config.php file
 * - The config.php values create the metaboxes visible to the user.
 * - We define those meta-keys here to use them in the template.
 */


$logo = get_option('qb_logo_image');

// Dropdown Label: Text field Description. Defined in config.php on line 78
$dropdown_id_here = lp_get_value($post, $key, 'dropdown-id-here');
// Date Picker Label: Text field Description. Defined in config.php on line 85
$date_picker = lp_get_value($post, $key, 'date-picker');
// Main Content Box 2: Text field Description. Defined in config.php on line 91
$wysiwyg_id = lp_get_value($post, $key, 'wysiwyg-id');
// File/Image Upload Label: Text field Description. Defined in config.php on line 97

// The main content if you want to show default placeholders.

//

$banner_image = lp_get_value($post, $key, 'banner-image');



$header_content = lp_get_value($post, $key, 'header-content');
$main_content = lp_get_value($post, $key, 'main-content');
$footer_content = lp_get_value($post, $key, 'footer-content');
$top_content = lp_get_value($post, $key, 'top-content');



$header_color = lp_get_value($post, $key, 'header-color');
$main_color = lp_get_value($post, $key, 'main-color');
$top_color = lp_get_value($post, $key, 'top-color');
$footer_color = lp_get_value($post, $key, 'footer-color');
$show_logo = boolval(lp_get_value($post, $key, 'show-company-logo'));





// alternatively you can use default wordpress get_post_meta.
// You will need to add your template $key to the meta id. Example "text-box-id" becomes "demo-text-box-id"
// example: $text_box_id = get_post_meta($post->ID, 'demo-text-box-id', true);
?>
<!DOCTYPE html>

<head>
    <!--	Define page title -->
    <title><?php wp_title(); ?></title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width"/>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

    <!-- Included CSS Files -->
    <link rel="stylesheet" href="<?php echo $path; ?>assets/css/style.css">


    <!-- Inline Style Block for implementing css changes based off user settings -->
    <style type="text/css">
        <?php
        // If color changed, apply new hex color
        if ($color_picker_id != "") {
        echo "body	{ background-color: #$color_picker_id;} ";
        }
        ?>
    </style>

    <!-- Load Normal WordPress wp_head() function -->
    <?php wp_head(); ?>
    <!-- Load Landing Pages's custom pre-load hook for 3rd party plugin integration -->
    <?php do_action('lp_head'); ?>

</head>

<!-- lp_body_class(); Defines Custom Body Classes for Advanced User CSS Customization -->
<body <?php body_class(); ?>>


<div id="wrapper">

    <div class="container">

        <header style="background-color: <?php  echo '#'.$header_color?>"><div class="row">

                <?php if ($show_logo): ?>

                <div class="col-md-3">


                    <img id="logo" src="<?php echo $logo ?>" width="250" height="80">


                </div>
                <div class="col-md-9">

                    <?php else: ?>

                    <div class="col-md-12">

                        <?php endif; ?>



                        <?php echo $header_content; ?>

                    </div>
                </div>
                <?php ?>
        </header>

    </div>


    <div id="banner-image" class="container"
         style="background: url('<?php echo $banner_image ?>') no-repeat;height: 461px;">


    </div>

    <div class="container">

        <div id="content-wrapper" class="row">
            <div id="content" class="col-md-6" style="background-color: <?php  echo '#'.$main_color?>">
                <!-- Use the_title(); to print out the main headline -->
                <h1><?php the_title(); ?></h1>


                <div class="main-content">

                    <?php echo $main_content; ?>
                </div>

            </div>


            <div id="email-box" class="col-md-5" style="background-color: <?php  echo '#'.$top_color?>">

                <?php echo $top_content; ?>


            </div>


        </div>

    </div>


    <footer style="background-color: <?php  echo '#'.$footer_color?>">
        <div class="container-fluid" style="padding: 0 0 20px 0;">
            <?php echo $footer_content; ?>
        </div>
    </footer>

    <?php
    break;
    endwhile;
    endif;
    do_action('lp_footer'); // Load custom landing footer hook for 3rd party extensions
    wp_footer(); // Load normal wordpress footer
    ?>
</body>
</html>