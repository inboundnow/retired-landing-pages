<?php


add_filter('admin_url','lp_add_fullscreen_param');
function lp_add_fullscreen_param( $link ) 
{
	if (isset($_GET['page']))
		return $link;

	if (  ( isset($post) && 'landing-page' == $post->post_type ) || ( isset($_REQUEST['post_type']) && $_REQUEST['post_type']=='landing-page' ) ) 
	{ 
		$params['frontend'] = 'false';
		if(isset($_GET['frontend']) && $_GET['frontend'] == 'true') {
	        $params['frontend'] = 'true';
	    }
	    if(isset($_REQUEST['frontend']) && $_REQUEST['frontend'] == 'true') {
	        $params['frontend'] = 'true';
	    }
	    $link = add_query_arg( $params, $link );

	} 
	
	return $link;
}


function lp_list_feature($label,$url=null)
{	
	return	array(
		"label" => $label,
		"url" => $url
		);	
}


add_action('wp_trash_post', 'lp_trash_lander');
function lp_trash_lander($post_id) {
	global $post;

	if (!isset($post)||isset($_POST['split_test']))
		return;
	
	if ($post->post_type=='revision')
	{
		return;
	}
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ||(isset($_POST['post_type'])&&$_POST['post_type']=='revision'))
	{
		return;
	}
		
	if ($post->post_type=='landing-page')
	{

		$lp_id = $post->ID;

		$args=array(
		  'post_type' => 'landing-page-group',
		  'post_satus'=>'publish'
		);
		
		$my_query = null;
		$my_query = new WP_Query($args);
		
		if( $my_query->have_posts() ) 
		{
			$i=1;				
			while ($my_query->have_posts()) : $my_query->the_post(); 
				$group_id = get_the_ID();
				$group_data = get_the_content();
				$group_data = json_decode($group_data,true);
				
				$lp_ids = array();
				foreach ($group_data as $key=>$value)
				{
					$lp_ids[] = $key;
				}

				if (in_array($lp_id,$lp_ids))
				{
					unset($group_data[$lp_id]);

					$this_data = json_encode($group_data);
					//print_r($this_data);
					$new_post = array(
						'ID' => $group_id,
						'post_title' => get_the_title(),
						'post_content' => $this_data,
						'post_status' => 'publish',
						'post_date' => date('Y-m-d H:i:s'),
						'post_author' => 1,
						'post_type' => 'landing-page-group'
					);	
					//print_r($new_post);
					$post_id = wp_update_post($new_post);
				}
			endwhile;
		}
	}
}

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




//generates drop down select of landing pages
function lp_generate_drowndown($select_id, $post_type, $selected = 0, $width = 400, $height = 230,$font_size = 13,$multiple=true) 
{
	$post_type_object = get_post_type_object($post_type);
	$label = $post_type_object->label;
	
	if ($multiple==true)
	{
		$multiple = "multiple='multiple'";
	}
	else
	{
		$multiple = "";
	}
	
	$posts = get_posts(array('post_type'=> $post_type, 'post_status'=> 'publish', 'suppress_filters' => false, 'posts_per_page'=>-1));
	echo '<select name="'. $select_id .'" id="'.$select_id.'" class="lp-multiple-select" style="width:'.$width.'px;height:'.$height.'px;font-size:'.$font_size.'px;"  '.$multiple.'>';
	foreach ($posts as $post) {
		echo '<option value="', $post->ID, '"', $selected == $post->ID ? ' selected="selected"' : '', '>', $post->post_title, '</option>';
	}
	echo '</select>';
}


function lp_wp_editor( $content, $id, $settings = array() )
{
	//echo $id;
	$content = apply_filters('lp_wp_editor_content',$content);
	$id = apply_filters('lp_wp_editor_id',$id);
	$settings = apply_filters('lp_wp_editor_settings',$settings);

	
	wp_editor( $content, $id, $settings);
}


function lp_display_headline_input($id,$main_headline)
{
	//echo $id;
	$id = apply_filters('lp_display_headline_input_id',$id);

	echo "<input type='text' name='{$id}' id='{$id}' value='{$main_headline}' size='30'>";
}
function lp_display_notes_input($id,$variation_notes)
{
	//echo $id;
	$id = apply_filters('lp_display_notes_input_id',$id);

	echo "<span id='add-lp-notes'>Notes:</span><input placeholder='Add Notes to your variation. Example: This version is testing a green submit button' type='text' class='lp-notes' name='{$id}' id='{$id}' value='{$variation_notes}' size='30'>";
}

function lp_ready_screenshot_url($link,$datetime)
{
	return $link.'?dt='.$datetime;
}


function lp_display_success($message)
{
	echo "<br><br><center>";
	echo "<font color='green'><i>".$message."</i></font>";
	echo "</center>";
}


function lp_make_percent($rate, $return = false)
{
	//yes, we know this is not a true filter
	if (is_numeric($rate))
	{
		$percent = $rate * (100);
		$percent = number_format($percent,1);	
		if($return){ return $percent."%"; } else { echo $percent."%"; }
	}
	else
	{
		if($return){ return $rate; } else { echo $rate; }
	}
}


function landing_page_get_version() {
	if ( ! function_exists( 'get_plugins' ) )
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	$plugin_folder = get_plugins( '/' . plugin_basename( dirname( __FILE__ ) ) );
	$plugin_file = basename( ( __FILE__ ) );
	return $plugin_folder[$plugin_file]['Version'];
}

function lp_wpseo_priority(){return 'low';}
add_filter( 'wpseo_metabox_prio', 'lp_wpseo_priority'); 
add_action( 'in_admin_header', 'lp_in_admin_header');
function lp_in_admin_header() 
{
	global $post; 
	global $wp_meta_boxes;
	
	if (isset($post)&&$post->post_type=='landing-page') 
	{
		unset( $wp_meta_boxes[get_current_screen()->id]['normal']['core']['postcustom'] ); 
	}
}


/* AB TESTING FUNCTIONS */

/**
 * [lp_ab_unset_variation description]
 * @param  [type] $variations [description]
 * @param  [type] $vid        [description]
 * @return [type]             [description]
 */
function lp_ab_unset_variation($variations,$vid)
{
	if(($key = array_search($vid, $variations)) !== false) {
		unset($variations[$key]);
	}
	
	return $variations;
}

/**
 * [lp_ab_get_lp_active_status returns if landing page is in rotation or not]
 * @param  [type] $post [description]
 * @param  [type] $vid  [description]
 * @return [type]       1 or 0
 */
function lp_ab_get_lp_active_status($post,$vid=null)
{
	if ($vid==0)
	{
		$variation_status = get_post_meta( $post->ID , 'lp_ab_variation_status' , true);
	}
	else
	{
		$variation_status = get_post_meta( $post->ID , 'lp_ab_variation_status-'.$vid , true);
	}
	
	if (!is_numeric($variation_status))
	{
		return 1;
	}
	else
	{	
		return $variation_status;
	}
}

?>