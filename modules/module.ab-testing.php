<?php

/* ADMIN ONLY AB TESTING FUNCTIONS */

if (is_admin()) {


    add_filter('lp_show_metabox', 'lp_ab_testing_admin_prepare_meta_ids', 5, 2);
    function lp_ab_testing_admin_prepare_meta_ids($lp_custom_fields, $main_key) {
        if (isset($_REQUEST['new-variation']) && !isset($_REQUEST['clone'])) {
            return $lp_custom_fields;
        }

        $current_variation_id = lp_ab_testing_get_current_variation_id();

        if (isset($_GET['clone'])) {
            $current_variation_id = $_GET['clone'];
        }

        if ($current_variation_id > 0) {
            $post_id = $_GET['post'];
            foreach ($lp_custom_fields as $key => $field) {
                $default = get_post_meta($post_id, $field['id'], true);

                $id = $field['id'];
                $field['id'] = $id . '-' . $current_variation_id;

                if ($default) {
                    $field['default'] = $default;
                }

                $lp_custom_fields[$key] = $field;
            }
            return $lp_custom_fields;
        }

        //print_r($lp_custom_fields);exit;
        return $lp_custom_fields;
    }

    add_filter('lp_variation_selected_template', 'lp_ab_testing_lp_variation_selected_template', 10, 2);
    function lp_ab_testing_lp_variation_selected_template($selected_template, $post) {
        if (isset($_GET['new-variation'])) return $selected_template;

        $current_variation_id = lp_ab_testing_get_current_variation_id();

        if ($current_variation_id > 0) {
            $selected_template = get_post_meta($post->ID, 'lp-selected-template-' . $current_variation_id, true);
        }

        //print_r($lp_custom_fields);exit;
        return $selected_template;
    }

    //add filter to modify thumbnail preview
    add_filter('lp_live_screenshot_url', 'lp_ab_testing_prepare_screenshot');
    function lp_ab_testing_prepare_screenshot($link) {
        $variation_id = lp_ab_testing_get_current_variation_id();
        $link = $link . "?lp-variation-id=" . $variation_id;
        return $link;
    }


    add_filter("post_type_link", "lp_ab_append_variation_id_to_adminbar_link", 10, 2);
    function lp_ab_append_variation_id_to_adminbar_link($link, $post) {
        if ($post->post_type == 'landing-page') {
            $current_variation_id = lp_ab_testing_get_current_variation_id();

            if ($current_variation_id > 0) $link = $link . "?lp-variation-id=" . $current_variation_id;
        }

        return $link;
    }

    if (!defined('AUTOSAVE_INTERVAL')) {
        define('AUTOSAVE_INTERVAL', 86400);
    }

    add_filter('wp_insert_post_data', 'lp_ab_testing_wp_insert_post_data', 10, 2);
    function lp_ab_testing_wp_insert_post_data($data, $postarr) {

        //exit;
        //$variation_id = lp_ab_testing_get_current_variation_id();
        //echo $variation_id;exit;
        if (isset($postarr['lp-variation-id']) && $postarr['lp-variation-id'] > 0) {
            $postarr = array();
            $data = array();

            remove_action('save_post', 'lp_save_meta', 10);
            remove_action('save_post', 'lp_ab_testing_save_post', 10);

            $postID = $_POST['post_ID'];
            if ($parent_id = wp_is_post_revision($_POST['post_ID'])) {
                $postID = $parent_id;
            }

            lp_ab_testing_save_post($postID);

        } else {
            //echo "here";exit;
            //$this_data = json_encode($data);
            //mail('hudson.atwell@gmail.com','test2',$this_data);
        }

        if (count($data) > 1) return $data;
    }

    add_action('save_post', 'lp_ab_testing_save_post');
    function lp_ab_testing_save_post($postID) {
        global $post;

        $var_final = (isset($_POST['lp-variation-id'])) ? $_POST['lp-variation-id'] : '0';
        if (isset($_POST['post_type']) && $_POST['post_type'] == 'landing-page') {
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE || $_POST['post_type'] == 'revision') {
                return;
            }

            if ($parent_id = wp_is_post_revision($postID)) {
                $postID = $parent_id;
            }


            $this_variation = $var_final;
            //echo $this_variation;
            //print_r($_POST);exit;

            //first add to varation list if not present.
            $variations = get_post_meta($postID, 'lp-ab-variations', true);
            if ($variations) {
                $array_variations = explode(',', $variations);
                if (!in_array($this_variation, $array_variations)) {
                    $array_variations[] = $this_variation;
                }
            } else {
                if ($this_variation > 0) {
                    $array_variations[] = 0;
                    $array_variations[] = $this_variation;
                } else {
                    $array_variations[] = $this_variation;
                }
            }

            //print_r($array_variations);exit;
            //update_post_meta($postID,'lp-ab-variations', "");
            update_post_meta($postID, 'lp-ab-variations', implode(',', $array_variations));
            //add_post_meta($postID, 'lp_ab_variation_status-'.$this_variation , 1);

            //echo $this_variation;exit;
            if ($this_variation == 0) {
                return;
            }
            //echo $this_variation;exit;
            //print_r($_POST);

            //next alter all custom fields to store correct varation and create custom fields for special inputs
            $ignore_list = array('post_status', 'post_type', 'tax_input', 'post_author', 'user_ID', 'post_ID', 'catslist', 'post_title', 'samplepermalinknonce', 'autosavenonce', 'action', 'autosave', 'mm', 'jj', 'aa', 'hh', 'mn', 'ss', '_wp_http_referer', 'lp-variation-id', '_wpnonce', 'originalaction', 'original_post_status', 'referredby', '_wp_original_http_referer', 'meta-box-order-nonce', 'closedpostboxesnonce', 'hidden_post_status', 'hidden_post_password', 'hidden_post_visibility', 'visibility', 'post_password', 'hidden_mm', 'cur_mm', 'hidden_jj', 'cur_jj', 'hidden_aa', 'cur_aa', 'hidden_hh', 'cur_hh', 'hidden_mn', 'cur_mn', 'original_publish', 'save', 'newlanding_page_category', 'newlanding_page_category_parent', '_ajax_nonce-add-landing_page_category', 'lp_lp_custom_fields_nonce', 'lp-selected-template', 'post_mime_type', 'ID', 'comment_status', 'ping_status');

            //$special_list = array('content','post-content');
            //print_r($_POST);exit;
            //echo $this_variation;exit;
            foreach ($_POST as $key => $value) {
                //echo $key." : -{$this_variation} : $value<br>";
                if (!in_array($key, $ignore_list) && !strstr($key, 'nonce')) {
                    if ($key == 'post_content') $key = 'content';

                    if (!strstr($key, "-{$this_variation}")) {
                        $new_array[$key . '-' . $this_variation] = $value;
                    } else {
                        //echo $key." : -{$this_variation}<br>";
                        $new_array[$key] = $value;
                    }
                }
                //echo $key." : -{$this_variation} : $value<br>";
            }

            //print_r($new_array);exit;

            foreach ($new_array as $key => $val) {
                $old = get_post_meta($postID, $key, true);
                $new = $val;
                //echo "$key  : $old v. $new <br>";
                //if (isset($new) && $new != $old ) {
                update_post_meta($postID, $key, $new);
                //} elseif ('' == $new && $old) {
                //delete_post_meta($postID, $key, $old);
                //}
            }

        }
    }

} /* PERFORM FRONT-END ONLY ACTIONS */ else {

    //prepare customizer meta data for ab varations
    add_filter('lp_get_value', 'lp_ab_testing_prepare_variation_meta', 1, 4);
    function lp_ab_testing_prepare_variation_meta($return, $post, $key, $id) {
        if (isset($_REQUEST['lp-variation-id']) || isset($_COOKIE['lp-variation-id'])) {
            (isset($_REQUEST['lp-variation-id'])) ? $variation_id = $_REQUEST['lp-variation-id'] : $variation_id = $_COOKIE['lp-variation-id'];
            if ($variation_id > 0) return do_shortcode(get_post_meta($post->ID, $key . '-' . $id . '-' . $variation_id, true)); else
                return $return;
        } else {
            return $return;
        }
    }

    //prepare customizer, admin, and preview links for variations
    add_filter('lp_customizer_customizer_link', 'lp_ab_append_variation_id_to_link');
    add_filter('lp_customizer_admin_bar_link', 'lp_ab_append_variation_id_to_link');
    add_filter('lp_customizer_preview_link', 'lp_ab_append_variation_id_to_link');

    function lp_ab_append_variation_id_to_link($link) {

        $current_variation_id = lp_ab_testing_get_current_variation_id();

        if ($current_variation_id > 0) $link = $link . "&lp-variation-id=" . $current_variation_id;

        return $link;
    }

}

/*PERFORM ACTIONS REQUIRED ON BOTH FRONT AND BACKEND */

add_filter('lp_content_area', 'lp_ab_testing_alter_content_area_admin', 10, 2);
function lp_ab_testing_alter_content_area_admin($content) {
    global $post;

    $variation_id = lp_ab_testing_get_current_variation_id();

    if ($variation_id > 0) {
        $content = get_post_meta($post->ID, 'content-' . $variation_id, true);
        if (!is_admin()) {
            $content = wpautop($content);
            $content = do_shortcode($content);
        }
    }

    return $content;
}

/* RETURN LETTER FROM ARRAY KEY */
function lp_ab_key_to_letter($key) {
    $alphabet = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

    if (isset($alphabet[$key])) {
        return $alphabet[$key];
    }
}

/* GET CURRENT VARIATION ID */
function lp_ab_testing_get_current_variation_id() {
    if (isset($_GET['ab-action']) && is_admin()) {
        return $_SESSION['lp_ab_test_open_variation'];
    }

    if (!isset($_SESSION['lp_ab_test_open_variation']) && !isset($_REQUEST['lp-variation-id'])) {
        $current_variation_id = 0;
    }
    //echo $_REQUEST['lp-variation-id'];
    if (isset($_REQUEST['lp-variation-id'])) {
        $_SESSION['lp_ab_test_open_variation'] = $_REQUEST['lp-variation-id'];
        $current_variation_id = $_REQUEST['lp-variation-id'];
        //echo "setting session $current_variation_id";
    }

    if (isset($_GET['message']) && $_GET['message'] == 1 && isset($_SESSION['lp_ab_test_open_variation'])) {
        $current_variation_id = $_SESSION['lp_ab_test_open_variation'];

        //echo "here:".$_SESSION['lp_ab_test_open_variation'];
    }

    if (isset($_GET['ab-action']) && $_GET['ab-action'] == 'delete-variation') {
        $current_variation_id = 0;
        $_SESSION['lp_ab_test_open_variation'] = 0;
    }

    if (!isset($current_variation_id)) $current_variation_id = 0;

    return $current_variation_id;
}

//ready conversion area for displaying ab variations
add_filter('lp_conversion_area_pre_standardize', 'lp_ab_testing_prepare_conversion_area', 10, 2);
function lp_ab_testing_prepare_conversion_area($content, $post = null) {
    $current_variation_id = lp_ab_testing_get_current_variation_id();

    if (isset($post)) {
        $post_id = $post->ID;
    } else if (isset($_REQUEST['post'])) {
        $post_id = $_REQUEST['post'];
    } else if (isset($_REQUEST['lp_id'])) {
        $post_id = $_REQUEST['lp_id'];
    }

    if ($current_variation_id > 0) $content = get_post_meta($post_id, 'landing-page-myeditor-' . $current_variation_id, true);

    return $content;
}

//ready conversion area for displaying ab variations
add_filter('lp_conversion_area_position', 'lp_ab_testing_lp_conversion_area_position', 10, 2);
function lp_ab_testing_lp_conversion_area_position($position, $post = null, $key = 'default') {

    $current_variation_id = lp_ab_testing_get_current_variation_id();

    if (isset($post)) {
        $post_id = $post->ID;
    } else if (isset($_REQUEST['post'])) {
        $post_id = $_REQUEST['post'];
    } else if (isset($_REQUEST['lp_id'])) {
        $post_id = $_REQUEST['lp_id'];
    }

    if ($current_variation_id > 0) $position = get_post_meta($post->ID, "{$key}-conversion-area-placement-" . $current_variation_id, true);

    return $position;
}


add_filter('lp_main_headline', 'lp_ab_testing_prepare_headline', 10, 2);
function lp_ab_testing_prepare_headline($main_headline, $post = null) {

    $current_variation_id = lp_ab_testing_get_current_variation_id();

    if (isset($post)) {
        $post_id = $post->ID;
    } else if (isset($_REQUEST['post'])) {
        $post_id = $_REQUEST['post'];
    } else if (isset($_REQUEST['lp_id'])) {
        $post_id = $_REQUEST['lp_id'];
    } else if (isset($_REQUEST['post_id'])) {
        $post_id = $_REQUEST['post_id'];
    }


    if ($current_variation_id > 0) $main_headline = get_post_meta($post_id, 'lp-main-headline-' . $current_variation_id, true);

    if (!$main_headline) {
        get_post_meta($post_id, 'lp-main-headline', true);
    }

    return $main_headline;
}

add_action('init', 'lp_ab_testing_add_rewrite_rules');
function lp_ab_testing_add_rewrite_rules() {
    $this_path = LANDINGPAGES_PATH;
    $this_path = explode('wp-content', $this_path);
    $this_path = "wp-content" . $this_path[1];

    $slug = get_option('lp-main-landing-page-permalink-prefix', 'go');
    //echo $slug;exit;
    $ab_testing = get_option('lp-main-landing-page-disable-turn-off-ab', "0");
    if ($ab_testing === "0") {
        add_rewrite_rule("$slug/([^/]*)/([0-9]+)/", "$slug/$1?lp-variation-id=$2", 'top');
        add_rewrite_rule("$slug/([^/]*)?", $this_path . "modules/module.redirect-ab-testing.php?permalink_name=$1 ", 'top');
        add_rewrite_rule("landing-page=([^/]*)?", $this_path . 'modules/module.redirect-ab-testing.php?permalink_name=$1', 'top');
    }
    add_filter('mod_rewrite_rules', 'lp_ab_testing_modify_rules', 1);
    function lp_ab_testing_modify_rules($rules) {
        if (!stristr($rules, 'RewriteCond %{QUERY_STRING} !lp-variation-id')) {
            $rules_array = preg_split('/$\R?^/m', $rules);
            if (count($rules_array) < 3) {
                $rules_array = explode("\n", $rules);
                $rules_array = array_filter($rules_array);
            }

            //print_r($rules_array);exit;

            $this_path = LANDINGPAGES_PATH;
            $this_path = explode('wp-content', $this_path);
            $this_path = "wp-content" . $this_path[1];
            $slug = get_option('lp-main-landing-page-permalink-prefix', 'go');

            $i = 0;
            foreach ($rules_array as $key => $val) {

                if (stristr($val, "RewriteRule ^{$slug}/([^/]*)? ") || stristr($val, "RewriteRule ^{$slug}/([^/]*)/([0-9]+)/ ")) {
                    $new_val = "RewriteCond %{QUERY_STRING} !lp-variation-id";
                    $rules_array[$i] = $new_val;
                    $i++;
                    $rules_array[$i] = $val;
                    $i++;
                } else {
                    $rules_array[$i] = $val;
                    $i++;
                }
            }

            $rules = implode("\r\n", $rules_array);
        }

        return $rules;
    }

}


add_filter('lp_selected_template', 'lp_ab_testing_get_selected_template');//get correct selected template for each variation
function lp_ab_testing_get_selected_template($template) {
    global $post;

    $current_variation_id = lp_ab_testing_get_current_variation_id();

    if ($current_variation_id > 0) {
        $new_template = get_post_meta($post->ID, 'lp-selected-template-' . $current_variation_id, true);
        if ($new_template) {
            $template = $new_template;
        }
    }

    return $template;
}

//prepare custom js and css for
add_filter('lp_custom_js_name', 'lp_ab_testing_prepare_name');
add_filter('lp_custom_css_name', 'lp_ab_testing_prepare_name');
function lp_ab_testing_prepare_name($id) {
    $current_variation_id = lp_ab_testing_get_current_variation_id();
    //echo $current_variation_id;exit;
    if ($current_variation_id > 0) {
        $id = $id . '-' . $current_variation_id;
    }

    return $id;
}

add_action('wp_ajax_lp_ab_testing_prepare_variation', 'lp_ab_testing_prepare_variation_callback');
add_action('wp_ajax_nopriv_lp_ab_testing_prepare_variation', 'lp_ab_testing_prepare_variation_callback');

function lp_ab_testing_prepare_variation_callback() {

    $page_id = lp_url_to_postid(trim($_POST['current_url']));

    $variations = get_post_meta($page_id, 'lp-ab-variations', true);
    $marker = get_post_meta($page_id, 'lp-ab-variations-marker', true);
    if (!is_numeric($marker)) {
        $marker = 0;
    }

    if ($variations) {
        //echo $variations;
        $variations = explode(',', $variations);
        //print_r($variations);

        $variation_id = $variations[$marker];

        $marker++;

        if ($marker >= count($variations)) {
            //echo "here";
            $marker = 0;
        }

        update_post_meta($page_id, 'lp-ab-variations-marker', $marker);

        echo $variation_id;
        die();
    }


}


add_filter('the_content', 'lp_ab_testing_alter_content_area', 10, 2);
add_filter('get_the_content', 'lp_ab_testing_alter_content_area', 10, 2);
function lp_ab_testing_alter_content_area($content) {
    global $post;

    if (!isset($post) || $post->post_type != 'landing-page') {
        return $content;
    }

    $variation_id = lp_ab_testing_get_current_variation_id();

    if ($variation_id > 0) {
        $content = do_shortcode(get_post_meta($post->ID, 'content-' . $variation_id, true));
    }

    return $content;
}

add_filter('wp_title', 'lp_ab_testing_alter_title_area', 9, 2);
add_filter('the_title', 'lp_ab_testing_alter_title_area', 10, 2);
add_filter('get_the_title', 'lp_ab_testing_alter_title_area', 10, 2);
function lp_ab_testing_alter_title_area($content, $id = null) {
    global $post;

    if (!isset($post)) return $content;

    if (($post->post_type != 'landing-page' || is_admin()) || $id != $post->ID) return $content;

    return lp_main_headline($post, null, true);
}

add_action('lp_record_impression', 'lp_ab_testing_record_impression', 10, 3);
function lp_ab_testing_record_impression($post_id, $post_type = 'landing-page', $variation_id = 0) {

    /* If Landing Page Post Type */
    if ($post_type == 'landing-page') {
        $meta_key = 'lp-ab-variation-impressions-' . $variation_id;
    } /* If Non Landing Page Post Type */ else {
        $meta_key = '_inbound_impressions_count';
    }

    $impressions = get_post_meta($post_id, $meta_key, true);

    if (!is_numeric($impressions)) {
        $impressions = 1;
    } else {
        $impressions++;
    }

    update_post_meta($post_id, $meta_key, $impressions);
}


add_action('lp_launch_customizer_pre', 'lp_ab_testing_customizer_enqueue');
function lp_ab_testing_customizer_enqueue($post) {

    $permalink = get_permalink($post->ID);
    $randomstring = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);

    wp_enqueue_script('lp_ab_testing_customizer_js', LANDINGPAGES_URLPATH . 'js/customizer.ab-testing.js', array('jquery'));
    wp_localize_script('lp_ab_testing_customizer_js', 'ab_customizer', array('lp_id' => $post->ID, 'permalink' => $permalink, 'randomstring' => $randomstring));
    wp_enqueue_style('lp_ab_testing_customizer_css', LANDINGPAGES_URLPATH . 'css/customizer-ab-testing.css');
}