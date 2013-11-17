<?php

/* LOAD COMMON FUNCTIONS FOR LANDING PAGES TEMPLATES */
add_action('lp_init', 'inbound_include_template_functions');
if (!function_exists('inbound_include_template_functions')) {
	function inbound_include_template_functions(){
		include_once('shared/functions.templates.php');
	}
}

/* LOAD TEMPLATE */
add_filter('single_template', 'lp_custom_template');
function lp_custom_template($single) {
    global $wp_query, $post, $query_string;
	//echo 2;exit;
	if ($post->post_type == "landing-page")
	{
		$template = get_post_meta($post->ID, 'lp-selected-template', true);
		$template = apply_filters('lp_selected_template',$template);


		if (isset($template))
		{

			if (strstr($template,'-slash-'))
			{
				$template = str_replace('-slash-','/',$template);
			}

			$my_theme =  wp_get_theme($template);

			if ($my_theme->exists())
			{
				return "";
			}
			else if ($template!='default')
			{
				$template = str_replace('_','-',$template);
				//echo LANDINGPAGES_URLPATH.'templates/'.$template.'/index.php'; exit;
				if (file_exists(LANDINGPAGES_PATH.'templates/'.$template.'/index.php'))
				{
					//query_posts ($query_string . '&showposts=1');
					return LANDINGPAGES_PATH.'templates/'.$template.'/index.php';
				}
				else
				{
					//query_posts ($query_string . '&showposts=1');
					return LANDINGPAGES_UPLOADS_PATH.$template.'/index.php';
				}
			}
		}
	}

    return $single;
}


/* LOAD & PRINT CUSTOM JS AND CSS */
add_action('wp_head','landing_pages_insert_custom_head');
function landing_pages_insert_custom_head() 
{
	global $post;

   if (isset($post)&&'landing-page'==$post->post_type)
   {

		$custom_css_name = apply_filters('lp_custom_css_name','lp-custom-css');
		$custom_js_name = apply_filters('lp_custom_js_name','lp-custom-js');
		$custom_css = get_post_meta($post->ID, $custom_css_name, true);
		$custom_js = get_post_meta($post->ID, $custom_js_name, true);

		//Print Custom CSS
		if (!stristr($custom_css,'<style'))
		{
			echo '<style type="text/css" id="lp_css_custom">'.$custom_css.'</style>';
		}
		else
		{
			echo $custom_css;
		}
		//Print Custom JS
		if (!stristr($custom_js,'<script'))
		{
			echo '<script type="text/javascript" id="lp_js_custom">jQuery(document).ready(function($) {
			'.$custom_js.' });</script>';
		}
		else
		{
			echo $custom_js;
		}
   }
}

/* FOR DEFAULT TEMPLATE & NATIVE THEME TEMPLATES PREPARE THE CONVERSION AREA */
add_filter('the_content','landing_pages_add_conversion_area', 20);
add_filter('get_the_content','landing_pages_add_conversion_area', 20);
function landing_pages_add_conversion_area($content)
{

	if ('landing-page'==get_post_type() && !is_admin())
	{

		global $post;

		remove_action('the_content', 'landing_pages_add_conversion_area');

		$key = get_post_meta($post->ID, 'lp-selected-template', true);
		$key = apply_filters('lp_selected_template',$key);

		if (strstr($key,'-slash-'))
		{
			$key = str_replace('-slash-','/',$key);
		}

		$my_theme =  wp_get_theme($key);
		//echo $key;
		if ($my_theme->exists()||$key=='default')
		{

			global $post;
		    $wrapper_class = "";

			get_post_meta($post->ID, "default-conversion-area-placement", true);


			$position = get_post_meta($post->ID, "{$key}-conversion-area-placement", true);

			$position = apply_filters('lp_conversion_area_position', $position, $post, $key);

			$_SESSION['lp_conversion_area_position'] = $position;

			$conversion_area = lp_conversion_area(null,null,true,true);


			$standardize_form = get_option( 'lp-main-landing-page-auto-format-forms' , 0); // conditional to check for options
			if ($standardize_form)
			{
				$wrapper_class = lp_discover_important_wrappers($conversion_area);
				$conversion_area = lp_rebuild_attributes($conversion_area);
			}

			$conversion_area = "<div id='lp_container' class='$wrapper_class'>".$conversion_area."</div>";

			if ($position=='top')
			{
				$content = $conversion_area.$content;
			}
			else if ($position=='bottom')
			{
				$content = $content.$conversion_area;
			}
			else if ($position=='widget')
			{
				$content = $content;
			}
			else
			{
				$conversion_area = str_replace("id='lp_container'","id='lp_container' class='lp_form_$position' style='float:$position'",$conversion_area);
				$content = $conversion_area.$content;

			}

		}

	}

	return $content;
}

/* LEGACY CODE FOR ADDING LANDING PAGE TEMPLATE METABOX SETTINGS TO TEMPLATE METABOX */
function lp_add_option($key,$type,$id,$default=null,$label=null,$description=null, $options=null)
{
	switch ($type)
	{
		case "colorpicker":
			return array(
			'label' => $label,
			'description'  => $description,
			'id'    => $id,
			'type'  => 'colorpicker',
			'default'  => $default
			);
			break;
		case "text":
			return array(
			'label' => $label,
			'description'  => $description,
			'id'    => $id,
			'type'  => 'text',
			'default'  => $default
			);
			break;
		case "license-key":
			return array(
			'label' => $label,
			'description'  => $description,
			'id'    => $id,
			'type'  => 'license-key',
			'default'  => $default,
			'slug' => $id
			);
			break;
		case "textarea":
			return array(
			'label' => $label,
			'description'  => $description,
			'id'    => $id,
			'type'  => 'textarea',
			'default'  => $default
			);
			break;
		case "wysiwyg":
			return array(
			'label' => $label,
			'description'  => $description,
			'id'    => $id,
			'type'  => 'wysiwyg',
			'default'  => $default
			);
			break;
		case "media":
			return array(
			'label' => $label,
			'description'  => $description,
			'id'    => $id,
			'type'  => 'media',
			'default'  => $default
			);
			break;
		case "checkbox":
			return array(
			'label' => $label,
			'description'  => $description,
			'id'    => $id,
			'type'  => 'checkbox',
			'default'  => $default,
			'options' => $options
			);
			break;
		case "radio":
			return array(
			'label' => $label,
			'description'  => $description,
			'id'    =>$id,
			'type'  => 'radio',
			'default'  => $default,
			'options' => $options
			);
			break;
		case "dropdown":
			return array(
			'label' => $label,
			'description'  => $description,
			'id'    => $id,
			'type'  => 'dropdown',
			'default'  => $default,
			'options' => $options
			);
			break;
		case "datepicker":
			return array(
			'label' => $label,
			'description'  => $description,
			'id'    => $id,
			'type'  => 'datepicker',
			'default'  => $default
			);
			break;
		case "default-content":
			return array(
			'label' => $label,
			'description'  => $description,
			'id'    => $id,
			'type'  => 'default-content',
			'default'  => $default
			);
			break;	
		case "html":
			return array(
			'label' => $label,
			'description'  => $description,
			'id'    => $id,
			'type'  => 'html',
			'default'  => $default
			);
			break;	
	}
}

/* legacy function not used anymore but called in old non-core templates */
function lp_list_feature()
{
	return null;
}


