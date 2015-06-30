<?php


class Landing_Pages_Metaboxes {

    static $current_vid;
    static $variations;
    static $is_new;
    static $is_clone;
    static $content_area;

    /**
     * initiate class
     */
    public function __construct() {
        self::add_hooks();
    }

    /**
     * load hooks and filters
     */
    public static function add_hooks() {
        add_action( 'admin_init' , array( __CLASS__ , 'run_actions' ) );
        add_action( 'admin_enqueue_scripts' , array( __CLASS__ , 'enqueue_scripts' ) );
        add_action( 'add_meta_boxes' , array( __CLASS__ , 'register_metaboxes' ) );
        add_filter( 'wp_default_editor', array( __CLASS__  , 'filter_default_wysiwyg_view' ) );

        /* get selected template metabox html */
        add_action( 'wp_ajax_lp_get_template_meta' , array( __CLASS__ , 'ajax_get_temaplte_metabox_html' ));
    }

    /**
     * Register metaboxes
     */
    public static function register_metaboxes() {

        global $post;

        if ( !isset($post) || $post->post_type!='landing-page') {
            return;
        }

        /* Select Template Metbox */
        add_meta_box(
            'lp_metabox_select_template', // $id
            __( 'Landing Page Templates', 'landing-pages'),
            array( __CLASS__ , 'display_select_template' ),
            'landing-page',
            'normal',
            'high'
        );


        $extension_data = lp_get_extension_data();
        $current_template = Landing_Pages_Variations::get_current_template($post->ID);

        foreach ($extension_data as $key => $data) {

            if ( $key != $current_template) {
                continue;
            }

            $template_name = ucwords(str_replace('-', ' ', $key));
            $id = strtolower(str_replace(' ', '-', $key));

            add_meta_box(
                "lp_{$id}_custom_meta_box", // $id
                "<small>$template_name</small>",
                array( __CLASS__ , 'display_extended_metabox' ),
                'landing-page', // post-type
                'normal', // $context
                'default',// $priority
                array('key' => $key)
            );

        }

        /* discover extended metaboxes and render them */
        foreach ($extension_data as $key => $data) {

            if ( !isset( $data['info']['data_type']) ||  $data['info']['data_type'] != 'metabox') {
                continue;
            }

            $id = "metabox-" . $key;

            (isset($data['info']['label'])) ? $name = $data['info']['label'] : $name = ucwords(str_replace(array('-', 'ext '), ' ', $key) . " Extension Options");
            (isset($data['info']['position'])) ? $position = $data['info']['position'] : $position = "normal";
            (isset($data['info']['priority'])) ? $priority = $data['info']['priority'] : $priority = "default";

            add_meta_box(
                "lp_{$id}_custom_meta_box",
                $name,
                array( __CLASS__ , 'display_extended_metabox' ),
                'landing-page',
                $position,
                $priority,
                array('key' => $key)
            );
        }
    }

    /**
     * Run administrative actions on landing page
     */
    public static function run_actions() {

        global $post;

        if ( !isset($post) || $post->post_type != 'landing-page') {
            return;
        }


        self::$current_vid = lp_ab_testing_get_current_variation_id();

        self::$variations = get_post_meta($post->ID, 'lp-ab-variations', true);

        //remove landing page's main save_post action
        if (self::$current_vid > 0) {
            remove_action('save_post', 'lp_save_meta', 10);
        }

        //check for delete command
        if (isset($_GET['ab-action']) && $_GET['ab-action'] == 'delete-variation') {
            Landing_Pages_Variations::delete_variation( $post->ID , self::$current_vid );
        }

        //check for pause command
        if (isset($_GET['ab-action']) && $_GET['ab-action'] == 'pause-variation') {
            Landing_Pages_Variations::pause_variation( $post->ID , self::$current_vid );

        }

        //check for pause command
        if (isset($_GET['ab-action']) && $_GET['ab-action'] == 'play-variation') {
            Landing_Pages_Variations::play_variation( $post->ID , self::$current_vid );
        }

        self::$is_new = (isset($_GET['new-variation'])) ? 1 : 0;
        self::$is_clone = (isset($_GET['clone'])) ? $_GET['clone'] : null;
        self::$content_area = lp_content_area($post, null, true);

        /* If new variation and no clone id */
        if (self::$is_new && !is_numeric(self::$is_clone) ) {
            self::$content_area = get_post_field ('post_content', $post->ID );
            self::$content_area = wpautop(self::$content_area);
        }

        /* If cloning variation 0 */
        if (is_numeric(self::$is_clone) && self::$is_clone === 0) {
            self::$content_area = get_post_field ('post_content', $post->ID );
            self::$content_area = wpautop(self::$content_area);
        }

        /* if new variation and clone is set */
        if ( self::$is_new == 1 && isset(self::$is_clone) && self::$is_clone > 0 ) {
            self::$content_area = get_post_field('content-' . self::$is_clone, $post->ID );
            self::$content_area = wpautop(self::$content_area);
        }

        (isset($_GET['new-variation']) && $_GET['new-variation'] == 1) ? $new_variation = 1 : $new_variation = 0;

        //if new variation and cloning then programatically prepare the next variation id
        if (self::$is_new ) {
            $_SESSION['lp_ab_test_open_variation'] = Landing_Pages_Variations::prepare_new_variation_id( $post->ID );
        }
    }


    /**
     * Enqueue scripts
     */
    public static function enqueue_scripts() {

        global $post;

        if ( !isset($post) || $post->post_type != 'landing-page') {
            return;
        }

        wp_enqueue_style('lp-ab-testing-admin-css', LANDINGPAGES_URLPATH . 'css/admin-ab-testing.css');
        wp_enqueue_script('lp-ab-testing-admin-js', LANDINGPAGES_URLPATH . 'js/admin/admin.post-edit-ab-testing.js', array('jquery'));
        wp_localize_script('lp-ab-testing-admin-js', 'variation', array('pid' => $post->ID , 'vid' => self::$current_vid, 'new_variation' => self::$is_new , 'variations' => self::$variations, 'content_area' => self::$content_area));

    }

    /**
     * force wysiwyg eeditor to open in html mode
     * @return string
     */
    public static function filter_default_wysiwyg_view( $default ) {
        global $post;
        if ( !isset($post) || $post->post_type != 'landing-page' ) {
            return $default;
        }

        return 'html';
    }


    /**
     * dipslay select template metabox
     */
    public static function display_select_template() {
        global $post;

        $template =  Landing_Pages_Variations::get_current_template( $post->ID );

        $name = Landing_Pages_Variations::prepare_input_id( 'lp-selected-template' );

        // Use nonce for verification
        echo "<input type='hidden' name='lp_lp_custom_fields_nonce' value='".wp_create_nonce('lp-nonce')."' />";
        ?>

        <div id="lp_template_change"><h2>
                <a class="button" id="lp-change-template-button"><?php _e( 'Choose Another Template' , 'landing-pages'); ?></a>
        </div>
        <input type='hidden' id='lp_select_template' name='<?php echo $name; ?>' value='<?php echo $template; ?>'>
        <div id="template-display-options">

        </div>

    <?php
    }


    /**
     * generate metabox html from extended dataset
     */
    public static function display_extended_metabox( $post , $args) {

        $extension_data = lp_get_extension_data();

        $key = $args['args']['key'];

        $lp_custom_fields = $extension_data[$key]['settings'];
        $lp_custom_fields = apply_filters('lp_show_metabox', $lp_custom_fields , $key);

        self::render_fields($key , $lp_custom_fields , $post);
    }

    /**
     * Renders metabox html
     * @param STRING $key data key
     * @param ARRAY $custom_fields field data
     */
    public static function render_fields($key, $custom_fields, $post) {

        /* Use nonce for verification */
        echo "<input type='hidden' name='lp_{$key}_custom_fields_nonce' value='" . wp_create_nonce('lp-nonce') . "' />";

        /*  Begin the field table and loop */
        echo '<div class="form-table" id="inbound-meta">';

        foreach ($custom_fields as $field) {

            $field_id = $key . "-" . $field['id'];
            $field_name = $field['id'];
            $label_class = $field['id'] . "-label";
            $type_class = " inbound-" . $field['type'];
            $type_class_row = " inbound-" . $field['type'] . "-row";
            $type_class_option = " inbound-" . $field['type'] . "-option";
            $option_class = (isset($field['class'])) ? $field['class'] : '';

            $ink = get_option('lp-license-keys-' . $key);
            $status = get_option('lp_license_status-' . $key);
            $status_test = (isset($status) && $status != "") ? $status : 'inactive';

            $meta = get_post_meta($post->ID, $field_id, true);
            $global_meta = get_post_meta($post->ID, $field_name, true);

            if (empty($global_meta)) {
                $global_meta = $field['default'];
            }

            if (!metadata_exists('post', $post->ID, $field_id)) {
                $meta = $field['default'];
            }

            /* Remove prefixes on global => true template options */
            if (isset($field['global']) && $field['global'] === true) {
                $field_id = $field_name;
                $meta = get_post_meta($post->ID, $field_name, true);
            }

            /* begin a table row with */
            echo '<div class="' . $field['id'] . $type_class_row . ' div-' . $option_class . ' wp-call-to-action-option-row inbound-meta-box-row">';

            if ($field['type'] != "description-block" && $field['type'] != "custom-css") {
                echo '<div id="inbound-' . $field_id . '" data-actual="' . $field_id . '" class="inbound-meta-box-label wp-call-to-action-table-header ' . $label_class . $type_class . '"><label for="' . $field_id . '">' . $field['label'] . '</label></div>';
            }

            echo '<div class="wp-call-to-action-option-td inbound-meta-box-option ' . $type_class_option . '" data-field-type="' . $field['type'] . '">';
            switch ($field['type']) {
                /* default content for the_content */
                case 'default-content':
                    echo '<span id="overwrite-content" class="button-secondary">Insert Default Content into main Content area</span><div style="display:none;"><textarea name="' . $field_id . '" id="' . $field_id . '" class="default-content" cols="106" rows="6" style="width: 75%; display:hidden;">' . $meta . '</textarea></div>';
                    break;
                case 'description-block':
                    echo '<div id="' . $field_id . '" class="description-block">' . $field['description'] . '</div>';
                    break;
                case 'custom-css':
                    echo '<style type="text/css">' . $field['default'] . '</style>';
                    break;
                /* text */
                case 'colorpicker':
                    if (!$meta) {
                        $meta = $field['default'];
                    }
                    $var_id = (isset($_GET['new_meta_key'])) ? "-" . $_GET['new_meta_key'] : '';
                    echo '<input type="text" class="jpicker" style="background-color:#' . $meta . '" name="' . $field_id . '" id="' . $field_id . '" value="' . $meta . '" size="5" /><span class="button-primary new-save-lp" data-field-type="text" id="' . $field_id . $var_id . '" style="margin-left:10px; display:none;">Update</span>
                                <div class="lp_tooltip tool_color" title="' . $field['description'] . '"></div>';
                    break;
                case 'datepicker':
                    echo '<div class="jquery-date-picker inbound-datepicker" id="date-picking" data-field-type="text">
                        <span class="datepair" data-language="javascript">
                                    Date: <input type="text" id="date-picker-' . $key . '" class="date start" /></span>
                                    Time: <input id="time-picker-' . $key . '" type="text" class="time time-picker" />
                                    <input type="hidden" name="' . $field_id . '" id="' . $field_id . '" value="' . $meta . '" class="new-date" value="" >
                                    <p class="description">' . $field['description'] . '</p>
                            </div>';
                    break;
                case 'text':
                    echo '<input type="text" name="' . $field_id . '" id="' . $field_id . '" value="' . $meta . '" size="30" />
                                <div class="lp_tooltip" title="' . $field['description'] . '"></div>';
                    break;
                case 'number':

                    echo '<input type="number" class="' . $option_class . '" name="' . $field_id . '" id="' . $field_id . '" value="' . $meta . '" size="30" />
                                <div class="lp_tooltip" title="' . $field['description'] . '"></div>';

                    break;
                /* textarea */
                case 'textarea':
                    echo '<textarea name="' . $field_id . '" id="' . $field_id . '" cols="106" rows="6" style="width: 75%;">' . $meta . '</textarea>
                                <div class="lp_tooltip tool_textarea" title="' . $field['description'] . '"></div>';
                    break;
                /* wysiwyg */
                case 'wysiwyg':
                    echo "<div class='iframe-options iframe-options-" . $field_id . "' id='" . $field['id'] . "'>";
                    wp_editor($meta, $field_id, $settings = array('editor_class' => $field_name));
                    echo '<p class="description">' . $field['description'] . '</p></div>';
                    break;
                /* media */
                case 'media':
                    //echo 1; exit;
                    echo '<label for="upload_image" data-field-type="text">';
                    echo '<input name="' . $field_id . '"  id="' . $field_id . '" type="text" size="36" name="upload_image" value="' . $meta . '" />';
                    echo '<input class="upload_image_button" id="uploader_' . $field_id . '" type="button" value="Upload Image" />';
                    echo '<p class="description">' . $field['description'] . '</p>';
                    break;
                /* checkbox */
                case 'checkbox':
                    $i = 1;
                    echo "<table class='lp_check_box_table'>";
                    if (!isset($meta)) {
                        $meta = array();
                    } elseif (!is_array($meta)) {
                        $meta = array($meta);
                    }
                    foreach ($field['options'] as $value => $label) {
                        if ($i == 5 || $i == 1) {
                            echo "<tr>";
                            $i = 1;
                        }
                        echo '<td data-field-type="checkbox"><input type="checkbox" name="' . $field_id . '[]" id="' . $field_id . '" value="' . $value . '" ', in_array($value, $meta) ? ' checked="checked"' : '', '/>';
                        echo '<label for="' . $value . '">&nbsp;&nbsp;' . $label . '</label></td>';
                        if ($i == 4) {
                            echo "</tr>";
                        }
                        $i++;
                    }
                    echo "</table>";
                    echo '<div class="lp_tooltip tool_checkbox" title="' . $field['description'] . '"></div>';
                    break;
                /* radio */
                case 'radio':
                    foreach ($field['options'] as $value => $label) {
                        //echo $meta.":".$field_id;
                        //echo "<br>";
                        echo '<input type="radio" name="' . $field_id . '" id="' . $field_id . '" value="' . $value . '" ', $meta == $value ? ' checked="checked"' : '', '/>';
                        echo '<label for="' . $value . '">&nbsp;&nbsp;' . $label . '</label> &nbsp;&nbsp;&nbsp;&nbsp;';
                    }
                    echo '<div class="lp_tooltip" title="' . $field['description'] . '"></div>';
                    break;
                /* select */
                case 'dropdown':
                    echo '<select name="' . $field_id . '" id="' . $field_id . '" class="' . $field['id'] . '">';
                    foreach ($field['options'] as $value => $label) {
                        echo '<option', $meta == $value ? ' selected="selected"' : '', ' value="' . $value . '">' . $label . '</option>';
                    }
                    echo '</select><div class="lp_tooltip" title="' . $field['description'] . '"></div>';
                    break;


            }
            echo '</div></div>';
        } // end foreach
        echo '</div>'; // end table
        //exit;
    }


    /**
     * Ajax listener to get template settings html
     */
    public static function ajax_get_temaplte_metabox_html() {
        global $wpdb;

        $current_template = $_POST['selected_template'];

        $post_id = $_POST['post_id'];
        $post = get_post($post_id);

        $args['args']['key'] = $current_template;

        self::display_extended_metabox($post, $args);
        die();
    }
}


new Landing_Pages_Metaboxes;