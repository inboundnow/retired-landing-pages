<?php 

add_action('wp_enqueue_scripts','lp_fontend_enqueue_scripts');

function lp_fontend_enqueue_scripts($hook)
{
	global $post;
	
	if (!isset($post))
		return;
	
	$post_type = $post->post_type;
	$post_id = $post->ID;
	(isset($_SERVER['REMOTE_ADDR'])) ? $ip_address = $_SERVER['REMOTE_ADDR'] : $ip_address = '0.0.0.0.0';
	$current_page = "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
	
	wp_enqueue_script('jquery');
	
	// jquery cookie
	wp_dequeue_script('jquery-cookie');
	wp_enqueue_script('jquery-cookie', LANDINGPAGES_URLPATH . 'js/jquery.lp.cookie.js', array( 'jquery' ));
	
	// load local storage script
	wp_register_script('jquery-total-storage',LANDINGPAGES_URLPATH . 'js/jquery.total-storage.min.js', array( 'jquery' ));
	wp_enqueue_script('jquery-total-storage');
	
	// Load funnel tracking. Force Leads to load its version if active
	if ($post_type!=='wp-call-to-action') 
	{
		wp_register_script('funnel-tracking',LANDINGPAGES_URLPATH . 'js/funnel-tracking.js', array( 'jquery', 'jquery-cookie'));
		wp_enqueue_script('funnel-tracking');
		wp_localize_script( 'funnel-tracking' , 'wplft', array( 'post_id' => $post_id , 'ip_address' => $ip_address  ));
	}

	if (isset($post)&&$post->post_type=='landing-page') 
	{
	
		
		// Shared Core Inbound Scripts		
		if (@function_exists('wpleads_check_active')) 
		{ 
			wp_enqueue_script( 'store-lead-ajax', WPL_URL . '/shared/tracking/js/store.lead.ajax.js', array( 'jquery','jquery-cookie', 'funnel-tracking'));
		}
		else 
		{
			wp_enqueue_script( 'store-lead-ajax', LANDINGPAGES_URLPATH .'shared/tracking/js/store.lead.ajax.js', array( 'jquery','jquery-cookie'));
		}		
		wp_localize_script( 'store-lead-ajax' , 'inbound_ajax', array( 'admin_url' => admin_url( 'admin-ajax.php' ), 'post_id' => $post_id, 'post_type' => $post_type));

		$variation = (isset($_GET['lp-variation-id'])) ? $_GET['lp-variation-id'] : '0';
		wp_enqueue_script( 'landing-page-view-track' , LANDINGPAGES_URLPATH . 'js/page_view_track.js', array( 'jquery','jquery-cookie'));
		wp_localize_script( 'landing-page-view-track' , 'landing_path_info', array( 'variation' => $variation, 'admin_url' => admin_url( 'admin-ajax.php' )));

		$form_prepopulation = get_option( 'lp-main-landing-page-prepopulate-forms' , 1);
			
		// load form pre-population script
		if ($form_prepopulation)
		{
			wp_register_script('form-population',LANDINGPAGES_URLPATH . 'js/jquery.form-population.js', array( 'jquery', 'jquery-cookie'	));
			wp_enqueue_script('form-population');
		}
		
		
	

	if (isset($_GET['template-customize']) &&$_GET['template-customize']=='on') {
		// wp_register_script('lp-customizer-load-js', LANDINGPAGES_URLPATH . 'js/customizer.load.js', array('jquery'));
		// wp_enqueue_script('lp-customizer-load-js');
		echo "<style type='text/css'>#variation-list{background:#eaeaea !important; top: 26px !important; height: 35px !important;padding-top: 10px !important;}#wpadminbar {height: 29px !important;}</style>"; // enqueue styles not firing
	}
	if (isset($_GET['live-preview-area'])) {
		show_admin_bar( false );
		wp_register_script('lp-customizer-load-js', LANDINGPAGES_URLPATH . 'js/customizer.load.js', array('jquery'));
		wp_enqueue_script('lp-customizer-load-js');
		// wp_enqueue_style('lp-customizer-load-css', LANDINGPAGES_URLPATH . 'css/customizer-load.css'); doesn't work
		/* Almost working
			define("QUICK_CACHE_ALLOWED", false); 
			define("DONOTCACHEPAGE", true); 
			define('DONOTCACHCEOBJECT', true); 
			define('DONOTCDN', true); 

			// Function to wrap outputted meta in spans for front end editing
			add_filter( 'lp_get_value', 'lp_customizer_add_span_meta' , 10 , 4);
			function lp_customizer_add_span_meta( $content , $post = null , $key=null, $id=null) 
			{           
				$id = apply_filters('lp_customizer_span_id',$id);
				$exclude_list = "color|default|tile|repeat-x|repeat-y|left|right"; 
				// need to exclude these matches only if exact match with no other content
				// Need to exclude /images/img.jpg
				// Need to find single strings with only a url to a .png,.jpg, .gif file and exclude
				// Check for media upload type and ignore. Also ignore common setting words
				//echo $key.':'.$id.":".$content;
				//echo "<hr>";
				//echo "<br>";
				//<img alt="" src="/wp-content/uploads/landing-pages/templates/minimal-responsive/img/placeholder.jpg" /> matches the below preg match but we only want to match the string if its exactly /wp-content/uploads/landing-pages/templates/minimal-responsive/img/placeholder.jpg and nothing else 
				if (!@preg_match('/^(http|https|ftp)://([A-Z0-9][A-Z0-9_-]*(?:.[A-Z0-9][A-Z0-9_-]*)+):?(d+)?/?/i', $content)&&!strstr($content,'/wp-content/') && !@preg_match('/^[a-f0-9]{1,}$/is', $content) && $content != "color") {
					$content = "<span id='$key-$id' class='live-preview-area-box'>" . $content . "</span>";
				}

				return $content;
			}
			
			add_filter( 'lp_main_headline', 'lp_customizer_add_span_title' ,99);
			function lp_customizer_add_span_title( $content, $id ='title' ) 
			{

				$id = apply_filters('lp_customizer_span_id' , $id );
				$content = "<span id='lp-main-headline' class='live-preview-area-box' >" . $content . "</span>";
				
				return $content;
			}

			// Function to wrap outputted meta in spans for front end editing
			add_filter( 'the_content', 'lp_customizer_add_span_content' );
			function lp_customizer_add_span_content( $content , $id = 'content' ) 
			{

				$id = apply_filters('lp_customizer_span_id', $id );
				$content = "<span id='the-content' class='live-preview-area-box' >" . $content . "</span>"; 
				
				return $content;
			}

			// Function to wrap outputted meta in spans for front end editing
			add_filter( 'lp_conversion_area', 'lp_customizer_add_span_conversion_area' );
			function lp_customizer_add_span_conversion_area( $content , $id = 'lp-conversion-area' ) 
			{
				//echo "here";exit;
				$id = apply_filters('lp_customizer_span_id', $id );
				$content = "<span id='lp-conversion-area' class='live-preview-area-box' >" . $content . "</span>";
				
				return $content;
			} */
		} 
	}

}

add_action('wp_head', 'lp_header_load');
function lp_header_load(){
	global $post;
	if (isset($post)&&$post->post_type=='landing-page') 
	{
		wp_enqueue_style('inbound-wordpress-base-css', LANDINGPAGES_URLPATH . 'css/frontend/global-landing-page-style.css');
		if (isset($_GET['lp-variation-id']) && !isset($_GET['template-customize']) && !isset($_GET['iframe_window']) && !isset($_GET['live-preview-area'])) { ?>
		<script type="text/javascript">
		if (typeof window.history.pushState == 'function') {
		var current=window.location.href;var cleanparams=current.split("?");var clean_url=cleanparams[0];history.replaceState({},"landing page",clean_url);
		//console.log("push state supported.");
		}</script>
		<?php }
	}
}

function lp_discover_important_wrappers($content)
{
	$wrapper_class = "";
	if (strstr($content,'gform_wrapper'))
	{
		$wrapper_class = 'gform_wrapper';
	}
	return $wrapper_class;
}

function lp_rebuild_attributes($content=null, $wrapper_class=null, $standardize_form = 0)
{
	if (strstr($content,'<form'))
	{		
		if ($standardize_form)
		{
			$tag_whitelist = trim(get_option( 'lp-main-landing-page-auto-format-forms-retain-elements' , '<button><script><textarea><style><input><form><select><label><a><p><b><u><strong><i><img><strong><span><font><h1><h2><h3><center><blockquote><embed><object><small>'));
			$content = strip_tags($content, $tag_whitelist);
			
			if (!strstr($content,'<label')&&strstr($content,'<p'))
			{
				$content = str_replace('<p>','<label >',$content);
				$content = str_replace('</p>','</label>',$content); 
				//echo $content; exit;
			}
			
			if (!strstr($content,'<label')&&strstr($content,'<span'))
			{
				$content = str_replace('<span','<label',$content);
				$content = str_replace('</span>','</label>',$content); 
			}
			
			// Match Form tags
			$form = preg_match_all('/\<form(.*?)\>/s',$content, $matches);
			if (!empty($matches[0]))
			{
				foreach ($matches[0] as $key=> $value)
				{
					$new_value = $value;
					$form_name = preg_match('/ name *= *["\']?([^"\']*)/i',$value, $name); // 1 for true. 0 for false
					$form_id = stristr($value, ' id=');
					$form_class = stristr($value, ' class=');
					
					($form_name) ? $name = $name[1] : $name = $key;
					
					if ($form_class) 
					{
						$new_value = preg_replace('/ class=(["\'])(.*?)(["\'])/',' class="lp-form wpl-track-me $2"', $new_value); 
					} 
					else 
					{
						$new_value = str_replace('<form ','<form class="lp-form wpl-track-me" ', $new_value);
					}

					$content = str_replace($value,$new_value,$content);
				}
			}
			
			// Standardize all Labels
			$inputs = preg_match_all('/\<label(.*?)\>/s',$content, $matches);
			if (!empty($matches[0]))
			{
				foreach ($matches[0] as $value)
				{
					$new_value = $value;
					// regex to match text in label /(?<=[>])[^<>]+(?=[<])/g
					(preg_match('/ for *= *["\']?([^"\']*)/i',$value, $for)) ? 	$for = $for[1] : $for = 'input';
					$for = str_replace(' ','-',$for);
					
					$new_value = preg_replace('/ id=(["\'])(.*?)(["\'])/','', $new_value);

					$new_value = preg_replace('/ class=(["\'])(.*?)(["\'])/','', $new_value);
					
					$new_value = str_replace('<label ','<label id="lp-label-'.$for.'" ', $new_value);
					$new_value = str_replace('<label ','<label class="lp-input-label" ', $new_value);
					//$new_value = str_replace('<label>','<label class="lp-select-heading"> ', $new_value); // fix select headings

					
					//$new_value  = "<div id='lp_field_'
					$content = str_replace($value, $new_value, $content);
				}
			}	

			// Standardize all input fields
			$inputs = preg_match_all('/\<input(.*?)\>/s',$content, $matches);
			if (!empty($matches[0]))
			{
				foreach ($matches[0] as $value)
				{
					$new_value = $value;
					//get input name
					(preg_match( '/ name *= *["\']?([^"\']*)/i', $new_value, $name )) ? $name = $name[1] : $name =	"button";
					// get input type	
					(preg_match('/ type *= *["\']?([^"\']*)/i',$new_value, $type)) ? $type = $type[1] : $type = "text";

					// if class exists do this
					if (preg_match('/ class *= *["\']?([^"\']*)/i', $new_value, $class)) {
						$new_value = preg_replace('/ class=(["\'])(.*?)(["\'])/',' class="lp-input-'.$type.'"', $new_value);
					} 
					else 
					{
						$new_value = str_replace('<input ','<input class="lp-input-'.$type.'" ', $new_value);
					}
					
					// if id exists do this
					if (preg_match('/ id *= *["\']?([^"\']*)/i', $new_value, $class)) 
					{
						$new_value = preg_replace('/ id=(["\'])(.*?)(["\'])/',' id="lp-'.$type.'-'.$name.'"', $new_value);
					} 
					else 
					{
						$new_value = str_replace('<input ','<input id="lp-'.$type.'-'.$name.'" ', $new_value);
					}
				
					$content = str_replace($value,$new_value, $content);
				}
			}	
			
			// Standardize All Select Fields
			$selects = preg_match_all('/\<select(.*?)\>/s',$content, $matches);
			if (!empty($matches[0]))
			{
				foreach ($matches[0] as $value)
				{
					preg_match('/ name *= *["\']?([^"\']*)/i',$value, $name);			
					$name = $name[1];
					
					$new_value = preg_replace('/ id=(["\'])(.*?)(["\'])/',' id="lp-select-'.$name.'"', $value);
					$new_value = preg_replace('/ class=(["\'])(.*?)(["\'])/',' class="lp-input-select"', $new_value);
					$content = str_replace($value,$new_value, $content);
				}
			}	

			// Match Form text to common inputs
			$fields = preg_match_all("/\<label(.*?)\<input(.*?)\>/si",$content, $matches);
			if (!empty($matches[0]))
			{
				foreach ($matches[0] as $value)
				{		
					//echo $value;exit;
					//echo "<hr>";
					(preg_match( '/Email|e-mail|email/i', $value, $email_input)) ? $email_input = "lp-email-value" : $email_input =	"";

					// match name or first name. (minus: name=, last name, last_name,) 
					(preg_match( '/(?<!((last |last_)))name(?!\=)/im', $value, $first_name_input)) ? $first_name_input = "lp-first-name-value" : $first_name_input =	"";

					// Match Last Name
					(preg_match( '/(?<!((first)))(last name|last_name|last)(?!\=)/im', $value, $last_name_input)) ? $last_name_input = "lp-last-name-value" : $last_name_input =	"";
					
					$new_value  = "<div class='lp_form_field $email_input $first_name_input $last_name_input'>".$value."</div>";

					$content = str_replace($value,$new_value, $content);	
				}

			}

			// Fix All Span Tags
			$inputs = preg_match_all('/\<span(.*?)\>/s',$content, $matches);
			if (!empty($matches[0]))
			{
				foreach ($matches[0] as $value)
				{
					$new_value = preg_replace('/\<span(.*?)\>/s','<span class="lp-span">', $value);
					$content = str_replace($value,$new_value, $content);
				}
			}		

			// Fix All <p> Tags
			$inputs = preg_match_all('/\<p(.*?)\>/s',$content, $matches);
			if (!empty($matches[0]))
			{
				foreach ($matches[0] as $value)
				{
					$new_value = preg_replace('/\<p(.*?)\>/s','<p class="lp-paragraph">', $value);
					$content = str_replace($value,$new_value, $content);
				}
			}		
		
			//handle gform error messages
			if (strstr($content,'There was a problem with your submission. Errors have been highlighted below.'))
			{
				$content = preg_replace('/(There was a problem with your submission. Errors have been highlighted below.)/','<div class="validation_error">$1</div>', $content);
				$content = preg_replace('/(Please enter a valid email address.)/','<div class="gfield_description validation_message">$1</div>', $content);
				$content = preg_replace('/(This field is required.)/','<div class="gfield_description validation_message">$1</div>', $content);
			}
			
			$content = str_replace('name="submit"','name="s"',$content);
			$content = "<div id='lp_container_form'  class='$wrapper_class'>{$content}</div>";
		}
		else
		{
			
			$form = preg_match_all('/\<form(.*?)\>/s',$content, $matches);
			if (!empty($matches[0]))
			{
				foreach ($matches[0] as $key=>$value)
				{
					//echo "here";exit;
					$new_value = $value;
					$form_name = preg_match('/ name *= *["\']?([^"\']*)/i',$value, $name); // 1 for true. 0 for false
					$form_id = stristr($value, ' id='); 
					$form_class = stristr($value, ' class=');
					
					($form_name) ? $name = $name[1] : $name = $key;
						/* We are breaking the ids here need to only fix/add classes 
					if ($form_id) 
					{			
						$new_value = preg_replace('/ id=(["\'])(.*?)(["\'])/',' id="lp-form-'.$name.' $2"', $new_value);
					}
					else
					{
						$new_value = str_replace('<form ','<form id="lp-form-'.$name.'" ', $new_value);
					}
						*/
					if ($form_class) 
					{
						$new_value = preg_replace('/ class=(["\'])(.*?)(["\'])/',' class="lp-form wpl-track-me $2"', $new_value); 
					} 
					else 
					{
						$new_value = str_replace('<form ','<form class="lp-form wpl-track-me" ', $new_value);
					}
					
					$content = str_replace($value,$new_value,$content);

				}
			}

			$check_wrap = preg_match_all('/lp_container_form/s',$content, $check);
			if (empty($check[0]))
			{
				$content = str_replace('name="submit"','name="s"',$content);
				$content = "<div id='lp_container_form' >{$content}</div>";
			}
		}
		
		
	}
	else
	{
		
		// Standardize all links
		$inputs = preg_match_all('/\<a(.*?)\>/s',$content, $matches);
		if (!empty($matches[0]))
		{
			foreach ($matches[0] as $key => $value)
			{
				if ($key==0)
				{
					$new_value = $value;
					$new_value = preg_replace('/ class=(["\'])(.*?)(["\'])/','class="$2 lp-track-link"', $new_value);



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
	}

	return $content;
}



function lp_conversion_area($post = null, $content=null,$return=false, $doshortcode = true, $rebuild_attributes = true)
{
	if (!isset($post))
		global $post;
		
	$wrapper_class = ""; 

	$content = get_post_meta($post->ID, 'lp-conversion-area', true);
	
	$content = apply_filters('lp_conversion_area_pre_standardize',$content, $post, $doshortcode);

	$standardize_form = get_option( 'lp-main-landing-page-auto-format-forms' , 0); // conditional to check for options	

	$wrapper_class = lp_discover_important_wrappers($content);	
	
	
	
	if ($doshortcode)
	{
		$content = do_shortcode($content);
	}
	
	if ($rebuild_attributes)
	{
		$content = lp_rebuild_attributes($content, $wrapper_class, $standardize_form );	
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

function lp_content_area($post = null, $content=null,$return=false )
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

function lp_get_value($post, $key, $id)
{
	//echo 1; exit;
	if (isset($post))
	{
		$return = get_post_meta($post->ID, $key.'-'.$id , true);
		$return = apply_filters('lp_get_value',$return,$post,$key,$id);
		
		return $return; 
	}
	
	
}


function lp_check_active()
{	
	return 1;
}

if (!function_exists('lp_remote_connect')) {
function lp_remote_connect($url)
{
	$method1 = ini_get('allow_url_fopen') ? "Enabled" : "Disabled";
	if ($method1 == 'Disabled')
	{
		//do curl
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "$url");
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
		curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
		curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
		$string = curl_exec($ch);
	}
	else
	{
		$string = file_get_contents($url);
	}
	
	return $string;
}
}

//***********FUNCTION THAT WILL FIND POST ID FROM URL FOR CUSTOM POST TYPES******************/
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


/************** AB TESTING GLOBAL FUNCTIONS **********************/


function lp_ab_key_to_letter($key) {
    $alphabet = array( 'A', 'B', 'C', 'D', 'E',
                       'F', 'G', 'H', 'I', 'J',
                       'K', 'L', 'M', 'N', 'O',
                       'P', 'Q', 'R', 'S', 'T',
                       'U', 'V', 'W', 'X', 'Y',
                       'Z'
                       );
					   
	if (isset($alphabet[$key]))
		return $alphabet[$key];
}


function lp_ab_testing_get_current_variation_id()
{
	if (!isset($_GET['lp-variation-id'])&&isset($_SESSION['lp_ab_test_open_variation'])&&is_admin())
	{
		//$current_variation_id = $_SESSION['lp_ab_test_open_variation'];
	}
		
	if (!isset($_SESSION['lp_ab_test_open_variation'])&&!isset($_GET['lp-variation-id'])) 
	{
		$current_variation_id = 0;
	}
	//echo $_GET['lp-variation-id'];
	if (isset($_GET['lp-variation-id'])) 
	{
		$_SESSION['lp_ab_test_open_variation'] = $_GET['lp-variation-id'];
		$current_variation_id = $_GET['lp-variation-id'];
		//echo "setting session $current_variation_id";
	}

	if (isset($_GET['message'])&&$_GET['message']==1&&isset( $_SESSION['lp_ab_test_open_variation'] ))
	{					
		$current_variation_id = $_SESSION['lp_ab_test_open_variation'];
		
		//echo "here:".$_SESSION['lp_ab_test_open_variation'];
	}
	
	if (isset($_GET['ab-action'])&&$_GET['ab-action']=='delete-variation')
	{					
		$current_variation_id = 0;
		$_SESSION['lp_ab_test_open_variation'] = 0;
	}

	if (!isset($current_variation_id))
		$current_variation_id = 0 ;
		
	return $current_variation_id;
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

?>