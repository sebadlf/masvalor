<?php
//
// $Id: masvalor_app_install.php, v 0.00 Thu Mar 04 2010 18:42:33 GMT+0000 (IST) Francis Crossen $
//

/**
 * @package    Tina-MVC
 * @subpackage    Tina-Masvalor
 * @author     Tsavo Group <www.tsavogroup.com.ar>
 * @copyright  Tsavo Group <www.tsavogroup.com.ar>
 */
	
	function masvalor_create_db(){
		global $wpdb;
		//Creates the table for Hello Example
		$sql = 'CREATE TABLE IF NOT EXISTS '.$wpdb->prefix.'example 
			(
			id INT(10) NOT NULL AUTO_INCREMENT,
			name VARCHAR(255),
			PRIMARY KEY (id) 
			);';
		$wpdb->query($sql);
		//Heres your tables
		$sql = 'CREATE TABLE IF NOT EXISTS '.$wpdb->prefix.'masvalor_activities 
			(
			id INT(10) NOT NULL AUTO_INCREMENT,
			post_id int(11) NOT NULL,
			start_date varchar(50) NOT NULL,
			end_date varchar(50) NOT NULL,
			PRIMARY KEY (id) 
			);';
		$wpdb->query($sql);
	}
?>