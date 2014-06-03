<?php

/* Public methods in this class will be run at least once during plugin activation script. */ 
/* Updater methods fired are stored in transient to prevent repeat processing */

if ( !class_exists('Landing_Pages_Activation_Update_Processes') ) {

	class Landing_Pages_Activation_Update_Processes {
		
		/* 
		* UPDATE METHOD
		* Migrates data stored in wp_content and lp-conversion-area
		*/
		public static function migrate_theme_meta_data_1_5_6() {

			/* for all landing pages load variations */
			$landing_pages = get_posts( array (
				'post_type' => 'landing-page',
				'posts_per_page' => -1
			));
			
			foreach ($landing_pages as $page) {
				/* for all variations loop through and migrate_data */
				
				$variations = ( get_post_meta($page->ID,'lp-ab-variations', true) ) ? $variations : array();
				
				foreach ($variations as $key=>$vid) {
					echo $vid;
				
				}
				
			}
			
				
		}
		
		/* 
		* UPDATE METHOD
		* Moves legacy templates to uploads folder 
		*/
		public static function updater_move_legacy_templates() {
		
			/* move copy of legacy core templates to the uploads folder and delete from core templates directory */
			$templates_to_move = array('rsvp-envelope','super-slick');
			chmod(LANDINGPAGES_UPLOADS_PATH, 0755);

			$template_paths = lp_get_core_template_paths();
			if (count($template_paths)>0)
			{
				foreach ($template_paths as $name)
				{
					if (in_array( $name, $templates_to_move ))
					{
						$old_path = LANDINGPAGES_PATH."templates/$name/";
						$new_path = LANDINGPAGES_UPLOADS_PATH."$name/";

						/*
						echo "oldpath: $old_path<br>";
						echo "newpath: $new_path<br>";
						*/

						@mkdir($new_path , 0775);
						chmod($old_path , 0775);

						self::move_files( $old_path , $new_path );

						rmdir($old_path);
					}
				}
			}
		}
		
		/* Private Method - Moves files from one folder the older. This is not an updater process */
		private static function move_files(  $old_path , $new_path  ) {
			
			$files = scandir($old_path);
			
			if (!$files) {
				return;
			}
			
			foreach ($files as $file) {
				if (in_array($file, array(".",".."))) continue;

				if ($file==".DS_Store")
				{
					unlink($old_path.$file);
					continue;
				}

				if (is_dir($old_path.$file))
				{
					@mkdir($new_path.$file.'/' , 0775);
					chmod($old_path.$file.'/' , 0775);
					lp_move_template_files( $old_path.$file.'/' , $new_path.$file.'/' );
					rmdir($old_path.$file);
					continue;
				}

				/*
				echo "oldfile:".$old_path.$file."<br>";
				echo "newfile:".$new_path.$file."<br>";
				*/

				if (copy($old_path.$file, $new_path.$file)) {
					unlink($old_path.$file);
				}
			}
			
			$delete = (isset($delete)) ? $delete : false;
			
			if (!$delete) {
				return;
			}
		}
		
	}

}


/* Declare Helper Functions here */
function lp_move_template_files( $old_path , $new_path )
{

	

}