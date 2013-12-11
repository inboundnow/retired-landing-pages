<?php

if (!defined('LANDINGPAGES_TEXT_DOMAIN'))
	define( 'LANDINGPAGES_TEXT_DOMAIN', 'inbound_now' ); 

add_action('init' , 'lp_load_text_domain');
function lp_load_text_domain()
{
	load_plugin_textdomain( LANDINGPAGES_TEXT_DOMAIN , false , LANDINGPAGES_PATH . 'shared/languages/landing-pages/' );
}