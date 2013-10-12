<?php

/**
 * LOAD NATIVE TEMPLATES FROM WP-CONTENT/PLUGINS LANDING-PAGES/TEMPLATES/
 */		
	$template_paths = lp_get_core_template_paths();		
	//Now load all config.php files with their custom meta data
	if (count($template_paths)>0)
	{
		foreach ($template_paths as $name)
		{	
			if ($name != ".svn" && $name != ".git"){	
			include_once(LANDINGPAGES_PATH."/templates/$name/config.php");
			}	
		}		
	}

/**
 * LOAD NON-NATIVE TEMPLATES FROM WP-CONTENT/UPLOADS/LANDING-PAGES/TEMPLATES/
 */
	 
	$template_paths = lp_get_extended_template_paths();	
	$uploads = wp_upload_dir();
	$uploads_path = $uploads['basedir'];
	$extended_templates_path = $uploads_path.'/landing-pages/templates/';

	if (count($template_paths)>0)
	{
		foreach ($template_paths as $name)
		{	
			$match = FALSE;
			if (strpos($name, 'tmp') !== FALSE) {
				$match = TRUE;
			}
			if ($name != ".svn" && $name != ".git" && $match === FALSE){
			
				include_once($extended_templates_path."$name/config.php");				
				$extended_templates[$name] = array('slug'=>$name);
			}
		}
		
		//now add license key inputs to global settings area	
		add_filter('lp_define_global_settings', 'lp_add_template_license_keys',99,1);
		function lp_add_template_license_keys($lp_global_settings)
		{
			$lp_data = lp_get_extension_data();
			
			$lp_global_settings['lp-license-keys']['settings'][] = 	array(
					'id'  => 'template-license-keys-header',
					'description' => "Head to http://www.inboundnow.com/ to retrieve your license key for this template.",
					'type'  => 'header',
					'default' => '<h3 class="lp_global_settings_header">Template License Keys</h3>'
			);
			
			foreach ($lp_data as $key=>$data)
			{
				$template_name = $lp_data[$key]['info']['label'];
				$lp_global_settings['lp-license-keys']['settings'][] = 	array(
					'id'  => $key,
					'label' => $template_name,
					'slug' => $key,
					'description' => "Head to http://www.inboundnow.com/ to retrieve your license key for this template.",
					'type'  => 'license-key',
				);
			}

			return $lp_global_settings;
		}	
	}

	//Now load all config.php files with their custom meta data
	$template_paths = lp_get_core_template_paths();	
	if (count($template_paths)>0)
	{
		foreach ($template_paths as $name)
		{	
			if ($name != ".svn" && $name != ".git"){	
			include_once(LANDINGPAGES_PATH."/templates/$name/config.php"); 	
			}
		}		
	}
	

 /**
 * DECLARE HELPER FUNCTIONS
 */
	 

function lp_get_extension_data()
{
	global $lp_data;
	
	//add core settings to main tab
	$parent_key = 'lp';	
	$lp_data[$parent_key]['settings'] = 
		array(	
			//ADD METABOX - SELECTED TEMPLATE	
			array(
				'id'  => 'selected-template',
				'label' => 'Select Template',
				'description' => "This option provides a placeholder for the selected template data.",
				'type'  => 'radio', // this is not honored. Template selection setting is handled uniquely by core.
				'default'  => 'default',
				'options' => null // this is not honored. Template selection setting is handled uniquely by core.
			),
			array(
				'id'  => 'main-headline',
				'label' => 'Set Main Headline',
				'description' => "Set Main Headline",
				'type'  => 'text', // this is not honored. Main Headline Input setting is handled uniquely by core.
				'default'  => '',
				'options' => null 
			),
		);
	
	//IMPORT EXTERNAL DATA
	$lp_data = apply_filters( 'lp_extension_data' , $lp_data);
	
	return $lp_data;
}

/* Provide backwards compatibility for older data array model */
add_filter('lp_extension_data','lp_rebuild_old_data_configurations_to_suit_new_convention');
function lp_rebuild_old_data_configurations_to_suit_new_convention($lp_data)
{
	foreach ($lp_data as $parent_key => $subarray)
	{
		if (is_array($subarray))
		{
			foreach ($subarray as $k=>$subsubarray)
			{
				/* change 'options' key to 'settings' */
				if ($k=='options')
					$lp_data[$parent_key]['settings'] = $subsubarray;
				
				if ($k=='category')
					$lp_data[$parent_key]['info']['category'] = $subsubarray;
				
				if ($k=='version')
					$lp_data[$parent_key]['info']['version'] = $subsubarray;
				
				if ($k=='label')
					$lp_data[$parent_key]['info']['label'] = $subsubarray;
				
				if ($k=='description')
					$lp_data[$parent_key]['info']['description'] = $subsubarray;
			}
		}
	}
	
	return $lp_data;
}

function lp_get_core_template_paths()
{
		
	$template_path =LANDINGPAGES_PATH."/templates/" ; 
	$results = scandir($template_path);
	
	//scan through templates directory and pull in name paths
	foreach ($results as $name) {
		if ($name === '.' or $name === '..' or $name === '__MACOSX') continue;

		if (is_dir($template_path . '/' . $name)) {
			$template_paths[] = $name;
		}
	}
	
	return $template_paths;
}


function lp_get_extended_template_paths()
{
	//scan through templates directory and pull in name paths
	$uploads = wp_upload_dir();
	$uploads_path = $uploads['basedir'];
	$extended_path = $uploads_path.'/landing-pages/templates/';
	$template_paths = array();
	
	if (!is_dir($extended_path))
	{
		wp_mkdir_p( $extended_path );
	}
	
	$results = scandir($extended_path);
	
		
	//scan through templates directory and pull in name paths
	foreach ($results as $name) {
		if ($name === '.' or $name === '..' or $name === '__MACOSX') continue;

		if (is_dir($extended_path . '/' . $name)) {
			$template_paths[] = $name;
		}
	}

	return $template_paths;
}

function lp_get_extension_data_cats($array)
{
	foreach ($array as $key=>$val)
	{
		if ($key=='lp'||substr($key,0,4)=='ext-')
			continue;
		
		/* allot for older lp_data model */		
		if (isset($val['category']))
		{
			$cat_value = $val['category'];
		}
		else
		{
			if (isset($val['info']['category']))
			{
				$cat_value = $val['info']['category'];
			}
		}
		
		$name = str_replace(array('-','_'),' ',$cat_value);
		$name = ucwords($name);
		if (!isset($template_cats[$cat_value]))
		{						
			$template_cats[$cat_value]['count'] = 1;
			$template_cats[$cat_value]['value'] = $cat_value;
			//$template_cats[$cat_value]['label'] = "$name (".$template_cats[$cat_value]['count'].")";
			$template_cats[$cat_value]['label'] = "$name";
		}
		else
		{			
			$template_cats[$cat_value]['count']++;
			//$template_cats[$cat_value]['label'] = "$name (".$template_cats[$cat_value]['count'].")";
			$template_cats[$cat_value]['label'] = "$name";
			$template_cats[$cat_value]['value'] = $cat_value;
		}
	}
	
	return $template_cats;
}

