<?php

add_action('admin_enqueue_scripts','lp_admin_enqueue');

function lp_admin_enqueue($hook)
{
	global $post;
	$screen = get_current_screen(); //print_r($screen);
	
	//enqueue styles and scripts
	wp_enqueue_style('lp-admin-css', LANDINGPAGES_URLPATH . 'css/admin-style.css');
	
	//jquery cookie
	wp_dequeue_script('jquery-cookie');
	wp_enqueue_script('jquery-cookie', LANDINGPAGES_URLPATH . 'js/jquery.lp.cookie.js');
	
	// Frontend Editor
	if ((isset($_GET['page']) == 'lp-frontend-editor')) {
	// scripts soon	
	}
	
	// Store Options Page
	if (isset($_GET['page']) && (($_GET['page'] == 'lp_store') || ($_GET['page'] == 'lp_addons'))) 
	{
		wp_dequeue_script('easyXDM');
		wp_enqueue_script('easyXDM', LANDINGPAGES_URLPATH . 'js/libraries/easyXDM.debug.js');
		//wp_enqueue_script('lp-js-store', LANDINGPAGES_URLPATH . 'js/admin/admin.store.js');
	} 

	// Admin enqueue - Landing Page CPT only 
	if (  ( isset($post) && 'landing-page' == $post->post_type ) || ( isset($_GET['post_type']) && $_GET['post_type']=='landing-page' ) ) 
	{ 
		
		wp_enqueue_script('jpicker', LANDINGPAGES_URLPATH . 'js/libraries/jpicker/jpicker-1.1.6.min.js');
		wp_localize_script( 'jpicker', 'jpicker', array( 'thispath' => LANDINGPAGES_URLPATH.'js/libraries/jpicker/images/' ));
		wp_enqueue_style('jpicker-css', LANDINGPAGES_URLPATH . 'js/libraries/jpicker/css/jPicker-1.1.6.min.css');
		wp_dequeue_script('jquery-qtip');
		wp_enqueue_script('jquery-qtip', LANDINGPAGES_URLPATH . 'js/libraries/jquery-qtip/jquery.qtip.min.js');
		wp_enqueue_script('load-qtip', LANDINGPAGES_URLPATH . 'js/libraries/jquery-qtip/load.qtip.js', array('jquery-qtip'));
		wp_enqueue_style('qtip-css', LANDINGPAGES_URLPATH . 'css/jquery.qtip.min.css'); //Tool tip css
		wp_enqueue_style('lp-only-cpt-admin-css', LANDINGPAGES_URLPATH . 'css/admin-lp-cpt-only-style.css');
		
		// Add New and Edit Screens
		if ( $hook == 'post-new.php' || $hook == 'post.php' ) 
		{
			add_filter( 'wp_default_editor', 'lp_ab_testing_force_default_editor' ); // force html view
			//admin.metaboxes.js - Template Selector - Media Uploader
			wp_enqueue_script('lp-js-metaboxes', LANDINGPAGES_URLPATH . 'js/admin/admin.metaboxes.js');
			 
			$template_data = lp_get_extension_data();
			$template_data = json_encode($template_data);
			$template = get_post_meta($post->ID, 'lp-selected-template', true);	
			$template = apply_filters('lp_selected_template',$template); 
			$template = strtolower($template);	
			$params = array('selected_template'=>$template, 'templates'=>$template_data);
			wp_localize_script('lp-js-metaboxes', 'data', $params);
			
			// Isotope sorting
			wp_enqueue_script('isotope', LANDINGPAGES_URLPATH . 'js/libraries/isotope/jquery.isotope.js', array('jquery'), '1.0', true );
			wp_enqueue_style('isotope', LANDINGPAGES_URLPATH . 'js/libraries/isotope/css/style.css');

			// Conditional TINYMCE for landing pages
			wp_dequeue_script('jquery-tinymce');
			wp_enqueue_script('jquery-tinymce', LANDINGPAGES_URLPATH . 'js/libraries/tiny_mce/jquery.tinymce.js');

		}
		// Edit Screen
		if ( $hook == 'post.php' ) 
		{
			wp_enqueue_script('lp-post-edit-ui', LANDINGPAGES_URLPATH . 'js/admin/admin.post-edit.js');
			wp_localize_script( 'lp-post-edit-ui', 'lp_post_edit_ui', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'post_id' => $post->ID , 'wp_landing_page_meta_nonce' => wp_create_nonce('wp-landing-page-meta-nonce'),  'lp_template_nonce' => wp_create_nonce('lp-nonce') ) );
			wp_enqueue_style('admin-post-edit-css', LANDINGPAGES_URLPATH . '/css/admin-post-edit.css');
			/* Error with picker_functions.js for datepicker need new solution
			wp_enqueue_script('jqueryui');
			// jquery datepicker
			wp_enqueue_script('jquery-datepicker', LANDINGPAGES_URLPATH . 'js/libraries/jquery-datepicker/jquery.timepicker.min.js');
			
			wp_enqueue_script('jquery-datepicker-base', LANDINGPAGES_URLPATH . 'js/libraries/jquery-datepicker/lib/base.js');
			wp_enqueue_script('jquery-datepicker-datepair', LANDINGPAGES_URLPATH . 'js/libraries/jquery-datepicker/lib/datepair.js');
			wp_localize_script( 'jquery-datepicker', 'jquery_datepicker', array( 'thispath' => LANDINGPAGES_URLPATH.'js/libraries/jquery-datepicker/' ));
			wp_enqueue_script('jquery-datepicker-functions', LANDINGPAGES_URLPATH . 'js/libraries/jquery-datepicker/picker_functions.js');
			wp_enqueue_style('jquery-timepicker-css', LANDINGPAGES_URLPATH . 'js/libraries/jquery-datepicker/jquery.timepicker.css');
			wp_enqueue_style('jquery-datepicker-base.css', LANDINGPAGES_URLPATH . 'js/libraries/jquery-datepicker/lib/base.css');	
			*/
		}

		// Add New Screen
		if ( $hook == 'post-new.php'  ) 
		{  
			// Create New Landing Jquery UI
			wp_enqueue_script('lp-js-create-new-lander', LANDINGPAGES_URLPATH . 'js/admin/admin.post-new.js', array('jquery'), '1.0', true );
			wp_localize_script( 'lp-js-create-new-lander', 'lp_post_new_ui', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'post_id' => $post->ID , 'wp_landing_page_meta_nonce' => wp_create_nonce('lp_nonce') ) );
			wp_enqueue_style('lp-css-post-new', LANDINGPAGES_URLPATH . 'css/admin-post-new.css');
		}
		
		// List Screen
		if ( $screen->id == 'edit-landing-page' ) 
		{
			wp_enqueue_script(array('jquery', 'editor', 'thickbox', 'media-upload'));
			wp_enqueue_script('landing-page-list', LANDINGPAGES_URLPATH . 'js/admin/admin.landing-page-list.js');
			wp_enqueue_style('landing-page-list-css', LANDINGPAGES_URLPATH.'css/admin-landing-page-list.css');
			wp_enqueue_script('jqueryui');
			wp_admin_css('thickbox');
			add_thickbox(); 
		}

	}
}

function lp_list_feature($label,$url=null)
{	
	return	array(
		"label" => $label,
		"url" => $url
		);	
}

// The Callback
function lp_show_metabox($post,$key) 
{
	$extension_data = lp_get_extension_data();
	$key = $key['args']['key'];

	$lp_custom_fields = $extension_data[$key]['options'];
	$lp_custom_fields = apply_filters('lp_show_metabox',$lp_custom_fields, $key);
	
	lp_render_metabox($key,$lp_custom_fields,$post);
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
					//echo 1; exit;
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
			'desc'  => $description,
			'id'    => $key.'-'.$id,
			'type'  => 'colorpicker',
			'default'  => $default
			);
			break;
		case "text":
			return array(
			'label' => $label,
			'desc'  => $description,
			'id'    => $key.'-'.$id,
			'type'  => 'text',
			'default'  => $default
			);
			break;
		case "license-key":
			return array(
			'label' => $label,
			'desc'  => $description,
			'id'    => $key.'-'.$id,
			'type'  => 'license-key',
			'default'  => $default,
			'slug' => $id
			);
			break;
		case "textarea":
			return array(
			'label' => $label,
			'desc'  => $description,
			'id'    => $key.'-'.$id,
			'type'  => 'textarea',
			'default'  => $default
			);
			break;
		case "wysiwyg":
			return array(
			'label' => $label,
			'desc'  => $description,
			'id'    => $key.'-'.$id,
			'type'  => 'wysiwyg',
			'default'  => $default
			);
			break;
		case "media":
			return array(
			'label' => $label,
			'desc'  => $description,
			'id'    => $key.'-'.$id,
			'type'  => 'media',
			'default'  => $default
			);
			break;
		case "checkbox":
			return array(
			'label' => $label,
			'desc'  => $description,
			'id'    => $key.'-'.$id,
			'type'  => 'checkbox',
			'default'  => $default,
			'options' => $options
			);
			break;
		case "radio":
			return array(
			'label' => $label,
			'desc'  => $description,
			'id'    => $key.'-'.$id,
			'type'  => 'radio',
			'default'  => $default,
			'options' => $options
			);
			break;
		case "dropdown":
			return array(
			'label' => $label,
			'desc'  => $description,
			'id'    => $key.'-'.$id,
			'type'  => 'dropdown',
			'default'  => $default,
			'options' => $options
			);
			break;
		case "datepicker":
			return array(
			'label' => $label,
			'desc'  => $description,
			'id'    => $key.'-'.$id,
			'type'  => 'datepicker',
			'default'  => $default
			);
			break;
		case "default-content":
			return array(
			'label' => $label,
			'desc'  => $description,
			'id'    => $key.'-'.$id,
			'type'  => 'default-content',
			'default'  => $default
			);
			break;	
		case "html":
			return array(
			'label' => $label,
			'desc'  => $description,
			'id'    => $key.'-'.$id,
			'type'  => 'html',
			'default'  => $default
			);
			break;	
	}
}

function lp_render_metabox($key,$custom_fields,$post)
{
	// Use nonce for verification
	echo "<input type='hidden' name='lp_{$key}_custom_fields_nonce' value='".wp_create_nonce('lp-nonce')."' />";

	// Begin the field table and loop
	echo '<table class="form-table" >';
	//print_r($custom_fields);exit;
	foreach ($custom_fields as $field) {
		$raw_option_id = str_replace($key . "-", "", $field['id']);
		$label_class = $raw_option_id . "-label";
		// get value of this field if it exists for this post
		$meta = get_post_meta($post->ID, $field['id'], true);


		if ((!isset($meta)&&isset($field['default'])&&!is_numeric($meta))||isset($meta)&&empty($meta)&&isset($field['default'])&&!is_numeric($meta))
		{
			//echo $field['id'].":".$meta;
			//echo "<br>";
			$meta = $field['default'];
		}

		// begin a table row with
		echo '<tr class="'.$field['id'].' '.$raw_option_id.' landing-page-option-row">
				<th class="landing-page-table-header '.$label_class.'"><label for="'.$field['id'].'">'.$field['label'].'</label></th>
				<td class="landing-page-option-td">';
				switch($field['type']) {
					// default content for the_content
					case 'default-content':
						echo '<span id="overwrite-content" class="button-secondary">Insert Default Content into main Content area</span><div style="display:none;"><textarea name="'.$field['id'].'" id="'.$field['id'].'" class="default-content" cols="106" rows="6" style="width: 75%; display:hidden;">'.$meta.'</textarea></div>';
						break;
					// text
					case 'colorpicker':
						if (!$meta)
						{
							$meta = $field['default'];
						}
						echo '<input type="text" class="jpicker" style="background-color:#'.$meta.'" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="5" /><span class="button-primary new-save-lp" id="'.$field['id'].'" style="margin-left:10px; display:none;">Update</span>
								<div class="lp_tooltip tool_color" title="'.$field['desc'].'"></div>';
						break;
					case 'datepicker':
						echo '<div class="jquery-date-picker" id="date-picking">	
						<span class="datepair" data-language="javascript">	
									Date: <input type="text" id="date-picker-'.$key.'" class="date start" /></span>
									Time: <input id="time-picker-'.$key.'" type="text" class="time time-picker" />
									<input type="hidden" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" class="new-date" value="" >
									<p class="description">'.$field['desc'].'</p>
							</div>';		
						break;						
					case 'text':
						echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
								<div class="lp_tooltip" title="'.$field['desc'].'"></div>';
						break;
					// textarea
					case 'textarea':
						echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="106" rows="6" style="width: 75%;">'.$meta.'</textarea>
								<div class="lp_tooltip tool_textarea" title="'.$field['desc'].'"></div>';
						break;
					// wysiwyg
					case 'wysiwyg':
						wp_editor( $meta, $field['id'], $settings = array() );
						echo	'<p class="description">'.$field['desc'].'</p>';							
						break;
					// media					
					case 'media':
						//echo 1; exit;
						echo '<label for="upload_image">';
						echo '<input name="'.$field['id'].'"  id="'.$field['id'].'" type="text" size="36" name="upload_image" value="'.$meta.'" />';
						echo '<input class="upload_image_button" id="uploader_'.$field['id'].'" type="button" value="Upload Image" />';
						echo '<p class="description">'.$field['desc'].'</p>'; 
						break;
					// checkbox
					case 'checkbox':
						$i = 1;
						echo "<table class='lp_check_box_table'>";						
						if (!isset($meta)){$meta=array();}
						elseif (!is_array($meta)){
							$meta = array($meta);
						}
						foreach ($field['options'] as $value=>$label) {
							if ($i==5||$i==1)
							{
								echo "<tr>";
								$i=1;
							}
								echo '<td><input type="checkbox" name="'.$field['id'].'[]" id="'.$field['id'].'" value="'.$value.'" ',in_array($value,$meta) ? ' checked="checked"' : '','/>';
								echo '<label for="'.$value.'">&nbsp;&nbsp;'.$label.'</label></td>';					
							if ($i==4)
							{
								echo "</tr>";
							}
							$i++;
						}
						echo "</table>";
						echo '<div class="lp_tooltip tool_checkbox" title="'.$field['desc'].'"></div>';
					break;
					// radio
					case 'radio':
						foreach ($field['options'] as $value=>$label) {
							//echo $meta.":".$field['id'];
							//echo "<br>";
							echo '<input type="radio" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$value.'" ',$meta==$value ? ' checked="checked"' : '','/>';
							echo '<label for="'.$value.'">&nbsp;&nbsp;'.$label.'</label> &nbsp;&nbsp;&nbsp;&nbsp;';								
						}
						echo '<div class="lp_tooltip" title="'.$field['desc'].'"></div>';
					break;
					// select
					case 'dropdown':
						echo '<select name="'.$field['id'].'" id="'.$field['id'].'" class="'.$raw_option_id.'">';
						foreach ($field['options'] as $value=>$label) {
							echo '<option', $meta == $value ? ' selected="selected"' : '', ' value="'.$value.'">'.$label.'</option>';
						}
						echo '</select><div class="lp_tooltip" title="'.$field['desc'].'"></div>';
					break;
					


				} //end switch
		echo '</td></tr>';
	} // end foreach
	echo '</table>'; // end table
}

function lp_render_global_settings($key,$custom_fields,$active_tab)
{

	//Check if active tab
	if ($key==$active_tab)
	{
		$display = 'block';
	}
	else
	{
		$display = 'none';
	}
	
	//echo $display;
	
	// Use nonce for verification
	echo "<input type='hidden' name='lp_{$key}_custom_fields_nonce' value='".wp_create_nonce('lp-nonce')."' />";

	// Begin the field table and loop
	echo '<table class="lp-tab-display" id="'.$key.'" style="display:'.$display.'">';
	//print_r($custom_fields);exit;
	foreach ($custom_fields as $field) {
		//echo $field['type'];exit; 
		// get value of this field if it exists for this post
		if (isset($field['default']))
		{
			$default = $field['default'];
		}
		else
		{
			$default = null;
		}
		
		$option = get_option($field['id'], $default);
		
		// begin a table row with
		echo '<tr>
				<th class="lp-gs-th" valign="top" style="font-weight:300px;"><small>'.$field['label'].':</small></th>
				<td>';
				switch($field['type']) {
					// text
					case 'colorpicker':
						if (!$option)
						{
							$option = $field['default'];
						}
						echo '<input type="text" class="jpicker" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$option.'" size="5" />
								<div class="lp_tooltip tool_color" title="'.$field['desc'].'"></div>';
						break;
					case 'datepicker':
						echo '<input id="datepicker-example2" class="Zebra_DatePicker_Icon" type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$option.'" size="8" />
								<div class="lp_tooltip tool_date" title="'.$field['desc'].'"></div><p class="description">'.$field['desc'].'</p>';
						break;	
					case 'license-key':
						$license_status = lp_check_license_status($field);
						//echo $license_status;exit;
						echo '<input type="hidden" name="lp_license_status-'.$field['slug'].'" id="'.$field['id'].'" value="'.$license_status.'" size="30" />
						<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$option.'" size="30" />
								<div class="lp_tooltip tool_text" title="'.$field['desc'].'"></div>';
						
						if ($license_status=='valid')
						{
							echo '<div class="lp_license_status_valid">Valid</div>';
						}
						else
						{
							echo '<div class="lp_license_status_invalid">Invalid</div>';
						}						
						break;	
					case 'text':
						echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$option.'" size="30" />
								<div class="lp_tooltip tool_text" title="'.$field['desc'].'"></div>';
						break;
					// textarea
					case 'textarea':
						echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="106" rows="6">'.$option.'</textarea>
								<div class="lp_tooltip tool_textarea" title="'.$field['desc'].'"></div>';
						break;
					// wysiwyg
					case 'wysiwyg':
						wp_editor( $option, $field['id'], $settings = array() );
						echo	'<span class="description">'.$field['desc'].'</span><br><br>';							
						break;
					// media					
						case 'media':
						//echo 1; exit;
						echo '<label for="upload_image">';
						echo '<input name="'.$field['id'].'"  id="'.$field['id'].'" type="text" size="36" name="upload_image" value="'.$option.'" />';
						echo '<input class="upload_image_button" id="uploader_'.$field['id'].'" type="button" value="Upload Image" />';
						echo '<br /><div class="lp_tooltip tool_media" title="'.$field['desc'].'"></div>'; 
						break;
					// checkbox
					case 'checkbox':
						$i = 1;
						echo "<table>";				
						if (!isset($option)){$option=array();}
						elseif (!is_array($option)){
							$option = array($option);
						}
						foreach ($field['options'] as $value=>$label) {
							if ($i==5||$i==1)
							{
								echo "<tr>";
								$i=1;
							}
								echo '<td><input type="checkbox" name="'.$field['id'].'[]" id="'.$field['id'].'" value="'.$value.'" ',in_array($value,$option) ? ' checked="checked"' : '','/>';
								echo '<label for="'.$value.'">&nbsp;&nbsp;'.$label.'</label></td>';					
							if ($i==4)
							{
								echo "</tr>";
							}
							$i++;
						}
						echo "</table>";
						echo '<br><div class="lp_tooltip tool_checkbox" title="'.$field['desc'].'"></div>';
					break;
					// radio
					case 'radio':
						foreach ($field['options'] as $value=>$label) {
							//echo $meta.":".$field['id'];
							//echo "<br>";
							echo '<input type="radio" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$value.'" ',$option==$value ? ' checked="checked"' : '','/>';
							echo '<label for="'.$value.'">&nbsp;&nbsp;'.$label.'</label> &nbsp;&nbsp;&nbsp;&nbsp;';								
						}
						echo '<div class="lp_tooltip tool_radio" title="'.$field['desc'].'"></div>';
					break;
					// select
					case 'dropdown':
						echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
						foreach ($field['options'] as $value=>$label) {
							echo '<option', $option == $value ? ' selected="selected"' : '', ' value="'.$value.'">'.$label.'</option>';
						}
						echo '</select><br /><div class="lp_tooltip tool_dropdown" title="'.$field['desc'].'"></div>';
					break;
					case 'html':
						//print_r($field);
						echo $option;
						echo '<br /><div class="lp_tooltip tool_dropdown" title="'.$field['desc'].'"></div>';
					break;
					


				} //end switch
		echo '</td></tr>';
	} // end foreach
	echo '</table>'; // end table
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
	//echo "hello";
	//echo $id;exit;
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
	//echo "1{$rate}2";exit;
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

function lp_check_license_status($field)
{
	//print_r($field);exit;
	$date = date("Y-m-d");
	$cache_date = get_option($field['id']."-expire");
	$license_status = get_option('lp_license_status-'.$field['slug']);
	
	if (isset($cache_date)&&($date<$cache_date)&&$license_status=='valid')
	{
		return "valid";
	}
		
	$license_key = get_option($field['id']);
	
	$api_params = array( 
		'edd_action' => 'check_license', 
		'license' => $license_key, 
		'item_name' => urlencode( $field['slug'] ) 
	);
	//print_r($api_params);
	
	// Call the custom API.
	$response = wp_remote_get( add_query_arg( $api_params, LANDINGPAGES_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );
	//print_r($response);

	if ( is_wp_error( $response ) )
		return false;

	$license_data = json_decode( wp_remote_retrieve_body( $response ) );
	//echo $license_data;exit;
	
	if( $license_data->license == 'valid' ) {
		$newDate = date('Y-m-d', strtotime("+15 days"));
		update_option($field['id']."-expire", $newDate);
		return 'valid';
		// this license is still valid
	} else {
		return 'invalid';
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