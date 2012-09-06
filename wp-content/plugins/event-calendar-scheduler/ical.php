<?php

require('../../../wp-config.php');


function makeIcal() {
	global $wpdb;
	$query = 'SET NAMES utf8';
	$wpdb->query($query);
	if (isset($wpdb->base_prefix)) {
		$prefix = $wpdb->base_prefix;
	} else {
		$prefix = $wpdb->prefix;
	}
	
	if (isset($_GET['oncoming'])) {
		$query = "SELECT `event_id`, `start_date`, `end_date`, `text` FROM `".$prefix."events_rec` WHERE `rec_type`='' AND `event_pid`='0' AND `end_date` > NOW()";
	} else {
		$query = "SELECT `event_id`, `start_date`, `end_date`, `text` FROM `".$prefix."events_rec` WHERE `rec_type`='' AND `event_pid`='0'";
	}
	$events = $wpdb->get_results($query);

	$blogName = get_option('blogdescription');
	$blogName = str_replace("\r\n", " ", $blogName);
	$blogName = str_replace("\n", " ", $blogName);
	$timezone = get_option('timezone_string');

	$ics = "BEGIN:VCALENDAR\r\nPRODID: dhtmlxScheduler\r\nVERSION: 2.0\r\nCALSCALE:GREGORIAN\r\nMETHOD:PUBLISH\r\nX-WR-CALNAME:".$blogName."\r\nX-WR-TIMEZONE:".$timezone."\r\n";

	for ($i = 0; $i < count($events); $i ++) {
		$event = $events[$i];
		$start_date = makeTime($event->start_date);
		$end_date = makeTime($event->end_date);
		$timest_end = date_parse($event->end_date);
		$timest_end = mktime($timest_end['hour'], $timest_end['minute'], $timest_end['second'], $timest_end['month'], $timest_end['day'], $timest_end['year']);

		if ($timest_end < time()) {
			$status = 'CANCELLED';
		} else {
			$status = 'CONFIRMED';
		}

		$dsc = $event->text;
		$uid = md5($event->event_id.time());
		$ics .= "BEGIN:VEVENT\r\nDTSTART:".$start_date."\r\nDTEND:".$end_date."\r\nUID:".$uid."\r\nDESCRIPTION:".$dsc."\r\nSTATUS:".$status."\r\nSUMMARY:".$dsc."\r\nTRANSP:OPAQUE\r\nEND:VEVENT\r\n";
	}


	$ics .= "END:VCALENDAR";
	header('Content-type: text/calendar; charset=utf-8');
	header("Content-Disposition: attachment; filename=dhtmlxScheduler.ics");
	echo $ics;
}


function makeTime($date) {
	$date = str_replace("-", "", $date);
	$date = str_replace(":", "", $date);
	$date = str_replace(" ", "T", $date);
	return $date;
}

makeIcal();

?>