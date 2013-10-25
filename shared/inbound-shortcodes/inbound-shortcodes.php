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
  }

/*  Loads
 *  --------------------------------------------------------- */
  static function loads($hook) {

    if ( $hook == 'post.php' || $hook == 'post-new.php' || $hook == 'page-new.php' || $hook == 'page.php' ) {
      wp_enqueue_style('inbound-shortcodes', INBOUND_FORMS.'css/shortcodes.css');
      wp_enqueue_script('jquery-ui-sortable' );
      wp_enqueue_script('inbound-shortcodes-plugins', INBOUND_FORMS . 'js/shortcodes-plugins.js');
      wp_enqueue_script('inbound-shortcodes', INBOUND_FORMS . 'js/shortcodes.js');
      wp_localize_script( 'inbound-shortcodes', 'inbound_shortcodes', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'inbound_shortcode_nonce' => wp_create_nonce('inbound-shortcode-nonce') ) );
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