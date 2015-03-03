<?php


function load_popup_ajax_request()
{


    include('shortcodes-fields.php');
    $popup = trim($_GET['popup']);

    $shortcode = new Inbound_Shortcodes_Fields($popup);


    ?>

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head></head>
    <body>
    <div id="inbound-shortcodes-popup">

        <div id="inbound-shortcodes-wrap">
            <div id="inbound-shortcodes-form-wrap">

                <div id="inbound-shortcodes-form-head">
                    <?php echo $shortcode->popup_title; ?>
                    <?php $shortcode_id = strtolower(str_replace(array(' ', '-'), '_', $shortcode->popup_title)); ?>
                </div>
                <form method="post" id="inbound-shortcodes-form">
                    <input type="hidden" id="inbound_current_shortcode" value="<?php echo $shortcode_id; ?>">
                    <table id="inbound-shortcodes-form-table">
                        <?php echo $shortcode->output; ?>
                        <tbody style="display:none;">
                        <tr class="form-row" style="text-align: center;">
                            <?php if (!$shortcode->has_child) : ?>
                                <td class="label">&nbsp;</td><?php endif; ?>
                            <td class="field" style="width:500px;"><a href="#" id="inbound_insert_shortcode"
                                                                      class="button-primary inbound-shortcodes-insert"><?php _e('Insert Shortcode', 'leads'); ?></a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>

            <div id="inbound-shortcodes-preview-wrap">
                <div id="inbound-shortcodes-preview-head">
                    <?php _e('Shortcode Preview', 'leads'); ?>
                </div>
                <?php if ($shortcode->no_preview) : ?>
                    <div id="inbound-shortcodes-nopreview"><?php _e('Shortcode has no preview', 'leads'); ?></div>
                <?php else : ?>


                    <div id="inbound-shortcodes-preview">


                    </div>

<!--                                        <iframe src="--><?php //echo INBOUND_FORMS; ?><!--preview.php?sc=" width="285" scrollbar='true'-->
<!--                            frameborder="0" id="inbound-shortcodes-preview"></iframe>-->

                <?php endif; ?>
            </div>
            <div class="clear"></div>
        </div>

    </div>
    <div id="popup-controls">
        <a href="#" id="inbound_save_form" style="display:none;" class="button-primary">Save Form & Insert</a>
        <a href="#" id="inbound_insert_shortcode_two"
           class="button-primary inbound-shortcodes-insert-two"><?php _e('Insert Shortcode', 'leads'); ?></a>
        <a href="#" id="shortcode_cancel" class="button inbound-shortcodes-insert-cancel">Cancel</a>

    </div>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {

            jQuery('.child-clone-row').first().attr('id', 'row-1');
            setTimeout(function () {
                jQuery('#inbound-shortcodes-form input:visible').first().focus();
            }, 500);

            //jQuery("body").on('click', '.child-clone-row', function () {
            // jQuery(".child-clone-row").toggle();
            // jQuery(this).show();
            //});
        });
    </script>
    </body>
    </html>


    <?php

    die();

}

function load_preview_ajax_request()
{



/*	Get Shortcodes
 *	--------------------------------------------------------------------------- */

$broekn = "divider_options=%22%3Ca%20href=%22http://glocal.dev/wp-admin/edit.php?post_type=inbound-forms%22%3ELeads%3C/a%3E%22";

$test = "http://glocal.dev/wp-content/plugins/leads/shared/shortcodes/preview.php?post=1544&sc=[inbound_form%20id=%221544%22%20name=%22New%20Icon%20Form%22%20redirect=%22http://fontawesome.io/%22%20notify=%22ccc%22%20layout=%22vertical%22%20font_size=%2216%22%20%20labels=%22top%22%20icon=%22check-circle-o%22%20submit=%22Submit%22%20width=%22%22]

[inbound_field%20label=%22First%20Name%22%20type=%22divider%22%20description=%22%22%20required=%220%22%20dropdown=%22%22%20radio=%22%22%20%20checkbox=%22%22%20placeholder=%22%22%20html=%22%22%20dynamic=%22%22%20map_to=%22%22%20

divider_options=%22%3Ca%20href=%22%22%3ETest%3C/a%3E%22]

[/inbound_form]";

$html_test = "divider_options=%22&lt;h3&gt;Hi&lt;/h3&gt;%22";
$html_test2 = "divider_options=%22<h3>Hi</h3>%22";
$extra_content = "";
$html_test = preg_replace("/%22/", "'", $html_test);
$test =  html_entity_decode( trim( $html_test2 ) );
//echo $test;
	$shortcode = html_entity_decode( trim( $_GET['sc'] ) );
	// SET CORRECT FILE PATHS FOR SCRIPTS
	if ( defined( 'WPL_URL' )) {
        $final_path = WPL_URL . "/";
    } else if (defined( 'LANDINGPAGES_URLPATH' )){
        $final_path = LANDINGPAGES_URLPATH;
    } else if (defined( 'WP_CTA_URLPATH' )){
        $final_path = WP_CTA_URLPATH;
    } else {
        $final_path = preg_replace("/\/shared\/shortcodes\//", "/", INBOUND_FORMS);
    }
/* HTML MATCHES */
// $test = 'html="&lt;span%20class="test"&gt;tes&lt;/span&gt;"';
// preg_match_all('%\[inbound_form_test\s*(?:(layout)\s*=\s*(.*?))?\](.*?)\[/inbound_form_test\]%', $shortcode, $matches);
// preg_match_all('/'.$varname.'\s*?=\s*?(.*)\s*?(;|$)/msU',$shortcode,$matches);


$horiz = "";
if (preg_match("/horizontal/i", $shortcode)) {
    $horiz = "<h2 title='Open preview in new tab' class='open_new_tab'>Horizontal Previews detected.<br>Click to Preview Horizontal shortcode in new tab</h2>";
}

	$shortcode = str_replace('\"', '"', $shortcode);
	$shortcode = str_replace('&lt;', '<', $shortcode);
	$shortcode = str_replace('&gt;', '>', $shortcode);
	$shortcode = str_replace('{{child}}', '', $shortcode);
	$shortcode = str_replace('label=""', 'label="Default"', $shortcode);
	//$field_name_fallback = ($field_name === "") ? 'fallback_name' : '0';

    $plugin_url= plugins_url();

//    echo  $plugin_url;
//    die();

    ?>

    <link rel="stylesheet" type="text/css" href="<?php echo $plugin_url?>/landing-pages/shared/shortcodes/css/frontend-render.css" media="all" />

    <?php // FIX THESE AND ROLL SHARE TRACKING INTO SHARED
    wp_enqueue_script( 'jquery' );

    wp_enqueue_script( 'funnel-tracking' , $plugin_url . '/landing-pages/shared/assets/frontend/js/analytics/inboundAnalytics.js');

    $inbound_localized_data = array('post_id' => 'test',
        'ip_address' => 'test',
        'wp_lead_data' => 'test',
        'admin_url' => 'test',
        'track_time' => 'test',
        'post_type' => 'test',
        'page_tracking' => 'test',
        'search_tracking' => 'test',
        'comment_tracking' => 'test',
        'custom_mapping' => 'test',
        'inbound_track_exclude' => 'test',
        'inbound_track_include' => 'test'
    );
    wp_localize_script( 'funnel-tracking' , 'inbound_settings', $inbound_localized_data);

    ?>
    <style type="text/css">

        .disclaimer {
            top: 0px;
            display: inline-block;
            margin-bottom: 20px;
            font-size: 11px;
            display: none;
        }
        .open_new_tab {
            color: #2465D8;
            margin-bottom: 15px;
            cursor: pointer;
            font-size: 12px;
            text-align: center;
            margin-top: 0px;
            display: none;
        }
        #close-preview-window {
            float: right;
            display: none;
        }
        <?php if (preg_match("/social_share/i", $shortcode)) {

        $extra_content = "<p>This is dummy text and not part of the shortcode. This is dummy text and not part of the shortcode. This is dummy text and not part of the shortcode. This is dummy text and not part of the shortcode. This is dummy text and not part of the shortcode. This is dummy text and not part of the shortcode. This is dummy text and not part of the shortcode. This is dummy text and not part of the shortcode. This is dummy text and not part of the shortcode.</p>";
        }?>
    </style>

<div id="close-preview-window"><a href="javascript:window.close()" class="close_window">close window</a></div>




<?php


echo do_shortcode( $shortcode ) . $extra_content; ?>

<?php // echo "<br>". $shortcode; ?>




<?php    die();

}


add_action('wp_ajax_load_popup_ajax_request', 'load_popup_ajax_request');

add_action('wp_ajax_load_preview_ajax_request', 'load_preview_ajax_request');
