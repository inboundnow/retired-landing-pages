<?php
/**
 *  - login
 *  - navigate to plugins
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
$I->see('Active');

$I->wantTo('Deactivate Landing Pages');
$I->click( '#landing-pages .deactivate a');
$I->see('deactivated');

$I->wantTo('Reactivate Landing Pages');
$I->click( '#landing-pages .activate a');

$I->wantTo('Confirm welcome page');
$I->see('Welcome to WordPress Landing Pages ');

