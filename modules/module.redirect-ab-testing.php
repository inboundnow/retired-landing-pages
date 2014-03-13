<?php

define("QUICK_CACHE_ALLOWED", false); 
define("DONOTCACHEPAGE", true); 
define('DONOTCACHCEOBJECT', true); 
define('DONOTCDN', true); 

if ( file_exists ( './../../../../wp-config.php' ) )
{
	include_once ( './../../../../wp-config.php' );
	include_once ( './../../../../wp-includes/admin-bar.php' );
}
else if ( file_exists ( './../../../../../wp-config.php' ) )
{
	include_once ( './../../../../../wp-config.php' );
}

$VariationRoation = new LP_Variation_Rotation; 

class LP_Variation_Rotation {

	private $permalink_name;
	private $post_id;
	private $last_loaded_variation;
	private $variations; 
	private $marker;
	private $next_marker;
	private $destination_url;
	
	/* Exectutes Class */
	function __construct() {
	
		self::load_variables();
		//self::run_debug();
		self::redirect();		
		
	}
	
	/* Loads Static Variables */
	function load_variables()
	{	
		$this->permalink_name = (isset($_GET['permalink_name'])) ? $_GET['permalink_name'] : null;
		$this->post_id = $this->load_post_id();
		$this->last_loaded_variation = ( isset( $_COOKIE['lp-loaded-variation-'.$this->permalink_name] ) ) ? $_COOKIE['lp-loaded-variation-'.$this->permalink_name] : null;
		$this->variations = $this->load_variations();
		$this->marker = $this->load_marker();
		$this->next_marker = $this->discover_next_variation();
		$this->destination_url = $this->build_destination_url();
	}
	
	/* Debug Information - Prints Class Variable Data */
	private function run_debug() {
		print_r($this);exit;
	}
	
	/* Loads the ID of the Landing Page */
	private function load_post_id() {
		global $table_prefix;
		
		$query = "SELECT * FROM {$table_prefix}posts WHERE post_name='".mysql_real_escape_string($_GET['permalink_name'])."' AND post_type='landing-page' LIMIT 1";
		$result = mysql_query($query);
		if (!$result){ echo $query; echo mysql_error(); exit;}	

		$array = mysql_fetch_array($result);
		$post_id = $array['ID'];
		
		return $post_id;		
	}
	
	/* Loads an Array of Active Variations Associated with Landing Page */
	private function load_variations() {
		
		$live_variations = array();
		
		$variations_string = get_post_meta( $this->post_id , 'lp-ab-variations' , true );	
		$variations = explode(',',$variations_string);
		$variations = array_filter($variations,'is_numeric');
		
		/* Check the Status of Each Variation and Keep Live Ones */
		foreach ($variations as $key=>$vid) {
		
			if ($vid==0) {
				$variation_status = get_post_meta( $this->post_id , 'lp_ab_variation_status' , true );
			} else 	{
				$variation_status = get_post_meta( $this->post_id , 'lp_ab_variation_status-'.$vid , true );
			}

			if (!is_numeric($variation_status) || $variation_status==1) {
				$live_variations[] = $vid;
			}
			
		}		
		
		return $live_variations;		
	}
	
	/* Loads Variation ID of Last Variation Loaded */
	private function load_marker() {
		
		$marker = get_post_meta( $this->post_id , 'lp-ab-variations-marker' , true );
		
		if ( !is_numeric($marker) || !in_array( $marker , $this->variations ) ) {

			$marker = current($this->variations);
		}
		
		return $marker;
	}
	
	/* Discovers Next Variation in Line */
	private function discover_next_variation() {
	
		/* Set Pointer to Correct Location in Variations Array */
		while ( $this->marker != current( $this->variations) ) {
			next($this->variations);
		}
		
		/* Discover the next variation in the array */
		next($this->variations);
		
		/* If the pointer is empty then reset array */
		if ( !is_numeric(current( $this->variations ) ) ) {
			reset( $this->variations );
		}
		
		/* Save as Historical Data */		
		update_post_meta( $this->post_id , 'lp-ab-variations-marker' , current( $this->variations ) );
		
		return current( $this->variations );
		
	}
	
	/* Builds Redirect URL & Stores Cookie Data */
	private function build_destination_url() {
		
		/* Load Base URL */
		$url = get_permalink($this->post_id);
		
		/* Keep GET Params */
		foreach ($_GET as $key=>$value) {
			if ($key != "permalink_name"){
				$old_params .= "&$key=" . $value;
			}
		}
		
		/* Build Final URL and Set Memory Cookies */
		$url = $url."?lp-variation-id=".$this->next_marker.$old_params;
		
		/* Set Memory Cookies */
		setcookie('lp-loaded-variation-'.$this->permalink_name , $url , time()+ 60 * 60 * 24 * 30 , "/" );
		setcookie( 'lp-variation-id' , $this->variation_id , time()+3600 , "/" );
		
		return $url;
	}

	/* Redirects to Correct Variation */
	private function redirect() {
		@header("HTTP/1.1 307 Temporary Redirect");
		@header("Location: ".$this->destination_url);
	}
}