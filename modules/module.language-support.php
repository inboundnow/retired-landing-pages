<?php

add_action('init' , 'lp_load_text_domain');
function lp_load_text_domain()
{
	load_plugin_textdomain( LANDINGPAGES_TEXT_DOMAIN , false , LANDINGPAGES_PLUGIN_SLUG.'/shared/languages/landing-pages/' );
}
