<?php
/**
 * @package Scheduler
 * @author DHTMLX LTD
 * @version 2.3.1
 */
/*
Plugin Name: Event Calendar / Scheduler
Plugin URI: http://wordpress.org/extend/plugins/event-calendar-scheduler/
Description: Events calendar that provides rich and intuitive scheduling solution
Author: DHTMLX LTD
Version: 2.3.1
Author URI: http://dhtmlx.com
*/

require (ABSPATH.WPINC.'/pluggable.php');
global $scheduler_lang, $wpdb, $scheduler_table_name, $scheduler_mu_version, $scheduler_cfg, $scheduler_prefix, $scheduler_userid, $default_xml;

$default_xml = '<config><active_tab>a1</active_tab><settings><settings_width>680px</settings_width><settings_height>600px</settings_height><settings_eventnumber>2</settings_eventnumber><settings_link></settings_link><settings_posts>false</settings_posts><settings_repeat>true</settings_repeat><settings_firstday>false</settings_firstday><settings_multiday>true</settings_multiday><settings_singleclick>false</settings_singleclick><settings_day>true</settings_day><settings_week>true</settings_week><settings_month>true</settings_month><settings_agenda>false</settings_agenda><settings_year>false</settings_year><settings_defaultmode>month</settings_defaultmode><settings_debug>false</settings_debug><settings_eventnumber>2</settings_eventnumber><settings_collision>false</settings_collision><settings_expand>true</settings_expand><settings_print>false</settings_print><settings_minical>false</settings_minical></settings><access><access_guestView>true</access_guestView><access_guestAdd>false</access_guestAdd><access_guestEdit>false</access_guestEdit><access_subscriberView>true</access_subscriberView><access_subscriberAdd>false</access_subscriberAdd><access_subscriberEdit>false</access_subscriberEdit><access_contributorView>true</access_contributorView><access_contributorAdd>false</access_contributorAdd><access_contributorEdit>false</access_contributorEdit><access_authorView>true</access_authorView><access_authorAdd>false</access_authorAdd><access_authorEdit>false</access_authorEdit><access_editorView>true</access_editorView><access_editorAdd>true</access_editorAdd><access_editorEdit>true</access_editorEdit><access_administratorView>true</access_administratorView><access_administratorAdd>true</access_administratorAdd><access_administratorEdit>true</access_administratorEdit><privatemode>off</privatemode></access><templates><templates_defaultdate><![CDATA[%d %M %Y]]></templates_defaultdate><templates_monthdate><![CDATA[%F %Y]]></templates_monthdate><templates_weekdate><![CDATA[%l]]></templates_weekdate><templates_daydate><![CDATA[%d/%m/%Y]]></templates_daydate><templates_hourdate><![CDATA[%H:%i]]></templates_hourdate><templates_monthday><![CDATA[%d]]></templates_monthday><templates_minmin><![CDATA[5]]></templates_minmin><templates_hourheight><![CDATA[40]]></templates_hourheight><templates_starthour><![CDATA[0]]></templates_starthour><templates_endhour><![CDATA[24]]></templates_endhour><templates_agendatime><![CDATA[30]]></templates_agendatime><templates_eventtext><![CDATA[return event.text;]]></templates_eventtext><templates_eventheader><![CDATA[return scheduler.templates.hour_scale(start) + " - " + scheduler.templates.hour_scale(end);]]></templates_eventheader><templates_eventbartext><![CDATA[return "<span title=\\\""+event.text+"\\\">" + event.text + "</span>";]]></templates_eventbartext></templates><customfields><customfield name="Text" dsc="Description" type="textarea" old_name="Text" use_colors="false" units="false" height="150" /></customfields></config>';

$scheduler_prefix_dump = false;
$scheduler_lang = array();
$scheduler_lang['Scheduler'] = 'Scheduler';

if (isset($wpdb->base_prefix)) {
	$query = "SELECT * FROM ".$wpdb->base_prefix."blogs LIMIT 1";
	$table_exists = $wpdb->query($query);
	if ($table_exists == false) {
		$scheduler_mu_version = false;
	} else {
		$scheduler_mu_version = true;
	}
} else {
	$scheduler_mu_version = false;
}

if (($scheduler_mu_version == true)&&(get_site_option("scheduler_main") == 'on')) {
	$scheduler_prefix = $wpdb->base_prefix;
} else {
	$scheduler_prefix = $wpdb->prefix;
}

register_activation_hook(__FILE__, 'scheduler_activate');
if (($scheduler_mu_version == true)&&(get_site_option('scheduler_main') == false)) {
	add_site_option('scheduler_main', 'off');
}

add_option('scheduler_started', '0');
add_option('scheduler_version', '2.1');

require_once(WP_PLUGIN_DIR.'/event-calendar-scheduler/codebase/dhtmlxSchedulerConfigurator.php');
require_once(WP_PLUGIN_DIR.'/event-calendar-scheduler/SchedulerHelper.php');
$scheduler_usertypes = Array(0 => 'subscriber', 1 => 'contributor', 2 => 'author', 3 => 'editor', 4 => 'editor', 5 => 'editor', 6 => 'editor', 7 => 'editor', 8 => 'administrator', 9 => 'administrator', 10 =>'administrator');
$scheduler_table = 'options';
$scheduler_table_name = 'events_rec';
$scheduler_fieldName = 'option_name';
$scheduler_fieldValue = 'option_value';
$scheduler_userIdField = 'ID';
$scheduler_userLoginField = 'user_login';
$scheduler_tableUsers = 'users';


scheduler_activate();

get_currentuserinfo();
$scheduler_userid = $current_user->id;

$scheduler_cfg = new SchedulerConfig('scheduler_config_xml', $wpdb->dbh, $scheduler_table, $scheduler_fieldName, $scheduler_fieldValue, $scheduler_table_name, $scheduler_userIdField, $scheduler_userLoginField, $scheduler_tableUsers, $scheduler_prefix, $scheduler_userid, false);
wp_register_sidebar_widget('upcoming_events', __('Oncoming events', 'scheduler'), 'upcoming_widget');
add_action('admin_menu', 'scheduler_add_pages');
add_action('admin_init', 'scheduler_admin_init');
add_action('init', 'scheduler_addbuttons');
add_filter('the_content', 'scheduler_check');

$version = get_option('scheduler_version');
if (($version !== false)&&((int) $version < 2)) {
	include('settings_export.php');
	update_option('scheduler_version', '2.1');
} else {
	add_option('scheduler_version', '2.1');
}

if ($scheduler_cfg->get_option('settings_link') == '') {
	create_scheduler_link();
}

$scheduler_locale = (WPLANG != "") ? WPLANG : "en_EN";
$scheduler_loc = substr($scheduler_locale, 0, 2);
load_plugin_textdomain('scheduler', PLUGINDIR.'/'.dirname(plugin_basename(__FILE__)).'/codebase/sources', dirname(plugin_basename(__FILE__)).'/codebase/sources');


function scheduler_admin_init(){
	global $scheduler_mu_version;
	register_setting('scheduler_options', 'scheduler_xml');
	register_setting('scheduler_options', 'scheduler_xml_version');
}


function scheduler_add_pages() {
	global $scheduler_lang, $scheduler_mu_version;
	if ((($scheduler_mu_version == true)&&(get_site_option('scheduler_main') !== 'on'))||($scheduler_mu_version == false)) {
		add_submenu_page('plugins.php', __('Scheduler', 'scheduler'), __('Scheduler', 'scheduler'), 'administrator', __FILE__, 'scheduler_settings');
	} else {
		add_submenu_page('wpmu-admin.php', __('Scheduler', 'scheduler'), __('Scheduler', 'scheduler'), 'administrator', __FILE__, 'scheduler_settings');
	}
}


function scheduler_settings() {
	global $scheduler_lang, $current_user, $scheduler_cfg, $scheduler_loc;
	include(ABSPATH.'wp-content/plugins/event-calendar-scheduler/admin.php');
}


function scheduler_init() {
	global $scheduler_usertypes, $current_user, $scheduler_userid, $scheduler_cfg, $scheduler_loc;
	if (isset($current_user->roles[0])) {
		$usertype = $current_user->roles[0];
	} else {
		$usertype = 'guest';
	}
	$url = WP_PLUGIN_URL.'/event-calendar-scheduler/codebase/';
	$loader_url = WP_PLUGIN_URL.'/event-calendar-scheduler/codebase/dhtmlxSchedulerConfiguratorLoad.php?scheduler_events=true';
	$final = $scheduler_cfg->schedulerInit($usertype, $scheduler_loc, $url, $loader_url);
	return $final;
}


function get_events($number = 5) {
	global $wpdb, $scheduler_prefix, $scheduler_cfg, $scheduler_userid;

	date_default_timezone_set(get_option('timezone_string'));
	$start = date('Y-m-d H:i:s');
	$endd = date('Y-m-d H:i:s', time() + 60*60*24*30*3);
	$dates = new SchedulerHelper($wpdb->dbh, $scheduler_prefix.'events_rec');
	$events = $dates->get_dates($start, $endd);
	date_default_timezone_set('UTC');

	if ($scheduler_cfg->get_option("privatemode") == "on") {
		$all_events = $events;
		$events = Array();
		for ($i = 0; $i < count($all_events); $i++) {
			if ($all_events[$i]['user'] == $scheduler_userid)
				$events[] = $all_events[$i];
		}
	}

	$repeat = true;
	while ($repeat == true) {
		$repeat = false;
		for ($i = 0; $i < count($events) - 1; $i++) {
			if ($events[$i]['start_date'] > $events[$i + 1]['start_date']) {
				$ev = $events[$i];
				$events[$i] = $events[$i + 1];
				$events[$i + 1] = $ev;
				$repeat = true;
			}
		}
	}
	if ($number < count($events)) {
		array_splice(&$events, $number);
	}
	return $events;
}


function scheduler_sidebar() {
	global $wpdb, $scheduler_prefix, $scheduler_table_name, $scheduler_lang, $usertypes, $current_user, $scheduler_userid, $scheduler_cfg;

	$usertype = $current_user->user_level;
	if (isset($current_user->roles[0])) {
		$usertype = $current_user->roles[0];
	} else {
		$usertype = 'guest';
	}

	if ($scheduler_cfg->get_option("access_".$usertype."View") != 'true') {
		return '';
	}

	include(WP_PLUGIN_DIR.'/event-calendar-scheduler/sidebar.php');
	$number = $scheduler_cfg->get_option('settings_eventnumber');
	if ($number == '') {
		$number = 5;
	}

	$events = get_events($number);

	$final = '<ul>';
	if (count($events) == 0) {
		$final = '';
	}

	$url = $scheduler_cfg->get_option('settings_link');

	for ($i = 0; $i < count($events); $i++) {
		$event = $sidebarEvent;
		$url_rand = $url.((strpos($url, "?") !== false) ? "&" : "?")."dhx_rand=".rand(10000, 99000);
		$start_date = str_replace("-", "/", $events[$i]['start_date']);
		$start_date = date_parse($events[$i]['start_date']);
		$start_date = mktime($start_date['hour'], $start_date['minute'], $start_date['second'], $start_date['month'], $start_date['day'], $start_date['year']);
		$start_date = date_i18n(get_option('date_format').' '.get_option('time_format'), $start_date);

		$event = str_replace("{*URL*}", $url_rand, $event);
		$event = str_replace("{*DATE*}", $start_date, $event);
		$event = str_replace("{*DATE_SQL*}", $events[$i]['start_date'], $event);
		$event = str_replace("{*TEXT*}", stripslashes($events[$i]['text']), $event);
		$final .= $event;
	}
	$final .= '</ul>';
	return $final;
}


function scheduler_check($content) {
	global $scheduler_lang;
	$ver = phpversion();
	$ver_main = (int) substr($ver, 0, 1);
	if ( $ver_main < 5) {
		return __('Installation error: Event Calendar / Scheduler plugin requires PHP 5.x', 'scheduler');
	}

	if (strpos($content, "[[scheduler_plugin]]") !== FALSE)  {
		$content = preg_replace('/<p>\s*\[\[(.*)\]\]\s*<\/p>/i', "[[$1]]", $content);
		$content = preg_replace('/\[\[scheduler_plugin\]\]/Ui', scheduler_init(), $content, 1);
		$content = str_replace('[[scheduler_plugin]]', '', $content);
	}
	if (strpos($content, "[[scheduler_sidebar]]")) {
		$content = preg_replace('/<p>\s*\[\[(.*)\]\]\s*<\/p>/i', "[[$1]]", $content);
		$content = str_replace('[[scheduler_sidebar]]', scheduler_sidebar(), $content);
	}
	return $content;
}


function scheduler_addbuttons() {
	global $current_user, $scheduler_usertypes, $scheduler_cfg;
	get_currentuserinfo();
	$usertype = $current_user->user_level;
	if (isset($current_user->roles[0])) {
		$usertype = $current_user->roles[0];
	} else {
		$usertype = 'guest';
	}
	if ((!current_user_can('edit_posts') && ! current_user_can('edit_pages'))||($scheduler_cfg->get_option("access_".$usertype."Add") != 'true')) {
		return;
	}

	if (get_user_option('rich_editing') == 'true') {
		add_filter("mce_external_plugins", "add_scheduler_tinymce_plugin");
		add_filter('mce_buttons', 'register_scheduler_button');
	}
}


function register_scheduler_button($buttons) {
	array_push($buttons, "separator", "scheduler");
	return $buttons;
}


function add_scheduler_tinymce_plugin($plugin_array) {
	$plugin_array['scheduler'] = WP_PLUGIN_URL.'/event-calendar-scheduler/mce_scheduler/editor_plugin.js';
	return $plugin_array;
}

function upcoming_widget($args) {
    extract($args);
	echo $before_widget;
	echo $before_title;
	echo __('Oncoming events', 'scheduler');
	echo $after_title;
	echo scheduler_sidebar();
	echo $after_widget;
}


function scheduler_activate() {
	global $wpdb, $scheduler_table_name, $scheduler_cfg, $scheduler_prefix, $default_xml;

	$table_exists = $wpdb->query("SELECT * FROM ".$scheduler_prefix.$scheduler_table_name);
	if ($wpdb->last_error !== '') {
		create_events_rec();
	}

	$field_exists = $wpdb->query("SELECT `user` FROM ".$scheduler_prefix.$scheduler_table_name);
	if ($wpdb->last_error !== '') {
		create_user_field();
	}

	$table_exists = $wpdb->query("SELECT * FROM ".$scheduler_prefix."options");
	if ($wpdb->last_error !== '') {
		create_options();
	}

	$config_exists = $wpdb->query("SELECT * FROM ".$scheduler_prefix."options WHERE option_name='scheduler_php'");
	if ($config_exists == false) {
		set_default_options();
	}

	$stable_config_row = $wpdb->get_row("SELECT * FROM ".$scheduler_prefix."options WHERE option_name='scheduler_stable_config' LIMIT 1");
	if (!$stable_config_row) {
		$query = "INSERT INTO ".$scheduler_prefix."options VALUES (null, 0, 'scheduler_stable_config', '".$default_xml."', 'yes')";
		$wpdb->query($query);
	}
	$version = (int) get_option('scheduler_xml_version');
	update_option('scheduler_xml_version', $version + 1);
}


function create_events_rec() {
	global $wpdb, $scheduler_table_name, $scheduler_prefix;
	$query = "CREATE TABLE IF NOT EXISTS `".$scheduler_prefix.$scheduler_table_name."` (
		`event_id` int(11) NOT NULL AUTO_INCREMENT,
		`start_date` datetime NOT NULL,
		`end_date` datetime NOT NULL,
		`text` varchar(255) NOT NULL,
		`rec_type` varchar(64) NOT NULL,
		`event_pid` int(11) NOT NULL,
		`event_length` int(11) NOT NULL,
		`user` int(11) NOT NULL,
		PRIMARY KEY (`event_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
	$wpdb->query($query);

	$query = "INSERT INTO ".$scheduler_prefix.$scheduler_table_name.
		" (`start_date`, `end_date`, `text`, `event_pid`, `event_length`) VALUES ".
		"(NOW(), DATE_ADD(NOW(), INTERVAL 5 MINUTE), 'The Scheduler Calendar was installed!', 0, 0);";
	$wpdb->query($query);
}

function create_user_field() {
	global $wpdb, $scheduler_prefix, $scheduler_table_name;
	$query = "ALTER TABLE `".$scheduler_prefix.$scheduler_table_name."` ADD COLUMN `user` int(11) NOT NULL";
	$wpdb->query($query);
}

function create_options() {
	global $wpdb, $scheduler_prefix;
	$query = "CREATE TABLE `".$scheduler_prefix."options` (
		`option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
		`blog_id` int(11) NOT NULL DEFAULT '0',
		`option_name` varchar(64) NOT NULL DEFAULT '',
		`option_value` longtext NOT NULL,
		`autoload` varchar(20) NOT NULL DEFAULT 'yes',
		PRIMARY KEY (`option_id`),
		UNIQUE KEY `option_name` (`option_name`)
		) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
	$wpdb->query($query);
}

function set_default_options() {
	global $wpdb, $scheduler_prefix, $default_xml;
	$query = "INSERT INTO ".$scheduler_prefix."options VALUES (null, 0, 'scheduler_php', '', 'yes')";
	$wpdb->query($query);
	$query = "INSERT INTO ".$scheduler_prefix."options VALUES (null, 0, 'scheduler_xml', '".$default_xml."', 'yes')";
	$wpdb->query($query);
	$query = "INSERT INTO ".$scheduler_prefix."options VALUES (null, 0, 'scheduler_php_version', '0', 'yes')";
	$wpdb->query($query);
	$query = "INSERT INTO ".$scheduler_prefix."options VALUES (null, 0, 'scheduler_xml_version', '1', 'yes')";
	$wpdb->query($query);
	$query = "INSERT INTO ".$scheduler_prefix."options VALUES (null, 0, 'scheduler_num', '5', 'yes')";
	$wpdb->query($query);
	$query = "INSERT INTO ".$scheduler_prefix."options VALUES (null, 0, 'scheduler_url', '', 'yes')";
	$wpdb->query($query);
	$query = "INSERT INTO ".$scheduler_prefix."options VALUES (null, 0, 'scheduler_stable_config', '".$default_xml."', 'yes')";
	$wpdb->query($query);
}

function create_scheduler_link() {
	global $wpdb, $scheduler_cfg, $scheduler_prefix, $scheduler_mu_version;
	$url_query = "SELECT `guid` FROM `".$scheduler_prefix."posts` WHERE `post_title`='scheduler'";
	$url_exists = $wpdb->get_var($url_query);
	if ($url_exists == false) {
		$page_number = "SELECT MAX(`ID`) FROM `".$scheduler_prefix."posts`";
		$page_number = $wpdb->get_var($page_number);
		if ($scheduler_mu_version) {
			$scheduler_url = get_option('home').'/?page_id='.($page_number + 1);
		} else {
			$scheduler_url = get_option('siteurl')."/?page_id=".($page_number + 1);
		}
		$insert = "INSERT INTO `".$scheduler_prefix."posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
			(".($page_number + 1).", 1, '".date("Y-m-d H:i:s")."', '0000-00-00 00:00:00', '[[scheduler_plugin]]', 'scheduler', '', 'publish', 'closed', 'closed', '', 'scheduler', '', '', '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."', '', 0, '".$scheduler_url."', 0, 'page', '', 0)";
		$wpdb->query($insert);
	}
	$url_query = "SELECT `guid` FROM `".$wpdb->prefix."posts` WHERE `post_title`='scheduler'";
	$url = $wpdb->get_var($url_query);
	$scheduler_cfg->set_option('settings_link', $url);
}

?>