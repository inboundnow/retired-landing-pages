<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('login to wp-admin');
$I->amOnPage( site_url().'/wp-login.php' );
$I->fillField('Username', 'admin');
$I->fillField('Password','admin');
$I->click('Log In');
$I->see('Dashboard');
