<?php


//=============================================
// Define constants
//=============================================
if (!defined('INBOUND_FORMS')) {
    define('INBOUND_FORMS', plugin_dir_url(__FILE__));
}
if (!defined('INBOUND_FORMS_PATH')) {
    define('INBOUND_FORMS_PATH', plugin_dir_path(__FILE__));
}
if (!defined('INBOUND_FORMS_BASENAME')) {
    define('INBOUND_FORMS_BASENAME', plugin_basename(__FILE__));
}
if (!defined('INBOUND_FORMS_ADMIN')) {
    define('INBOUND_FORMS_ADMIN', get_bloginfo('url') . "/wp-admin");
}


define( 'INBOUND_LABEL', str_replace( ' ', '_', strtolower( 'Inbound Now' ) ) );

require_once( 'shortcodes-includes.php' );

/*  InboundNow Shortcodes Class
 *  --------------------------------------------------------- */
if (!class_exists('InboundShortcodes')) {
class InboundShortcodes {
  static $add_script;
/*  Contruct
 *  --------------------------------------------------------- */
  static function init() {
    self::$add_script = true;
    add_action('admin_enqueue_scripts', array( __CLASS__, 'loads' ));
    add_action('init', array( __CLASS__, 'shortcodes_tinymce' ));
    add_action( 'wp_enqueue_scripts',  array(__CLASS__, 'frontend_loads')); // load styles
    add_action('wp_footer', array(__CLASS__, 'inline_my_script'));
  }

/*  Loads
 *  --------------------------------------------------------- */
  static function loads($hook) {

    if ( $hook == 'post.php' || $hook == 'post-new.php' || $hook == 'page-new.php' || $hook == 'page.php' ) {
      wp_enqueue_style('inbound-shortcodes', INBOUND_FORMS.'css/shortcodes.css');
      wp_enqueue_script('jquery-ui-sortable' );
      wp_enqueue_script('inbound-shortcodes-plugins', INBOUND_FORMS . 'js/shortcodes-plugins.js');
      wp_enqueue_script('inbound-shortcodes', INBOUND_FORMS . 'js/shortcodes.js');
      // Check for active plugins and localize
      $plugins_loaded = array();
      if (is_plugin_active('landing-pages/landing-pages.php')) {
      array_push($plugins_loaded, "landing-pages");
      }
      if (is_plugin_active('cta/wordpress-cta.php')) {
      array_push($plugins_loaded, "cta");
      }
      if (is_plugin_active('leads/wordpress-leads.php')) {
      array_push($plugins_loaded, "leads");
      }
      wp_localize_script( 'inbound-shortcodes', 'inbound_load', array( 'image_dir' => INBOUND_FORMS, 'inbound_plugins' => $plugins_loaded, 'pop_title' => 'Insert Shortcode' ));
      //add_action('admin_head', array( __CLASS__, 'shortcodes_admin_head' ));
    }
  }

  // compress and move to file 
  static function inline_my_script() {
      if ( ! self::$add_script )
      return;

    echo '<script>
          jQuery(document).ready(function($){ 
          
          function validateEmail(email) { 

              var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
              return re.test(email);
          }
          var parent_redirect = parent.window.location.href;
          jQuery("#inbound_parent_page").val(parent_redirect);

  
         // validate email
           $("input.inbound-email").keyup(function() {
               var email = $(this).val();
                if (validateEmail(email)) {
                  $(this).css("color", "green");
                  $(this).addClass("valid-email");
                  $(this).removeClass("invalid-email");
                } else {
                  $(this).css("color", "red");
                  $(this).addClass("invalid-email");
                  $(this).removeClass("valid-email");
                }
              if($(this).hasClass("valid-email")) {
                   $(this).parent().parent().find("#inbound_form_submit").removeAttr("disabled");
              }
           });

          });
          </script>';

    echo "<style type='text/css'>
      /* Add button style options http://medleyweb.com/freebies/50-super-sleek-css-button-style-snippets/ */  
        input.invalid-email {-webkit-box-shadow: 0 0 6px #F8B9B7;
                          -moz-box-shadow: 0 0 6px #f8b9b7;
                          box-shadow: 0 0 6px #F8B9B7;
                          color: #B94A48;
                          border-color: #E9322D;}
        input.valid-email {-webkit-box-shadow: 0 0 6px #B7F8BA;
                    -moz-box-shadow: 0 0 6px #f8b9b7;
                    box-shadow: 0 0 6px #98D398;
                    color: #008000;
                    border-color: #008000;}                
            </style>";
    }


  static function frontend_loads() {
      wp_enqueue_style('inbound-shortcodes', INBOUND_FORMS.'css/frontend-render.css');
  }

// Currently off
  static function shortcodes_admin_head() { ?>
  <script type="text/javascript">
  /* <![CDATA[ */
  // Load inline scripts var freshthemes_theme_dir = "<?php // echo INBOUND_FORMS; ?>", test = "<?php // _e('Insert Shortcode', INBOUND_LABEL); ?>";
  /* ]]> */
  </script>
 <?php }

/*  TinyMCE
 *  --------------------------------------------------------- */
  static function shortcodes_tinymce() {
    if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
      return;
  
    if ( get_user_option('rich_editing') == 'true' ) {
      add_filter( 'mce_external_plugins', array( __CLASS__, 'add_rich_plugins' ) );
      add_filter( 'mce_buttons', array( __CLASS__, 'register_rich_buttons' ) );
    }
  }

  static function add_rich_plugins( $plugins ) {
    $plugins['InboundShortcodes'] = INBOUND_FORMS . 'js/tinymce.js';
    return $plugins;
  }
  
  static function register_rich_buttons( $buttons ) {
    array_push( $buttons, "|", 'InboundShortcodesButton' );
    return $buttons;
  }
}
}
/*  Initialize InboundNow Shortcodes
 *  --------------------------------------------------------- */
InboundShortcodes::init();
?>