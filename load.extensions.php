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
			if ($name != ".svn"){	
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
			if ($name != ".svn"){
			include_once($extended_templates_path."$name/config.php");
			}
		}		
	}

	//Now load all config.php files with their custom meta data
	$template_paths = lp_get_core_template_paths();	
	if (count($template_paths)>0)
	{
		foreach ($template_paths as $name)
		{	
			if ($name != ".svn"){	
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
	//print_r($lp_data);exit;
	//ADD METABOX - SELECTED TEMPLATE
	$lp_data['lp']['options'][] = 	lp_add_option('lp',"radio","selected-template","default","Select Template","This option provides a placeholder for the selected template data", $options=null);
	
	//ADD METABOX - MAIN HEADLINE
	$lp_data['lp']['options'][] =  lp_add_option('lp',"radio","main-headline","","Set Main Headline","Set Main Headline", $options=null);	

	//IMPORT EXTERNAL DATA
	$lp_data = apply_filters( 'lp_extension_data' , $lp_data);
	
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
			
		$cat_value = $val['category'];
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
	//print_r($template_cats);exit;
	
	return $template_cats;
}

