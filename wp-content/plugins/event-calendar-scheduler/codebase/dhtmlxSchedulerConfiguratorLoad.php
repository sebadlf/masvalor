<?php

if (!defined('E_DEPRECATED'))
	define('E_DEPRECATED', 8192);

$err = error_reporting();
if ($err & E_DEPRECATED) {
	$err = $err ^ E_DEPRECATED;
	error_reporting($err);
}
require('../../../../wp-config.php');
define('WP_USE_THEMES', true);
require_once(WP_PLUGIN_DIR.'/event-calendar-scheduler/codebase/dhtmlxSchedulerConfigurator.php');

$scheduler_table = 'options';
$scheduler_tableEvents = 'events_rec';
$scheduler_fieldName = 'option_name';
$scheduler_fieldValue = 'option_value';
$scheduler_userIdField = 'ID';
$scheduler_userLoginField = 'user_login';
$scheduler_tableUsers = 'users';

if (isset($wpdb->base_prefix)) {
	$scheduler_mu_version = true;
} else {
	$scheduler_mu_version = false;
}

if (($scheduler_mu_version == true)&&(get_site_option("scheduler_main") == 'on')) {
	$scheduler_prefix = $wpdb->base_prefix;
} else {
	$scheduler_prefix = $wpdb->prefix;
}


$scheduler_usertypes = Array(0 => 'subscriber', 1 => 'contributor', 2 => 'author', 3 => 'editor', 4 => 'editor', 5 => 'editor', 6 => 'editor', 7 => 'editor', 8 => 'administrator', 9 => 'administrator', 10 => 'administrator');
get_currentuserinfo();
$scheduler_userid = $current_user->id;
if (isset($current_user->roles[0])) {
	$scheduler_usertype = $current_user->roles[0];
} else {
	$scheduler_usertype = 'guest';
}

$scheduler_cfg = new SchedulerConfig('scheduler_config_xml', $wpdb->dbh, $scheduler_table, $scheduler_fieldName, $scheduler_fieldValue, $scheduler_tableEvents, $scheduler_userIdField, $scheduler_userLoginField, $scheduler_tableUsers, $scheduler_prefix, $scheduler_userid, false);
if (isset($_GET['config_xml'])) {
	header('Content-type: text/xml');
	echo $scheduler_cfg->getXML();
} else {
	if (isset($_GET['grid_events'])) {
		$scheduler_cfg->getEventsRecGrid();
	} else {
		if (isset($_GET['scheduler_events'])) {
			$scheduler_cfg->getEventsRec($scheduler_usertype, false);
		}
	}
}


?>