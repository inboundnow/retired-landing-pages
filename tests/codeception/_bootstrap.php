<?php

/* load coception addons */
require '../../../vendor/lucatume/wp-browser/autoload.php';

/* load wp */
require '../../../wp-load.php';
require '../../../wp-admin/includes/plugin.php';

/* load required landing pages files */
include_once LANDINGPAGES_PATH . 'modules/module.install.php';
include_once LANDINGPAGES_PATH . 'classes/class.statistics.php';

/* Set current users */
wp_set_current_user( 1 );
global $wpdb;