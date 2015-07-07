<?php
/**
 *  - login
 *  - navigate to plugins
 *  - verify landing pages is installed
 *  - deactivate landing pages
 *  - activate landing pages
 *  - confirm welcome page shows
 *  
*/


$I = new AcceptanceTester($scenario);


$I->wantTo('login to wp-admin');
$I->amOnPage( site_url().'/wp-login.php' );
$I->fillField('Username', 'admin');
$I->fillField('Password','admin');
$I->click('Log In');
$I->see('Dashboard');


$I->wantTo('Navigate to plugins');
$I->click( [ 'link' => 'Installed Plugins']);
$I->see('Plugins');
$I->see('Landing Pages');
$I->see('Calls to Action');
$I->see('Leads');

$I->wantTo('Verify landing pages is installed');
$I->click( '.active a');
$I->see('Landing Pages');
$I->see('Calls to Action');
$I->see('Leads');

$I->wantTo('Deactivate Landing Pages');
$I->click( '#landing-pages .deactivate a');
$I->see('deactivated');

$I->wantTo('Reactivate Landing Pages');
$I->click( '#landing-pages .activate a');

$I->wantTo('Confirm welcome page');
$I->see('Welcome to WordPress Landing Pages ');

