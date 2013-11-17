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

/* CALLBACK FOR USING A LANDING PAGE'S URL TO DETERMINE IT'S POST ID */
function lp_url_to_postid($url)
{
	global $wpdb;

	if (strstr($url,'?landing-page='))
	{
		$url = explode('?landing-page=',$url);
		$url = $url[1];
		$url = explode('&',$url);
		$post_id = $url[0];
		
		return $post_id;
	}	
	
	//first check if URL is homepage
	$wordpress_url = get_bloginfo('url');
	if (substr($wordpress_url, -1, -1)!='/')
	{
		$wordpress_url = $wordpress_url."/";
	}

	if (str_replace('/','',$url)==str_replace('/','',$wordpress_url))
	{
		return get_option('page_on_front');
	}
	
	$parsed = parse_url($url);
	$url = $parsed['path'];
	
	$parts = explode('/',$url);
	
	$count = count($parts);
	$count = $count -1; 

	if (empty($parts[$count]))
	{
		$i = $count-1;
		$slug = $parts[$i];
	}
	else
	{
		$slug = $parts[$count];
	}
	
	$my_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '$slug' AND post_type='landing-page'");
	
	if ($my_id)
	{
		return $my_id;
	}
	else
	{
		return 0;
	}
}

/* CALLBACK FOR GETTING LANDING PAGE'S DIRECTORY PATH */
function lp_get_parent_directory($path)
{
	if(stristr($_SERVER['SERVER_SOFTWARE'], 'Win32')){
		$array = explode('\\',$path);
		$count = count($array);
		$key = $count -1;
		$parent = $array[$key];
		return $parent;
    } else if(stristr($_SERVER['SERVER_SOFTWARE'], 'IIS')){
        $array = explode('\\',$path);
		$count = count($array);
		$key = $count -1;
		$parent = $array[$key];
		return $parent;
    }else {
		$array = explode('/',$path);
		$count = count($array);
		$key = $count -1;
		$parent = $array[$key];
		return $parent;
	}
}


/* CALLBACK FOR PRITNING LANDING PAGES BODY CLASS */
function lp_body_class()
{
	global $post;
	global $lp_data;
	// Need to add in lp_right or lp_left classes based on the meta to float forms
	// like $conversion_layout = lp_get_value($post, $key, 'conversion-area-placement');
	if (get_post_meta($post->ID, 'lp-selected-template', true)) 
	{
		$lp_body_class = "template-" . get_post_meta($post->ID, 'lp-selected-template', true);
		 $postid = "page-id-" . get_the_ID();
		echo 'class="';
		echo $lp_body_class . " " . $postid . " wordpress-landing-page";
		echo '"';
	}
	return $lp_body_class;
}


/* CALLBACK FOR RENDING A LANDING PAGE'S MAIN CONTENT */
function lp_content_area( $post = null , $content=null , $return=false )
{
	if (!isset($post))
		global $post;
		
	if (!$content)
	{
		global $post;
		
		if (!isset($post)&&isset($_REQUEST['post']))
		{
			
			$post = get_post($_REQUEST['post']);
		}
	
		else if (!isset($post)&&isset($_REQUEST['lp_id']))
		{	
			$post = get_post($_REQUEST['lp_id']);
		}
		
		//var_dump($post);
		$content_area = $post->post_content;	
		
		if (!is_admin())
			$content_area = apply_filters('the_content', $content_area);
			
		$content_area = apply_filters('lp_content_area',$content_area, $post);

		if(!$return)
		{
			echo $content_area;
			
		}
		else
		{
			return $content_area;	
		}
	}
	else
	{
		if(!$return)
		{
			echo $content_area;	
		}
		else
		{
			return $content_area;	
		}
	}	
}


/* CALLBACK FOR RENDERING A LANDING PAGE'S MAIN HEADLINE */
function lp_main_headline($post = null, $headline=null,$return=false)
{
	if (!isset($post))
		global $post;

	if (!$headline)
	{
		$main_headline =  lp_get_value($post, 'lp', 'main-headline');	
		$main_headline = apply_filters('lp_main_headline',$main_headline, $post);
		
		if(!$return)
		{
			echo $main_headline;
			
		}
		else
		{
			return $main_headline;	
		}
	}
	else
	{
		$main_headline = apply_filters('lp_main_headline',$main_headline, $post);
		if(!$return)
		{
			echo $headline;	
		}
		else
		{
			return $headline;	
		}
	}	
}

/* SHORTCODE FOR RENDERING LP CONVERSION AREA */
add_shortcode( 'lp_conversion_area', 'lp_conversion_area_shortcode');
function lp_conversion_area_shortcode( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'id' => '',
		'align' => ''
		//'style' => ''
	), $atts));
	
	$conversion_area = "";
	$conversion_area .= lp_conversion_area($post = null, $content=null,$return=true, $doshortcode = true, $rebuild_attributes = true);

	return $conversion_area;
}


/* DISPLAY CONVERSION AREA CONTENT */
function lp_conversion_area($post = null, $content=null,$return=false, $doshortcode = true, $rebuild_attributes = true)
{
	if (!isset($post))
		global $post;
		
	$wrapper_class = ""; 

	$content = get_post_meta($post->ID, 'lp-conversion-area', true);
	
	$content = apply_filters('lp_conversion_area_pre_standardize',$content, $post, $doshortcode);


	$wrapper_class = lp_discover_important_wrappers($content);	
	
	
	
	if ($doshortcode)
	{
		$content = do_shortcode($content);
	}
	
	if ($rebuild_attributes)
	{
		$content = lp_rebuild_attributes($content, $wrapper_class );	
	}
	

	$content = apply_filters('lp_conversion_area_post',$content, $post);

	if(!$return)
	{
		
		echo do_shortcode($content);
	}
	else
	{
		return $content;
	}
	
}

/* ADD IN SUPPORT FOR GRAVITY FORM CLASSES */
function lp_discover_important_wrappers($content)
{
	$wrapper_class = "";
	if (strstr($content,'gform_wrapper'))
	{
		$wrapper_class = 'gform_wrapper';
	}
	return $wrapper_class;
}

/* AUTODETECT LINK BASED CONVERSION AREAS AND ADD IN SUPPORT FOR LINK TRACKING */
function lp_rebuild_attributes( $content=null, $wrapper_class=null )
{
	if (strstr($content,'<form'))
		return $content;
		
	// Standardize all links
	$inputs = preg_match_all('/\<a(.*?)\>/s',$content, $matches);
	if (!empty($matches[0]))
	{
		foreach ($matches[0] as $key => $value)
		{
			if ($key==0)
			{
				$new_value = $value;
				$new_value = preg_replace('/ class=(["\'])(.*?)(["\'])/','class="$2 wpl-track-me-link"', $new_value);



				$content = str_replace($value, $new_value, $content);
				break;
			}
		}
	}
	
	$check_wrap = preg_match_all('/lp_container_noform/s',$content, $check);
	if (empty($check[0]))
	{
		$content = "<div id='lp_container_noform'  class='$wrapper_class link-click-tracking'>{$content}</div>";
	}

	return $content;
}

/* CALLBACK FOR GETTING A SPECIFIC LANDING PAGE META VALUE */
function lp_get_value($post, $key, $id)
{
	if (isset($post))
	{
		$return = get_post_meta($post->ID, $key.'-'.$id , true);
		$return = apply_filters('lp_get_value',$return,$post,$key,$id);
		
		return $return; 
	}
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

/* LEGACY FUNCTIONS USED BY OLDER TEMPLATES*/
function lp_list_feature()
{
	return null;
}

function lp_global_config()
{
	do_action('lp_global_config');
}

function lp_init()
{
	do_action('lp_init');
}

function lp_head()
{
	do_action('lp_head');
}

function lp_footer()
{
	do_action('lp_footer');
}




