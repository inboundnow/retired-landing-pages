<?php

/* load wp */
require '../../../wp-load.php';
require '../../../wp-admin/includes/plugin.php';

/* load required landing pages files */
include_once LANDINGPAGES_PATH . 'modules/module.install.php';
include_once LANDINGPAGES_PATH . 'classes/class.statistics.php';