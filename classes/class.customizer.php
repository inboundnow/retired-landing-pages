<?php

class Landing_Pages_Customizer {

    /**
     * initiate class
     */
    public function __construct() {
        self::add_hooks();

        /* Kill admin bar on visual editor preview window */
        if (isset($_GET['cache_bust']) || isset($_GET['iframe_window']) ) {
            show_admin_bar(false);
        }
    }

    /**
     * load hooks and filters
     */
    public static function add_hooks() {
        add_action('wp_before_admin_bar_render', array( __CLASS__ , 'add_costomizer_menu_item_to_admin_bar') );

        /* load iframed preview page */
        if (isset($_GET['iframe_window'])) {
            add_action('wp_head', array( __CLASS__ , 'load_preview_iframe' ) );
            add_action('admin_enqueue_scripts', array( __CLASS__ , 'enqueue_scripts_iframe' ) );
        }

        /* load landing page edit area */
        if (isset($_GET['frontend']) && $_GET['frontend'] === 'true') {
            add_action('admin_enqueue_scripts', array( __CLASS__ , 'enqueue_scripts_editor' )  );
        }

        /* Load customizer main split container hooks */
        if (isset($_GET['template-customize']) && $_GET['template-customize'] == 'on') {
            add_action('wp_enqueue_scripts', array( __CLASS__ , 'enqueue_scripts_controller' )  );
            add_filter('wp_head', array( __CLASS__ , 'load_customizer_controller' ) );
        }
    }

    /**
     * Add to edit screen admin view
     */
    public static function add_costomizer_menu_item_to_admin_bar() {

        global $post;
        global $wp_admin_bar;

        if (is_admin() || !isset($post) || $post->post_type != 'landing-page') {
            return;
        }

        $permalink = Landing_Pages_Variations::get_variation_permalink( $post->ID );

        if ( isset($_GET['template-customize']) && $_GET['template-customize'] == 'on') {
            $menu_title = __( 'Turn Off Editor' , 'landing-pages' );
        } else {
            $menu_title = __( 'Launch Visual Editor' , 'landing-pages' );
            $permalink = add_query_arg( array( 'template-customize' => 'on' ) , $permalink );
        }


        $wp_admin_bar->add_menu(array('id' => 'launch-lp-front-end-customizer', 'title' => __($menu_title, 'landing-pages'), 'href' => $permalink));
        $wp_admin_bar->add_menu(array('id' => 'lp-list-pages', 'title' => __("View Landing Page List", 'landing-pages'), 'href' => '/wp-admin/edit.php?post_type=landing-page'));
    }

    /**
     * Enqueue scripts and css for iframe preview side of customizer
     */
    public static function enqueue_scripts_iframe() {
        wp_enqueue_style('lp_ab_testing_customizer_css', LANDINGPAGES_URLPATH . 'css/frontend/customizer-preview.css');
    }

    /**
     * Enqueue scripts and css for editor side of customizer
     */
    public static function enqueue_scripts_editor() {

        wp_enqueue_style('lp-customizer-admin', LANDINGPAGES_URLPATH . 'css/admin/customizer-edit.css');
        wp_enqueue_script('lp-customizer-admin', LANDINGPAGES_URLPATH . 'js/admin/new-customizer-admin.js');

    }

    /**
     * Enqueue scripts and css for iframe preview side of customizer
     */
    public static function enqueue_scripts_controller() {
        global $post;

        $permalink = get_permalink($post->ID);
        $randomstring = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);

        wp_enqueue_script('lp_ab_testing_customizer_js', LANDINGPAGES_URLPATH . 'js/customizer.ab-testing.js', array('jquery'));
        wp_localize_script('lp_ab_testing_customizer_js', 'ab_customizer', array('lp_id' => $post->ID, 'permalink' => $permalink, 'randomstring' => $randomstring));
        wp_enqueue_style('lp_ab_testing_customizer_css', LANDINGPAGES_URLPATH . 'css/customizer-ab-testing.css');
    }

    public static function load_customizer_controller() {

        global $post;

        $permalink = get_permalink($post->ID);

        $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
        $variation_id = Landing_Pages_Variations::get_current_variation_id( $post->ID );

        $preview_link = add_query_arg( array( 'lp-variation-id' => $variation_id , 'live-preview-area' => $randomString ) , $permalink );
        $customizer_link = add_query_arg( array( 'lp-variation-id' => $variation_id , 'post' => $post->ID , 'action' => 'edit' , 'frontend' => 'true' ) , admin_url('post.php') );

        do_action('lp_launch_customizer_pre', $post);
        ?>

        <style type="text/css">
            #wpadminbar {
                z-index: 99999999999 !important;
            }

            #lp-live-preview #wpadminbar {
                margin-top: 0px;
            }

            .lp-load-overlay {
                position: absolute;
                z-index: 9999999999 !important;
                z-index: 999999;
                background-color: #000;
                opacity: 0;
                background: -moz-radial-gradient(center, ellipse cover, rgba(0, 0, 0, 0.4) 0, rgba(0, 0, 0, 0.9) 100%);
                background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%, rgba(0, 0, 0, 0.4)), color-stop(100%, rgba(0, 0, 0, 0.9)));
                background: -webkit-radial-gradient(center, ellipse cover, rgba(0, 0, 0, 0.4) 0, rgba(0, 0, 0, 0.9) 100%);
                background: -o-radial-gradient(center, ellipse cover, rgba(0, 0, 0, 0.4) 0, rgba(0, 0, 0, 0.9) 100%);
                background: -ms-radial-gradient(center, ellipse cover, rgba(0, 0, 0, 0.4) 0, rgba(0, 0, 0, 0.9) 100%);
                background: radial-gradient(center, ellipse cover, rgba(0, 0, 0, 0.4) 0, rgba(0, 0, 0, 0.9) 100%);
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#66000000', endColorstr='#e6000000', GradientType=1);
                -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=50)";
                filter: alpha(opacity=50);

            }
        </style>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                jQuery("#wp-admin-bar-edit a").text("Main Edit Screen");

                setTimeout(function () {
                    jQuery(document).find("#lp-live-preview").contents().find("#wpadminbar").hide()
                    jQuery(document).find("#lp-live-preview").contents().find("html").css("margin-bottom", "-28px");

                }, 2000);
            });

        </script>

        <?php

        echo '<div class="lp-load-overlay" style="top: 0;bottom: 0; left: 0;right: 0;position: fixed;opacity: .8; display:none;"></div><iframe id="lp_customizer_options" src="' . $customizer_link . '" style="width: 32%; height: 100%; position: fixed; left: 0px; z-index: 999999999; top: 26px;"></iframe>';

        echo '<iframe id="lp-live-preview" src="' . $preview_link . '" style="width: 68%; height: 100%; position: fixed; right: 0px; top: 26px; z-index: 999999999; background-color: #eee;
	//background-image: linear-gradient(45deg, rgb(194, 194, 194) 25%, transparent 25%, transparent 75%, rgb(194, 194, 194) 75%, rgb(194, 194, 194)), linear-gradient(-45deg, rgb(194, 194, 194) 25%, transparent 25%, transparent 75%, rgb(194, 194, 194) 75%, rgb(194, 194, 194));
	//background-size:25px 25px; background-position: initial initial; background-repeat: initial initial;"></iframe>';
        wp_footer();
        exit;
    }

    /**
     * Loads preview iframe
     */
    public static function load_preview_iframe() {
        $variation_id = Landing_Pages_Variations::get_current_variation_id();
        $landing_page_id = $_GET['post_id'];

        $variations = Landing_Pages_Variations::get_variations( $landing_page_id );
        ?>
        <link rel="stylesheet" href="<?php echo LANDINGPAGES_URLPATH . 'css/customizer-ab-testing.css';?>"/>
        <style type="text/css">

            #variation-list {
                position: absolute;
                top: 0px;
                left: 0px;
                padding-left: 5px;
            }

            #variation-list h3 {
                text-decoration: none;
                border-bottom: none;
            }

            #variation-list div {
                display: inline-block;
            }

            #current_variation_id, #current-post-id {
                display: none !important;
            }

        </style>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                var current_page = jQuery("#current_variation_id").text();
                // reload the iframe preview page (for option toggles)
                jQuery('.variation-lp').on('click', function (event) {
                    variation_is = jQuery(this).attr("id");
                    var original_url = jQuery(parent.document).find("#TB_iframeContent").attr("src");
                    var current_id = jQuery("#current-post-id").text();
                    someURL = original_url;

                    splitURL = someURL.split('?');
                    someURL = splitURL[0];
                    new_url = someURL + "?lp-variation-id=" + variation_is + "&iframe_window=on&post_id=" + current_id;
                    jQuery(parent.document).find("#TB_iframeContent").attr("src", new_url);
                });
            });
        </script>
        <?php
        if ($variations[0] === "") {
            echo '<div id="variation-list" class="no-abtests"><h3>' . __('No A/B Tests running for this page', 'landing-pages') . '</h3>';
        } else {
            echo '<div id="variation-list"><h3>' . __('Variations', 'landing-pages') . ':</h3>';
            echo '<div id="current_variation_id">' . $variation_id . '</div>';
        }

        foreach ($variations as $key => $val) {
            $current_view = ($val == $variation_id) ? 'current-variation-view' : '';
            echo "<div class='variation-lp " . $current_view . "' id=" . $val . ">";
            echo Landing_Pages_Variations::vid_to_letter( $landing_page_id , $key);

            // echo $val; number
            echo "</div>";
        }
        echo "<span id='current-post-id'>$landing_page_id</span>";

        echo '</div>';
    }
}


new Landing_Pages_Customizer;