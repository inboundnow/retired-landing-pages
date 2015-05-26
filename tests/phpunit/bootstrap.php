<?php
/**
 * Bootstrap the plugin unit testing environment.
 *
 * @package wordpress-plugin-tests
 */

/* load wp */
require '../../../wp-load.php';
require '../../../wp-admin/includes/plugin.php';
require './vendor/autoload.php';


use JonnyW\PhantomJs\Client;

/**
*  Replacement for wp_remote_get
*  processes javascript through PhantomJs
*/
function inbound_remote_get() {
	
	$phantomJs = Client::getInstance();
	error_log(print_r($phantomJs,true));
	$phantomJs->setBinDir( LANDINGPAGES_PATH .  'tests/bin/' );
	$phantomJs->setPhantomJs( LANDINGPAGES_PATH .  'tests/bin/phantomjs.exe');
	$phantomJs->setPhantomLoader( LANDINGPAGES_PATH . 'vendor/jonnyw/php-phantomjs/bin/phantomloader');
	
	$request  = $phantomJs->getMessageFactory()->createRequest();
	$response = $phantomJs->getMessageFactory()->createResponse();

	$request->setMethod('GET');
	$request->setUrl('https://inboundnow.com');

	$phantomJs->send($request, $response);

	if($response->getStatus() === 200) {
		echo $response->getContent();
	}

	print_r($response); 
} 

inbound_remote_get();
exit;


