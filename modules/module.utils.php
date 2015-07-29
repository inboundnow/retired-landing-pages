<?php
/*
*	Utilities functions used throughout the plugin
*/

/* GET POST ID FROM URL FOR LANDING PAGES */
function lp_url_to_postid($url) {
    global $wpdb;

    if (strstr($url, '?landing-page=')) {
        $url = explode('?landing-page=', $url);
        $url = $url[1];
        $url = explode('&', $url);
        $post_id = $url[0];

        return $post_id;
    }

    //first check if URL is homepage
    $wordpress_url = get_bloginfo('url');
    if (substr($wordpress_url, -1, -1) != '/') {
        $wordpress_url = $wordpress_url . "/";
    }

    if (str_replace('/', '', $url) == str_replace('/', '', $wordpress_url)) {
        return get_option('page_on_front');
    }

    $parsed = parse_url($url);
    $url = $parsed['path'];

    $parts = explode('/', $url);

    $count = count($parts);
    $count = $count - 1;

    if (empty($parts[$count])) {
        $i = $count - 1;
        $slug = $parts[$i];
    } else {
        $slug = $parts[$count];
    }

    $my_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '$slug' AND post_type='landing-page'");

    if ($my_id) {
        return $my_id;
    } else {
        return 0;
    }
}



/* Fix wp_title for known bad behavior themes */
add_action('wp', 'landingpage_fix_known_wp_title_isses', 10);
function landingpage_fix_known_wp_title_isses() {

    if ('landing-page' != get_post_type()) {
        return;
    }

    remove_filter('wp_title', 'genesis_doctitle_wrap', 20);
    remove_filter('wp_title', 'genesis_default_title', 10);
}

/* Fix qtranslate issues */
if (!function_exists('inbound_qtrans_disable')) {
    function inbound_qtrans_disable() {
        global $typenow, $pagenow;

        if (in_array($typenow, array('landing-page' || 'wp-call-to-action')) && // post_types where qTranslate should be disabled
            in_array($pagenow, array('post-new.php', 'post.php'))
        ) {
            remove_action('admin_head', 'qtrans_adminHeader');
            remove_filter('admin_footer', 'qtrans_modifyExcerpt');
            remove_filter('the_editor', 'qtrans_modifyRichEditor');
        }
    }
}
add_action('current_screen', 'inbound_qtrans_disable');



/**
 * Add namespaces for legacy classes to try and prevent fatals
 */
if (!class_exists('LP_EXTENSION_UPDATER') ){
    class LP_EXTENSION_UPDATER { };
    class LP_EXTENSION_LICENSENING { };
}