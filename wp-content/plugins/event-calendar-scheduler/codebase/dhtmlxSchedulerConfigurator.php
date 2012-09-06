<?php


class SchedulerConfig {

	private $xml;
	private $settings = Array();
	private $userid;
	private $default_xml = '<config><active_tab>a1</active_tab><settings><settings_width>680px</settings_width><settings_height>600px</settings_height><settings_eventnumber>2</settings_eventnumber><settings_link></settings_link><settings_posts>false</settings_posts><settings_repeat>true</settings_repeat><settings_firstday>false</settings_firstday><settings_multiday>true</settings_multiday><settings_singleclick>false</settings_singleclick><settings_day>true</settings_day><settings_week>true</settings_week><settings_month>true</settings_month><settings_agenda>false</settings_agenda><settings_year>false</settings_year><settings_defaultmode>month</settings_defaultmode><settings_debug>false</settings_debug><settings_eventnumber>2</settings_eventnumber><settings_collision>false</settings_collision><settings_expand>true</settings_expand><settings_print>false</settings_print><settings_minical>false</settings_minical></settings><access><access_guestView_j>true</access_guestView_j><access_guestAdd_j>false</access_guestAdd_j><access_guestEdit_j>false</access_guestEdit_j><access_registeredView_j>true</access_registeredView_j><access_registeredAdd_j>false</access_registeredAdd_j><access_registeredEdit_j>false</access_registeredEdit_j><access_authorView_j>true</access_authorView_j><access_authorAdd_j>false</access_authorAdd_j><access_authorEdit_j>false</access_authorEdit_j><access_editorView_j>true</access_editorView_j><access_editorAdd_j>false</access_editorAdd_j><access_editorEdit_j>false</access_editorEdit_j><access_publisherView_j>true</access_publisherView_j><access_publisherAdd_j>false</access_publisherAdd_j><access_publisherEdit_j>false</access_publisherEdit_j><access_managerView_j>true</access_managerView_j><access_managerAdd_j>true</access_managerAdd_j><access_managerEdit_j>true</access_managerEdit_j><access_administratorView_j>true</access_administratorView_j><access_administratorAdd_j>true</access_administratorAdd_j><access_administratorEdit_j>true</access_administratorEdit_j><access_superadministratorView_j>true</access_superadministratorView_j><access_superadministratorAdd_j>true</access_superadministratorAdd_j><access_superadministratorEdit_j>true</access_superadministratorEdit_j><access_guestView>true</access_guestView><access_guestAdd>false</access_guestAdd><access_guestEdit>false</access_guestEdit><access_subscriberView>true</access_subscriberView><access_subscriberAdd>false</access_subscriberAdd><access_subscriberEdit>false</access_subscriberEdit><access_contributorView>true</access_contributorView><access_contributorAdd>false</access_contributorAdd><access_contributorEdit>false</access_contributorEdit><access_authorView>true</access_authorView><access_authorAdd>false</access_authorAdd><access_authorEdit>false</access_authorEdit><access_editorView>true</access_editorView><access_editorAdd>true</access_editorAdd><access_editorEdit>true</access_editorEdit><access_administratorView>true</access_administratorView><access_administratorAdd>true</access_administratorAdd><access_administratorEdit>true</access_administratorEdit><privatemode>off</privatemode></access><templates><templates_defaultdate><![CDATA[%d %M %Y]]></templates_defaultdate><templates_monthdate><![CDATA[%F %Y]]></templates_monthdate><templates_weekdate><![CDATA[%l]]></templates_weekdate><templates_daydate><![CDATA[%d/%m/%Y]]></templates_daydate><templates_hourdate><![CDATA[%H:%i]]></templates_hourdate><templates_monthday><![CDATA[%d]]></templates_monthday><templates_minmin><![CDATA[5]]></templates_minmin><templates_hourheight><![CDATA[40]]></templates_hourheight><templates_starthour><![CDATA[0]]></templates_starthour><templates_endhour><![CDATA[24]]></templates_endhour><templates_agendatime><![CDATA[30]]></templates_agendatime><templates_eventtext><![CDATA[return event.text;]]></templates_eventtext><templates_eventheader><![CDATA[return scheduler.templates.hour_scale(start) + " - " + scheduler.templates.hour_scale(end);]]></templates_eventheader><templates_eventbartext><![CDATA[return "<span title=&#8242;"+event.text+"&#8242;>" + event.text + "</span>";]]></templates_eventbartext></templates><customfields><customfield name="Text" dsc="Description" type="textarea" old_name="Text" use_colors="false" units="false" height="150" /></customfields></config>';
	private $log_file = 'com_scheduler_log.xml';
	private $tableUsers;
	private $scheduler_include_file = '../scheduler_include.html';
	private $problems = Array();
	private $joomla;

	function __construct($hiddenName, $connection, $table, $fieldName, $fieldValue, $tableEventsRec, $userIdField, $userLoginField, $tableUsers, $prefix, $userid = false, $joomla = false) {
		$this->connection = $connection;
		$this->table = $table;
		$this->fieldName = $fieldName;
		$this->fieldValue = $fieldValue;
		$this->tableEventsRec = $tableEventsRec;
		$this->prefix = $prefix;
		$this->userid = $userid;
		$this->userIdField = $userIdField;
		$this->userLoginField = $userLoginField;
		$this->tableUsers = $tableUsers;
		$this->joomla = $joomla;
		$this->parseConfig();
}


	private function parseConfig() {
		$query = "SELECT `".$this->fieldName."`, `".$this->fieldValue."` FROM ".$this->prefix.$this->table." WHERE `".$this->fieldName."`='scheduler_xml_version' OR `".$this->fieldName."`='scheduler_php_version' LIMIT 2";
		$res = mysql_query($query, $this->connection);
		$version = mysql_fetch_assoc($res);
		$versions[$version[$this->fieldName]] = $version[$this->fieldValue];
		$version = mysql_fetch_assoc($res);
		$versions[$version[$this->fieldName]] = $version[$this->fieldValue];
		$this->scheduler_xml_version = $versions['scheduler_xml_version'];

		if (($versions['scheduler_php_version'] != $versions['scheduler_xml_version'])||($versions['scheduler_xml_version'] == '')) {
			$this->problems = Array();
			$query = "SELECT `".$this->fieldValue."` FROM ".$this->prefix.$this->table." WHERE `".$this->fieldName."`='scheduler_xml'";
			$res = mysql_query($query, $this->connection);
			$xml = str_replace('&ltesc;', '<', mysql_result($res, 0, $this->fieldValue));
			$xml = str_replace('&gtesc;', '>', $xml);
			$xml = str_replace('&#8242;', "'", $xml);

			$this->xml = $xml;
			@$this->xmlObj = simplexml_load_string($this->xml);
			if ($this->xmlObj === false) {
				$invalid_xml = $this->xml;
				$this->addProblem("There was error during configuration saving. Last stable configuration restored.<br>Error report saved to \"".$this->log_file."\"");
				$xml = str_replace('&ltesc;', '<', $this->getLastStableConfig());
				$xml = str_replace('&gtesc;', '>', $xml);
				$xml = str_replace('&#8242;', "'", $xml);
				@$this->xmlObj = simplexml_load_string($xml);
				if ($this->xmlObj === false) {
					@$this->xmlObj = simplexml_load_string($this->default_xml);
					$this->setLastStableConfig($xml);
				}
			} else {
				$this->setLastStableConfig($xml);
				$invalid_xml = false;
			}
			if ((string) $this->xmlObj[0] == 'restore_default') {
				$query = "UPDATE `".$this->prefix.$this->table."` SET `".$this->fieldValue."` = '".mysql_real_escape_string($this->default_xml, $this->connection)."' WHERE `".$this->fieldName."` ='scheduler_xml' LIMIT 1 ;";
				$res = mysql_query($query);
				$this->xmlObj = simplexml_load_string($this->default_xml);
				$this->xml = $this->default_xml;
				$this->removeCustomFieldsFromDB();
			}
			$this->settingsParse();
			$this->accessParse();
			$this->templatesParse();
			$this->customfieldsParse();
			$this->php = $this->serializeOptions($this->settings);
			$query = "UPDATE `".$this->prefix.$this->table."` SET `".$this->fieldValue."` = '".mysql_real_escape_string($this->php, $this->connection)."' WHERE `".$this->fieldName."` ='scheduler_php' LIMIT 1 ;";
			$res = mysql_query($query);
			$query = "UPDATE `".$this->prefix.$this->table."` SET `".$this->fieldValue."` = '".$versions['scheduler_xml_version']."' WHERE `".$this->fieldName."` ='scheduler_php_version' LIMIT 1 ;";
			$res = mysql_query($query);
			$query = "UPDATE `".$this->prefix.$this->table."` SET `".$this->fieldValue."` = '".$this->settings['settings_eventnumber']."' WHERE `".$this->fieldName."`='sidebar_num' LIMIT 1";
			$res = mysql_query($query);
			if ($invalid_xml != false) {
				$this->addToLog($invalid_xml, 'invalid_config');
			}
		} else {
			$query = "SELECT `".$this->fieldValue."` FROM ".$this->prefix.$this->table." WHERE `".$this->fieldName."`='scheduler_php' LIMIT 1";
			$res = mysql_query($query);
			$this->php = mysql_result($res, 0, $this->fieldValue);
		}
		$this->parseOptions();
	}

	protected function setLastStableConfig($xml) {
		$query = "UPDATE `".$this->prefix.$this->table."` SET `".$this->fieldValue."` = '".mysql_real_escape_string($xml, $this->connection)."' WHERE `".$this->fieldName."` = 'scheduler_stable_config' LIMIT 1";
		$res = mysql_query($query);
	}

	protected function getLastStableConfig() {
		$query = "SELECT `".$this->fieldValue."` FROM ".$this->prefix.$this->table." WHERE `".$this->fieldName."`='scheduler_stable_config' LIMIT 1";
		$res = mysql_query($query);
		if (mysql_num_rows($res) == 0) {
			return false;
		} else {
			$stable_xml = mysql_result($res, 0, $this->fieldValue);
			return $stable_xml;
		}
	}

	public function get_option($name) {
		if (isset($this->settings[$name])) {
			return $this->settings[$name];
		} else {
			return false;
		}
	}


	public function add_option($group, $name, $value) {
		$this->settings[$name] = $value;
		$this->php = $this->serializeOptions($this->settings);
		$query = "UPDATE `".$this->prefix.$this->table."` SET `".$this->fieldValue."` = '".mysql_real_escape_string($this->php, $this->connection)."' WHERE `".$this->fieldName."` ='scheduler_php' LIMIT 1 ;";
		$res = mysql_query($query);
		$query = "SELECT `".$this->fieldValue."` FROM ".$this->prefix.$this->table." WHERE `".$this->fieldName."`='scheduler_xml'";
		$res = mysql_query($query, $this->connection);
		$this->xml = mysql_result($res, 0, $this->fieldValue);
		$preg = "/(<".$group.">)(.*)(<\/".$group.">)/";
		$this->xml = preg_replace($preg, "$1<".$name.">".$value."</".$name.">$2$3", $this->xml);
		$query = "UPDATE `".$this->prefix.$this->table."` SET `".$this->fieldValue."` = '".mysql_real_escape_string($this->xml, $this->connection)."' WHERE `".$this->fieldName."` ='scheduler_xml' LIMIT 1 ;";
		$res = mysql_query($query);
	}


	public function set_option($name, $value) {
		$this->settings[$name] = $value;
		$this->php = $this->serializeOptions($this->settings);
		$query = "UPDATE `".$this->prefix.$this->table."` SET `".$this->fieldValue."` = '".mysql_real_escape_string($this->php, $this->connection)."' WHERE `".$this->fieldName."` ='scheduler_php' LIMIT 1 ;";
		$res = mysql_query($query);
		$query = "SELECT `".$this->fieldValue."` FROM ".$this->prefix.$this->table." WHERE `".$this->fieldName."`='scheduler_xml'";
		$res = mysql_query($query, $this->connection);
		$this->xml = mysql_result($res, 0, $this->fieldValue);
		$preg = "/(<".$name.">)(.*)(<\/".$name.">)/";
		$this->xml = preg_replace($preg, "<".$name.">".$value."</".$name.">", $this->xml);
		$query = "UPDATE `".$this->prefix.$this->table."` SET `".$this->fieldValue."` = '".mysql_real_escape_string($this->xml, $this->connection)."' WHERE `".$this->fieldName."` ='scheduler_xml' LIMIT 1 ;";
		$res = mysql_query($query);
	}


	private function settingsParse() {
		$settings = $this->xmlObj->settings->children();
		foreach ($settings as $k=>$v) {
			$this->settings[$k] = (string) $v;
		}
	}


	private function accessParse() {
		$access = $this->xmlObj->access->children();
		foreach ($access as $k=>$v) {
			$this->settings[$k] = (string) $v;
		}
	}


	private function templatesParse() {
		$templates = $this->xmlObj->templates->children();
		foreach ($templates as $k=>$v) {
			$value = (string) $v;
			$value = str_replace("\n", "", $value);
			$this->settings[$k] = $value;
		}
	}


	private function customfieldsParse() {
		$customfields = $this->xmlObj->customfields->children();
		$this->settings['customfields'] = Array();
		$this->settings['units'] = array();
		foreach ($customfields as $k=>$v) {
			$cf = Array();
			$cf['name'] = strtolower(str_replace(" ","",(string) $v->attributes()->name));
			$cf['dsc'] = (string) $v->attributes()->dsc;
			$cf['old_name'] = (string) $v->attributes()->old_name;
			$cf['type'] = (string) $v->attributes()->type;
			$cf['use_colors'] = (string) $v->attributes()->use_colors;
			$cf['units'] = (string) $v->attributes()->units;
			$cf['timeline'] = (string) $v->attributes()->timeline;
			if ($cf['type'] == 'select') {
				$options = $v->children();
				$i = 0;
				foreach ($options as $optK=>$optV) {
					$cf['options'][$i]['name'] = (string) $optV;
					$cf['options'][$i]['color'] = (string) $optV->attributes()->color;
					$i++;
				}
			} else {
				$cf['height'] = (string) $v->attributes()->height;
			}
			$this->settings['customfields'][] = $cf;
		}
		$this->customfieldsCreate($this->settings['customfields']);
	}


	private function customfieldsCreate($customfields) {
		$fieldsString = 'scheduler.config.lightbox.sections=[';
		$fieldsNames = '';
		$fieldsList = '';
		$fieldsLabels = '';
		$eventStyles = '';
		$eventTemplate = '';
		$units = array();

		$query = 'SELECT * FROM '.$this->prefix.$this->tableEventsRec.' LIMIT 1';
		$res = mysql_query($query);
		$fields = array();
		$fieldsFinal = Array('event_id', 'start_date', 'end_date', 'rec_type', 'event_pid', 'event_length', 'user');
		for ($i = 0; $i < mysql_num_fields($res); $i++) {
			$field = mysql_field_name($res, $i);
			$fields[] = $field;
		}

		if ($this->settings["settings_posts"] == 'true') {
			$fieldsString .= '{name:"text", height: 150, map_to: "text", type:"textarea", focus:true}, ';
			$fieldsLabels = 'Text,';
			$fieldsNames = "scheduler.locale.labels.section_text = 'Text';";
			$fieldsList = 'text,';
			$fieldsFinal[] = 'text';
		} else {

			for ($i = 0; $i < count($customfields); $i++) {
				$fieldString = '';
				$field = $customfields[$i];
				$fieldName = strtolower(preg_replace('/[\/\\\.\| ]/', '', $field['name']));
				if (strlen($fieldName) < 1) {
					$this->addProblem("Incorrect custom field name '".$field['name']."'.");
					continue;
				}
				$fieldLabel = $field['dsc'];
				$fieldNameOld = strtolower(str_replace(' ', '', $field['old_name']));
				if (in_array($fieldName, $fieldsFinal)) {
					$this->addProblem("Field '".$fieldName."' is already used. Change name of this field.");
					continue;
				}

				if (($fieldName == 'text')&&($field['type'] == 'select')&&((!isset($field['options']))||(count($field['options']) < 1))) {
					$this->addProblem("Field '".$fieldName."' has empty option set. Its type is changed to 'text'");
					$field['type'] = 'textarea';
				}
				if ($field['type'] == 'textarea') {
					// addition text custom field
					$height = str_replace("px", "", $field['height']);
					if ($height == '') {
						$height = '100';
					}
					if ($fieldName == 'text') {
						$fieldString .= '{name:"'.$fieldName.'", height:'.$height.', map_to:"'.$fieldName.'", type:"textarea",focus:true},';
					} else {
						$fieldString .= '{name:"'.$fieldName.'", height:'.$height.', map_to:"'.$fieldName.'", type:"textarea"},';
					}
					$fieldsLabels .= $fieldLabel.",";
				} else {
					// addition select custom field

					// add problem if options array is empty
					if ((!isset($field['options']))||(count($field['options']) < 1)) {
						$this->addProblem("Field '".$fieldName."' has empty options set.");
						continue;
					}
					if ($fieldName == 'text') {
						$fieldString .= '{name:"'.$fieldName.'", height: 21, type: "select", focus:true, map_to: "'.$fieldName.'", options:[ ';
					} else {
						$fieldString .= '{name:"'.$fieldName.'", height: 21, type: "select", map_to: "'.$fieldName.'", options:[ ';
					}
					if ($field['use_colors'] == 'true') {
						$eventTemplate = "scheduler.templates.event_class = function(start_date, end_date, event) { switch(event.".$fieldName.") {";
					}
					$unit = $this->customFieldUnitsStart($field);
					$tl = $this->customFieldTimelineStart($field);
					if ($tl) {
						$timeline = $tl['start'];
						$timeline_add = $tl['add'];
					} else {
						$timeline = false;
						$timeline_add = '';
					}
					$optionsList = '';
					$optionsArr = Array();
					$optionsDouble = false;
					// parse options set
					for ($j = 0; $j < count($field['options']); $j++) {
						// two or more options with the same name checking
//						if (in_array($field['options'][$j], $optionsArr)) {
//							$optionsDouble = true;
//						}
						$optionsArr[] = $field['options'][$j];
						$fieldString .= '{key:"'.$fieldName."_".$j.'", label:"'.$field['options'][$j]['name'].'"},';
						$optionsList .= $fieldName."_".$j.':'.$field['options'][$j]['name'].',';
						if ($field['use_colors'] == 'true') {
							$eventStyles .= ".dhx_cal_event.".$fieldName."_".$j." div { background-color: ".$field['options'][$j]['color']." !important; } ";
							$eventStyles .= ".dhx_cal_event_line.".$fieldName."_".$j." { background-color: ".$field['options'][$j]['color']." !important; background-image: none !important; } ";
							$eventStyles .= ".dhx_cal_event_clear.".$fieldName."_".$j." { background-color: ".$field['options'][$j]['color']." !important; background-image: none !important; } ";
							if ($this->settings['settings_year'] == 'true') {
								$eventStyles .= ".dhx_month_head.dhx_year_event.".$fieldName."_".$j." { background-color: ".$field['options'][$j]['color']." !important; background-image: none !important; } ";	
							}
							$eventTemplate .= "case '".$fieldName."_".$j."': return '".$fieldName."_".$j."';";
						}
						if ($field['units'] == 'true') {
							$unit .= '{key:"'.$fieldName."_".$j.'", label:"'.$field['options'][$j]['name'].'"},';
						}
						if (($field['timeline'] != "null")&&($field['timeline'] != "off")&&($field['timeline'] != "undefined")&&($field['timeline'] != "")) {
							$timeline .= '{key:"'.$fieldName."_".$j.'", label:"'.$field['options'][$j]['name'].'"},';
						}
					}
					if ($optionsDouble) {
						$this->addProblem("Field '".$fieldName."' containes two or more options with the same name.");
						continue;
					}
					$fieldsLabels .= $fieldLabel.",";
					if ($unit) {
						$unit = substr($unit, 0, strlen($unit) - 1)."]});";
						$this->settings['units_'.$field['name']] = $unit;
					}
					if ($timeline) {
						$timeline = substr($timeline, 0, strlen($timeline) - 1)."]});".$timeline_add;
						$this->settings['timeline_'.$field['name'].'timeline'] = $timeline;
					}
					if ($field['use_colors'] == 'true') {
						$eventTemplate .= "default: return '".$fieldName."_0'} };";
					}
					$this->settings['optionsList_'.$fieldName] = substr($optionsList, 0, strlen($optionsList) - 1);
					$fieldString = substr($fieldString, 0, strlen($fieldString) - 1);
					$fieldString .= ']},';
				}
				$fieldsString .= $fieldString;

				if (!in_array($fieldName, $fields)) {
					if ($fieldNameOld == '') {
						$query = "ALTER TABLE `".$this->prefix.$this->tableEventsRec."` ADD `".$fieldName."` TEXT NOT NULL ";
						$res = mysql_query($query, $this->connection);
					} else {
						if (($fieldName !== $fieldNameOld)&&(!in_array($fieldNameOld, $fieldsFinal))) {
							$query = "ALTER TABLE `".$this->prefix.$this->tableEventsRec."` CHANGE `".$fieldNameOld."` `".$fieldName."` TEXT NOT NULL ";
							$res = mysql_query($query, $this->connection);
						} else {
							$query = "ALTER TABLE `".$this->prefix.$this->tableEventsRec."` ADD `".$fieldName."` TEXT NOT NULL ";
							$res = mysql_query($query, $this->connection);
						}
					}
				}
				$fieldsFinal[] = $fieldName;
				$fieldsNames .= "scheduler.locale.labels.section_".$fieldName." = '".$field['dsc']."';";
				$fieldsList .= $fieldName.',';
			}
		}
		if ($this->settings['settings_repeat'] == 'true') {
			$fieldsString .= '{name:"recurring", height:115, type:"recurring", map_to:"rec_type", button:"recurring"},';
		}
		if ($this->settings['settings_minical'] == 'true') {
			$fieldsString .= '{name:"time", height:72, type:"calendar_time", map_to:"auto"}';
		} else {
			$fieldsString .= '{name:"time", height:72, type:"time", map_to:"auto"}';
		}
		for ($i = 0; $i < count($fields); $i++) {
			if (!in_array($fields[$i], $fieldsFinal)) {
				$query = "ALTER TABLE `".$this->prefix.$this->tableEventsRec."` DROP `".$fields[$i]."`";
				$res = mysql_query($query, $this->connection);
			}
		}
		$fieldsString .= '];';
		$fieldsList = substr($fieldsList, 0, strlen($fieldsList) - 1);
		$fieldsLabels = substr($fieldsLabels, 0, strlen($fieldsLabels) - 1);

		$this->settings['customfields'] = $fieldsString;
		$this->settings['customfieldsList'] = $fieldsList;
		$this->settings['customfieldsLabels'] = $fieldsLabels;
		$this->settings['customfieldsNames'] = $fieldsNames;
		$this->settings['customfieldsCSS'] = $eventStyles;
		$this->settings['customfieldsTemplate'] = $eventTemplate;
		return true;
	}


	private function customFieldUnitsStart($field) {
		if (($field['units'] == 'true')&&((isset($field['options']))&&(count($field['options']) > 0))) {
			$unit = 'scheduler.locale.labels.'.$field['name'].'_tab = "'.$field['dsc'].'";';
			$unit .= 'scheduler.createUnitsView({ name:"'.$field['name'].'", property:"'.$field['name'].'", list: [ ';
		} else {
			$unit = false;
		}
		return $unit;
	}


	private function customFieldTimelineStart($field) {
		if (($field['timeline'] != 'off')&&((isset($field['options']))&&(count($field['options']) > 0))) {
			$timeline = '';
			$timeline_add = '';
			switch ($field['timeline']) {
				case 'day':
					$timeline = 'scheduler.locale.labels.'.$field['name'].'timeline_tab = "'.$field['dsc'].'";';
					$timeline .= 'scheduler.createTimelineView({ ';
					$timeline .= 'name: "'.$field['name'].'timeline", ';
					$timeline .= 'x_unit: "hour", ';
					$timeline .= 'x_date: "%H:%i", ';
					$timeline .= 'x_step: 2, ';
					$timeline .= 'x_size: 12, ';
					$timeline .= 'x_start: 0, ';
					$timeline .= 'x_length: 12, ';
					$timeline .= 'y_property:"'.$field['name'].'", ';
					$timeline .= 'render: "bar", y_unit: [ ';
					$timeline_add = "";
					break;
				case 'working_day':
					$timeline = 'scheduler.locale.labels.'.$field['name'].'timeline_tab = "'.$field['dsc'].'";';
					$timeline .= 'scheduler.createTimelineView({ ';
					$timeline .= 'name: "'.$field['name'].'timeline", ';
					$timeline .= 'x_unit: "hour", ';
					$timeline .= 'x_date: "%H:%i", ';
					$timeline .= 'x_step: 2, ';
					$timeline .= 'x_size: 6, ';
					$timeline .= 'x_start: 4, ';
					$timeline .= 'x_length: 12, ';
					$timeline .= 'y_property:"'.$field['name'].'", ';
					$timeline .= 'render: "bar", y_unit: [ ';
					$timeline_add = "";
					break;
				case 'week':
					$timeline = 'scheduler.locale.labels.'.$field['name'].'timeline_tab = "'.$field['dsc'].'";';
					$timeline .= 'scheduler.createTimelineView({ ';
					$timeline .= 'name: "'.$field['name'].'timeline", ';
					$timeline .= 'x_unit: "day", ';
					$timeline .= 'x_date: "%F %d", ';
					$timeline .= 'x_step: 1, ';
					$timeline .= 'x_size: 7, ';
					$timeline .= 'x_start: 0, ';
					$timeline .= 'x_length: 7, ';
					$timeline .= 'y_property:"'.$field['name'].'", ';
					$timeline .= 'render: "bar", y_unit: [ ';
					$timeline_add = 'scheduler.date.'.$field['name'].'timeline_start = function(date){ var day = date.getDay(); while (date.getDay() != 1) { date = scheduler.date.add(date, -1, "day"); } return date; };';
					break;
				case 'working_week':
					$timeline = 'scheduler.locale.labels.'.$field['name'].'timeline_tab = "'.$field['dsc'].'";';
					$timeline .= 'scheduler.createTimelineView({ ';
					$timeline .= 'name: "'.$field['name'].'timeline", ';
					$timeline .= 'x_unit: "day", ';
					$timeline .= 'x_date: "%F %d", ';
					$timeline .= 'x_step: 1, ';
					$timeline .= 'x_size: 5, ';
					$timeline .= 'x_start: 0, ';
					$timeline .= 'x_length: 7, ';
					$timeline .= 'y_property:"'.$field['name'].'", ';
					$timeline .= 'render: "bar", y_unit: [ ';
					$timeline_add = 'scheduler.date.'.$field['name'].'timeline_start = function(date){ var day = date.getDay(); while (date.getDay() != 1) { date = scheduler.date.add(date, -1, "day"); } return date; };';
					break;
				case 'month':
					$timeline = 'scheduler.locale.labels.'.$field['name'].'timeline_tab = "'.$field['dsc'].'";';
					$timeline .= 'scheduler.createTimelineView({ ';
					$timeline .= 'name: "'.$field['name'].'timeline", ';
					$timeline .= 'x_unit: "month", ';
					$timeline .= 'x_date: "%F", ';
					$timeline .= 'x_step: 1, ';
					$timeline .= 'x_size: 1, ';
					$timeline .= 'x_start: 0, ';
					$timeline .= 'x_length: 1, ';
					$timeline .= 'y_property:"'.$field['name'].'", ';
					$timeline .= 'render: "bar", y_unit: [ ';
					$timeline_add = 'scheduler.date.'.$field['name'].'timeline_start = function(date){ var day = date.getDate(); while (date.getDate() != 1) { date = scheduler.date.add(date, -1, "day"); } return date; };';
					break;
			}
			$tl = Array();
			$tl["start"] = $timeline;
			$tl["add"] = $timeline_add;
		} else {
			$tl = false;
		}
		return $tl;
	}


	private function removeCustomFieldsFromDB() {
		$query = 'SELECT * FROM '.$this->prefix.$this->tableEventsRec.' LIMIT 1';
		$res = mysql_query($query);
		$i = 0;
		$fields = array();
		for ($i = 0; $i < mysql_num_fields($res); $i++) {
			$field = mysql_field_name($res, $i);
			$fields[] = $field;
		}
		$fieldsFinal = Array('event_id', 'start_date', 'end_date', 'rec_type', 'event_pid', 'event_length', 'text', 'user');
		for ($i = 0; $i < count($fields); $i++) {
			if (!in_array($fields[$i], $fieldsFinal)) {
				$query = "ALTER TABLE `".$this->prefix.$this->tableEventsRec."` DROP `".$fields[$i]."`";
				$res = mysql_query($query, $this->connection);
			}
		}
	}


	private function parseOptions() {
		$this->settings['units'] = array();
		$this->settings['timelines'] = array();
		$options = explode("\n", $this->php);
		for ($i = 0; $i < count($options) - 1; $i++) {
			$opt = trim($options[$i]);
			$opt = explode('{*:*}', $opt);
			if (strpos($opt[0], 'units_') !== false) {
				$name = substr(trim($opt[0]), 6);
				$this->settings['units'][$name] = trim($opt[1]);
			} else {
				if (strpos($opt[0], 'timeline_') !== false) {
					$name = substr(trim($opt[0]), 9);
					$this->settings['timelines'][$name] = trim($opt[1]);
				} else {
					if (strpos($opt[0], 'problem_') !== false) {
						$this->problems[] = trim($opt[1]);
					} else {
						$this->settings[trim($opt[0])] = trim($opt[1]);
					}
				}
			}
		}
		if ((!isset($this->settings['templates_agendatime']))||($this->settings['templates_agendatime'] == '')) {
			$this->add_option('templates', 'templates_agendatime', '30');
			$this->settings['templates_agendatime'] = '30';
		}
	}


	private function serializeOptions() {
		$php = '';
		foreach ($this->settings as $k=>$v) {
			if (!is_array($v)) {
				$php .= $k."{*:*}".$v."\n";
			}
		}
		foreach ($this->problems as $k=>$v) {
			$php .= "problem_".$k."{*:*}".$v."\n";
		}
		return $php;
	}


	public function schedulerInit($usertype, $locale, $url, $loader_url) {
		$url = $this->replaceHostInURL($url);
		$loader_url = $this->replaceHostInURL($loader_url);
		$settings = $this->settings;
		if ($this->joomla == true) {
			$user_postfix = '_j';
		} else {
			$user_postfix = '';
		}

		if (!isset($settings["access_".$usertype."View".$user_postfix])) {
			$settings["access_".$usertype."View".$user_postfix] = "true";
			$settings["access_".$usertype."Add".$user_postfix] = "false";
			$settings["access_".$usertype."Edit".$user_postfix] = "false";
		}
		if ($this->settings['settings_debug'] == 'true') {
			$query = "SELECT `".$this->fieldValue."` FROM ".$this->prefix.$this->table." WHERE `".$this->fieldName."`='scheduler_xml'";
			$res = mysql_query($query, $this->connection);
			$xml = mysql_result($res, 0, $this->fieldValue);
			$this->addToLog($xml, $usertype);
		}

		if ($settings["access_".$usertype."View".$user_postfix] != 'true') {
			return '';
		}
		$scheduler = "<script src=\"".$url."dhtmlxscheduler.js\" type=\"text/javascript\" charset=\"utf-8\"></script>";
		$scheduler .= "<link rel=\"stylesheet\" href=\"".$url."dhtmlxscheduler_wp.css\" type=\"text/css\" charset=\"utf-8\">";
		$scheduler .= "<link rel=\"stylesheet\" href=\"".$url."dhtmlxscheduler.css\" type=\"text/css\" charset=\"utf-8\">";
		$scheduler .= "<script src=\"".$url."ext/dhtmlxscheduler_url.js\" type=\"text/javascript\" charset=\"utf-8\"></script>";

		if (count($settings['units']) > 0) {
			$scheduler .= "<script src=\"".$url."ext/dhtmlxscheduler_units.js\" type=\"text/javascript\" charset=\"utf-8\"></script>";
		}
		if (count($settings['timelines']) > 0) {
			$scheduler .= "<script src=\"".$url."ext/dhtmlxscheduler_timeline.js\" type=\"text/javascript\" charset=\"utf-8\"></script>";
		}

//		if (($settings["settings_posts"] == 'true')||(($settings["access_".$usertype."Add".$user_postfix] != 'true')||($settings["access_".$usertype."Edit".$user_postfix] != 'true'))) {
			$scheduler .= "<script src=\"".$url."ext/dhtmlxscheduler_readonly.js\" type=\"text/javascript\" charset=\"utf-8\"></script>";
//		}

		if ($settings['settings_repeat'] == 'true') {
			$scheduler .= "<script src=\"".$url."ext/dhtmlxscheduler_recurring.js\" type=\"text/javascript\" charset=\"utf-8\"></script>";
			$scheduler .= "<link rel=\"stylesheet\" href=\"".$url."ext/dhtmlxscheduler_recurring.css\" type=\"text/css\" charset=\"utf-8\">";
		}

		if ($settings['settings_year'] == 'true') {
			$scheduler .= "<script src=\"".$url."ext/dhtmlxscheduler_year_view.js\" type=\"text/javascript\" charset=\"utf-8\"></script>";
		}

		if ($settings['settings_agenda'] == 'true') {
			$scheduler .= "<script src=\"".$url."ext/dhtmlxscheduler_agenda_view.js\" type=\"text/javascript\" charset=\"utf-8\"></script>";
		}

		if ($settings['settings_expand'] == 'true') {
			$scheduler .= "<script src=\"".$url."ext/dhtmlxscheduler_expand.js\" type=\"text/javascript\" charset=\"utf-8\"></script>";
		}

		if ($settings['settings_collision'] == 'true') {
			$scheduler .= "<script src=\"".$url."ext/dhtmlxscheduler_collision.js\" type=\"text/javascript\" charset=\"utf-8\"></script>";
		}

		if ($settings['settings_print'] == 'true') {
			$scheduler .= "<script src=\"".$url."ext/dhtmlxscheduler_pdf.js\" type=\"text/javascript\" charset=\"utf-8\"></script>";
		}

		if ($settings['settings_minical'] == 'true') {
			$scheduler .= "<script src=\"".$url."ext/dhtmlxscheduler_minical.js\" type=\"text/javascript\" charset=\"utf-8\"></script>";
		}

		if (strlen($locale) > 0) {
			$scheduler .= "<script src=\"".$url."sources/locale_".$locale.".js\" type=\"text/javascript\" charset=\"utf-8\"></script>";
			if ($settings['settings_repeat'] == 'true') {
				$scheduler .= "<script src=\"".$url."sources/locale_recurring_".$locale.".js\" type=\"text/javascript\" charset=\"utf-8\"></script>";
			}
		}

		$scheduler .= "<style>".$settings['customfieldsCSS']."</style>";

		$scheduler .= "<script type=\"text/javascript\" charset=\"utf-8\">";

		$scheduler .= "scheduler.config.details_on_create=true;";
		$scheduler .= "scheduler.config.details_on_dblclick=true;";
		$scheduler .= "scheduler.config.default_date = \"".$settings['templates_defaultdate']."\";";
		$scheduler .= "scheduler.config.month_date = \"".$settings['templates_monthdate']."\";";
		$scheduler .= "scheduler.config.week_date = \"".$settings['templates_weekdate']."\";";
		$scheduler .= "scheduler.config.day_date = \"".$settings['templates_daydate']."\";";
		$scheduler .= "scheduler.config.hour_date = \"".$settings['templates_hourdate']."\";";
		$scheduler .= "scheduler.config.month_day = \"".$settings['templates_monthday']."\";";
		$scheduler .= "scheduler.config.api_date = \"%Y-%m-%d %H:%i:%s\";";
		$scheduler .= "scheduler.config.xml_date = \"%Y-%m-%d %H:%i:%s\";";
		$scheduler .= "scheduler.config.time_step = ".$settings['templates_minmin'].";";
		$scheduler .= "scheduler.config.hour_size_px = ".$settings['templates_hourheight'].";";
		$scheduler .= "scheduler.config.first_hour = ".$settings['templates_starthour'].";";
		$scheduler .= "scheduler.config.last_hour = ".$settings['templates_endhour'].";";
		$scheduler .= "scheduler.config.agenda_start = new Date();";
		$scheduler .= "scheduler.config.agenda_end = scheduler.date.add(new Date(), ".$settings['templates_agendatime'].", \"day\");";

		$scheduler .= "scheduler.templates.event_text=function(start,end,event){ ".htmlspecialchars_decode($settings['templates_eventtext'])." };";
		$scheduler .= "scheduler.templates.event_header=function(start,end,event){ ".htmlspecialchars_decode($settings['templates_eventheader'])." };";
		$scheduler .= "scheduler.templates.event_bar_text=function(start,end,event){ ".htmlspecialchars_decode($settings['templates_eventbartext'])." };";
			if ($settings['settings_firstday'] == 'true') {
				$scheduler .= "scheduler.config.start_on_monday = false;";
			} else {
				$scheduler .= "scheduler.config.start_on_monday = true;";
			}

			if ($settings['settings_multiday'] == 'true') {
				$scheduler .= "scheduler.config.multi_day = true;";
			} else {
				$scheduler .= "scheduler.config.multi_day = false;";
			}

			if ($settings['settings_singleclick'] == 'true') {
				$scheduler .= "(function(){
					var old = scheduler._click.dhx_cal_data;
					scheduler._click.dhx_cal_data=function(e){
						var trg = e?e.target:event.srcElement;
						var id = scheduler._locate_event(trg);
						 if (!id && !scheduler._lightbox_id) {
							scheduler._on_dbl_click(e||event);
						} else {
							old.call(scheduler, e)
						}
					}
				})();\n";
			}

			if ($settings["settings_posts"] == 'true'){
				$scheduler .= "scheduler.config.dblclick_create = false;
					scheduler.config.drag_create= false;
					scheduler.config.readonly_form = true;
					scheduler.locale.labels.confirm_recurring = '';
					scheduler.attachEvent('onClick',function(id){ scheduler.showLightbox(id); return false; });
					scheduler.attachEvent('onBeforeDrag',function(){return false;});";
			} else {
				if ($settings["access_".$usertype."Add".$user_postfix] != 'true') {
					$scheduler .= "scheduler.config.dblclick_create = false;
						scheduler.config.drag_create= false;";
				}
				if (($settings["access_".$usertype."Edit".$user_postfix] != 'true')&&($settings["access_".$usertype."Add".$user_postfix] == "true")) {
					// on/off readonly mode for lightbox
					$check_event = "function(id) {
						if (!id) { scheduler.config.readonly_form = false; return true; }
						scheduler.config.readonly_form = true; scheduler.showLightbox(id); return false; }";

					$scheduler .= "scheduler.attachEvent('onBeforeDrag',{$check_event});
						scheduler.attachEvent('onClick',{$check_event});
						scheduler.attachEvent('onDblClick',{$check_event});";
				}
				if (($settings["access_".$usertype."Add".$user_postfix] != 'true')&&($settings["access_".$usertype."Edit".$user_postfix] != 'true')) {
					$scheduler .= "scheduler.config.readonly_form = true;
						scheduler.locale.labels.confirm_recurring = '';
						scheduler.config.drag_create = false;
						scheduler.config.dblclick_create = false;
						scheduler.attachEvent('onClick',function(id){ scheduler.showLightbox(id); return false; });
						scheduler.attachEvent('onBeforeDrag',function(){return false;});";
				}
			}


			$cfs = Array();
			foreach ($settings['units'] as $k => $v) {
				$scheduler .= $v;
				$kl = strtolower($k);
				$settings['settings_'.$kl] = 'true';
				$cfs[] = $kl;
			}
			foreach ($settings['timelines'] as $k => $v) {
				$scheduler .= $v;
				$kl = strtolower($k);
				$settings['settings_'.$kl] = 'true';
				$cfs[] = $kl;
			}


			$modesNum = false;
			if ($settings['settings_'.$defaultmode] == 'false') {
				$modes = Array('day', 'week', 'month', 'agenda', 'view');
				foreach ($cfs as $v) {
					$modes[] = $v;
				}
				for ($i = 0; $i < count($modes); $i++) {
					if ($settings['settings_'.$modes[$i]] == 'true') {
						$defaultmode = $modes[$i];
						$modesNum = true;
						break;
					}
				}
				if ($modesNum == false) {
					return '';
				}
			}


			$defaultmode = $settings['settings_defaultmode'];
			$scheduler .= "var default_mode = '{$defaultmode}';\n";
			@$include_content = file_get_contents($url.$this->scheduler_include_file);
			if ($include_content) {
				$scheduler .= "</script>";
				$scheduler .= $include_content;
				$scheduler .= "<script type=\"text/javascript\" charset=\"utf-8\">";
			}

			$scheduler .= "window.onload = function init() {";
			$scheduler .= "\n".$settings['customfieldsNames']."\n";
			$scheduler .= $settings['customfields']."\n";

			$scheduler .= $settings['customfieldsTemplate']."\n";
			$scheduler .= "
				scheduler.init(\"scheduler_here\",null,default_mode);
				scheduler.load(\"".$loader_url."\"+scheduler.uid());
				var dp = new dataProcessor(\"".$loader_url."\"+scheduler.uid());
				dp.init(scheduler);";

			if ($settings["privatemode"] == "ext") {
				$scheduler .= "scheduler.attachEvent('onEventLoading', check_user);";
				$scheduler .= "scheduler.attachEvent('onBeforeDrag', check_user_before_drag);";
				$scheduler .= "function check_user_before_drag(event_id, native_event_object){
						if (event_id == null) {
							return true;
						}
						var event = scheduler.getEvent(event_id);
						if (event.user == '".$this->userid."') {
							return true;
						} else {
							return false;
						}
					}";
				$scheduler .= "function check_user(event){
						if (event.user == '".$this->userid."') {
							event.readonly = false;
						} else {
							event.readonly = true;
						}
						return event;
					}";
			}
			$scheduler .= "dp.attachEvent('onAfterUpdate', after_update);";
			$scheduler .= "function after_update(sid, action, tid, xml_node) {
					var userid = xml_node.getAttribute('user');
					if (action != 'deleted') {
						var event = scheduler.getEvent(sid);
						event.user = userid;
					}
				}";

			if ($settings['settings_debug'] == 'true') {
				$scheduler .= "dhtmlxError.catchError(\"LoadXML\",function(a,b,c){
					var html = \"The text below, contains details about of server side problem.<hr><pre style=\\\"font-size: 8pt;\\\">\"+ c[0].responseText + \"</pre>\";
					document.body.innerHTML = html;
					})";
			}

			$scheduler .= "};";

			if ($settings['settings_minical'] == 'true') {
				$scheduler .= "function show_minical(){
					if (scheduler.isCalendarVisible())
						scheduler.destroyCalendar();
					else
						scheduler.renderCalendar({
							position:\"dhx_minical_icon\",
							date:scheduler._date,
							navigation:true,
							handler:function(date,calendar){
								scheduler.setCurrentView(date);
								scheduler.destroyCalendar()
							}
						});
				}";
			}


		$scheduler .= "</script>
			<div id=\"scheduler_here\" class=\"dhx_cal_container\" style='width:".$settings['settings_width']."; height:".$settings['settings_height'].";'>
				<div class=\"dhx_cal_navline\">
					<div class=\"dhx_cal_prev_button\">&nbsp;</div>
					<div class=\"dhx_cal_next_button\">&nbsp;</div>
					<div class=\"dhx_cal_today_button\"></div>
					<div class=\"dhx_cal_date\"></div>";
			if ($settings['settings_minical'] == 'true') {
				$scheduler .= "<div class=\"dhx_minical_icon\" id=\"dhx_minical_icon\" onclick=\"show_minical()\">&nbsp;</div>";
			}
			$modes = array('settings_day', 'settings_week', 'settings_month', 'settings_year', 'settings_agenda');
			foreach ($settings['units'] as $k => $v) {
				$modes[] = 'settings_'.$k;
				$settings['settings_'.$k] = 'true';
			}
			foreach ($settings['timelines'] as $k => $v) {
				$modes[] = 'settings_'.$k;
				$settings['settings_'.$k] = 'true';
			}
			$modesNumber = 0;
			for ($i = 0; $i < count($modes); $i++) {
				if ($settings[$modes[$i]] == 'true') {
					$modesNumber++;
				}
			}
			for ($i = 0; $i < count($modes); $i++) {
				if ($settings[$modes[$i]] == 'true') {
					$modesNumber--;
					$name = substr($modes[$i], 9);
					$scheduler .= "<div class=\"dhx_cal_tab\" name=\"".$name."_tab\" style=\"right:".(20 + 64*$modesNumber)."px;\"></div>";
				}
			}

			$scheduler .= "
				</div>
			<div class=\"dhx_cal_header\">
			</div>
			<div class=\"dhx_cal_data\">
			</div>
			<div style='position:absolute; bottom:5px; right:20px; font: Tahoma 8pt; color:black;'>
				Powered by <a href='http://dhtmlx.com' target='_blank' style='color:#444444;'>dhtmlxScheduler</a>
			</div>
		</div>";
		return $scheduler;
	}


	protected function addToLog($xml, $usertype = 'undefined') {
		$xml = str_replace('&ltesc;', '<', $xml);
		$xml = str_replace('&gtesc;', '>', $xml);
		if ($this->joomla == true) {
			$log_file_path = JPATH_SITE.DS.'components'.DS.'com_scheduler'.DS.$this->log_file;
		} else {
			$log_file_path = WP_PLUGIN_DIR.'/event-calendar-scheduler/'.$this->log_file;
		}
		if (file_exists($log_file_path)) {
			$log = simplexml_load_file($log_file_path);
		} else {
			$log = simplexml_load_string('<logs></logs>');
		}
		$elem = $log->addChild('log', $xml);
		$elem->addAttribute('time', date("Y-m-d H:i:s"));
		$elem->addAttribute('usertype', $usertype);
		$log->asXML($log_file_path);
		return true;
	}


	public function getXML() {
		$query = "SELECT `".$this->fieldValue."` FROM ".$this->prefix.$this->table." WHERE `".$this->fieldName."`='scheduler_xml' LIMIT 1";
		$res = mysql_query($query, $this->connection);
		$xml = mysql_result($res, 0, $this->fieldValue);
		$xml = str_replace("&ltesc;", "<", $xml);
		$xml = str_replace("&gtesc;", ">", $xml);
		$xml = str_replace("&#8242;", "'", $xml);
		@$this->xmlObj = simplexml_load_string($xml);
		if ($this->xmlObj === false) {
			$xml = $this->getLastStableConfig();
			@$this->xmlObj = simplexml_load_string($xml);
			if ($this->xmlObj === false) {
				$xml = $this->default_xml;
			}
		}
		if ((string) $this->xmlObj[0] == 'restore_default') {
			$xml = $this->default_xml;
		}
		return $xml;
	}


	public function getXmlVersion() {
		return ($this->scheduler_xml_version + 1);
	}


	public function getEventsRec($usertype) {
		if ($this->joomla == true) {
			$user_postfix = '_j';
		} else {
			$user_postfix = '';
		}
		require("connector/scheduler_connector.php");
		$this->scheduler = new schedulerConnector($this->connection);
		if ($this->settings['settings_debug'] == 'true') {
			if ($this->joomla == true) {
				$log_file_path = JPATH_SITE.DS.'components'.DS.'com_scheduler'.DS.'scheduler_log.txt';
			} else {
				$log_file_path = WP_PLUGIN_DIR.'/event-calendar-scheduler/scheduler_log.txt';
			}
			$this->scheduler->enable_log($log_file_path, true);
		}

		if ($this->settings['settings_posts'] == 'true') {
			$this->scheduler->access->deny("insert");
			$this->scheduler->access->deny("update");
			$this->scheduler->access->deny("delete");

			$this->scheduler->event->attach("beforeRender", Array($this, "posts_table_builder"));
			$this->scheduler->render_sql("SELECT `ID`,`post_date`,`post_date_gmt`,`post_title`,`guid` FROM `".$this->prefix."posts` WHERE `post_type`='post' AND ((`post_status`='publish') OR (`post_status`='private' AND `post_author`='".$this->userid."'))", "ID", "post_date,post_date_gmt,post_title,guid");
		} else {
			if ($this->settings["access_".$usertype."Add".$user_postfix] != 'true') {
				$this->scheduler->access->deny("insert");
			}
			if ($this->settings["access_".$usertype."Edit".$user_postfix] != 'true') {
				$this->scheduler->access->deny("update");
				$this->scheduler->access->deny("delete");
			}
			if ($this->settings['settings_repeat'] == 'true') {
				$this->scheduler->event->attach("beforeProcessing", Array($this, "delete_related"));
				$this->scheduler->event->attach("afterProcessing", Array($this, "insert_related"));
			}
			$this->scheduler->event->attach("beforeProcessing", Array($this, "set_event_user"));
			$this->scheduler->event->attach("afterProcessing", Array($this, "after_set_event_user"));
			$fields = 'start_date,end_date';
			if ($this->settings['customfieldsList']) {
				$fields .= ",".$this->settings['customfieldsList'];
			}
			$fields .= ',rec_type,event_pid,event_length,user';
			if ($this->settings['privatemode'] == 'on') {
				$this->scheduler->event->attach("beforeRender", Array($this, "private_remove_updated"));
				$query = "SELECT event_id,".$fields.",user FROM `".$this->prefix.$this->tableEventsRec."` WHERE `user`='".($this->userid)."' OR `event_pid`!=0";
				$this->scheduler->render_sql($query,"event_id", $fields);
			} else {
				$this->scheduler->render_table($this->prefix.$this->tableEventsRec,"event_id",$fields);
			}
		}
	}


	public function private_remove_updated($row) {
		$rec_type = $row->get_value('rec_type');
		$userid = $row->get_value('user');
		if (($rec_type != 'none')&&($userid != $this->userid)) {
			$row->set_value('rec_type', 'none');
		}
		return $row;
	}


	public function set_event_user($action) {
		$status = $action->get_status();
		if ($status == "inserted") {
			$action->set_value("user", $this->userid);
		} else {
			if ($this->settings["privatemode"] == "ext") {
				$user = $action->get_value('user');
				if ($user != $this->userid) {
					$action->error();
				}
			}
		}
		if ($action->get_value('event_pid') == '') {
			$action->set_value('event_pid', 0);
		}
		if ($action->get_value('event_length') == '') {
			$action->set_value('event_length', 0);
		}
	}

	public function after_set_event_user($action) {
		$action->set_response_attribute("user", $this->userid);
	}

	public function getEventsRecGrid() {
		require("connector/grid_connector.php");
		$grid = new GridConnector($this->connection);
		if ($this->settings['settings_debug'] == 'true') {
			if ($this->joomla == true) {
				$log_file_path = JPATH_SITE.DS.'components'.DS.'com_scheduler'.DS.'scheduler_log.txt';
			} else {
				$log_file_path = WP_PLUGIN_DIR.'/event-calendar-scheduler/scheduler_log.txt';
			}
			$grid->enable_log($log_file_path, true);
		}

		$fields = '';
		$fieldNames = '';
		$fieldsLabels = '';
		$types = '';
		$aligns = '';
		$widths = '';
		$sort = '';
		$fieldsNum = 0;
		$fillFields = '';
		$dhx_colls = false;
		if ($this->settings['customfieldsList']) {
			$fieldsList = explode(",", $this->settings['customfieldsList']);
			$fieldsLabelsArray = explode(",", $this->settings['customfieldsLabels']);
			for ($i = 0; $i < count($fieldsList); $i++) {
				if (isset($this->settings['optionsList_'.$fieldsList[$i]])) {
					$types .= "coro,";
					$fillFields .= $fieldsList[$i].",";
					$opts = explode(',', $this->settings['optionsList_'.$fieldsList[$i]]);
					$optionsList = array();
					for ($j = 0; $j < count($opts); $j++) {
						$opt = explode(':', $opts[$j]);
						$optionsList[$opt[0]] = $opt[1];
					}
					$dhx_colls .= ($i + $fieldsNum).",";
					$grid->set_options(strtolower($fieldsList[$i]), $optionsList);
				} else {
					$types .= "ed,";
				}
				$fields .= $fieldsList[$i].",";
				$fieldsNames .= $fieldsList[$i].",";
				$fieldsLabels .= $fieldsLabelsArray[$i].",";
				$aligns .= ",left";
				$widths .= ($fieldsList[$i] == 'text') ? "*," : "15,";
				$sort .= ",str";
				if ($fieldsList[$i] == 'text') {
					$fields .= 'start_date,end_date,';
					$fieldsNames .= 'Start date,End Date,';
					$fieldsLabels .= 'Start date,End Date,';
					$types .= 'ed,ed,';
					$aligns .= 'center,center,';
					$widths .= '15,15,';
					$sort .= 'str,str,';
					$fieldsNum += 2;

					if (($this->settings['privatemode'] == 'on')||($this->settings['privatemode'] == 'ext')) {
						$fields .= 'user,';
						$fieldsNames .= 'user,';
						$fieldsLabels .= 'User,';
						$types .= 'coro['.$this->userid.'],';
						$aligns .= 'left,';
						$widths .= '15,';
						$sort .= 'str,';

						$query = "SELECT `".$this->userIdField."`, `".$this->userLoginField."` FROM `".$this->prefix.$this->tableUsers."`";
						$res = $grid->sql->query($query);
						$users_array = Array('0'=>'Guest');
						while ($user = mysql_fetch_assoc($res)) {
							$users_array[$user[$this->userIdField]] = $user[$this->userLoginField];
						}
						$grid->set_options('user', $users_array);
						$dhx_colls .= "3,";
						$fieldsNum++;
					}
				}
			}
		}
		if ($dhx_colls) {
			$this->dhx_colls = substr($dhx_colls, 0, strlen($dhx_colls) - 1);
			$grid->event->attach("beforeExtraOutput", Array($this, "extra_output_callback"));
		}

		$fields = substr($fields, 0, strlen($fields) - 1);
		$fieldsNames = substr($fieldsNames, 0, strlen($fieldsNames) - 1);
		$fieldsLabels = substr($fieldsLabels, 0, strlen($fieldsLabels) - 1);
		$config = new GridConfiguration($fieldsLabels);
		$config->setColIds($fieldsNames);
		$config->setColTypes($types);
		$config->setColAlign($aligns);
		$config->setInitWidthsP($widths);
		$config->setColSorting($sort);
		$grid->set_config($config);

		$grid->render_table($this->prefix.$this->tableEventsRec, "event_id", $fields);
	}


	public function extra_output_callback($grid) {
		$grid->fill_collections($this->dhx_colls);
	}


	public function insert_related($action) {
		LogMaster::log(print_r($action, true));
		$status = $action->get_status();
		$type =$action->get_value("rec_type");

		if ($status == "inserted" && $type=="none")
			$action->set_status("deleted");
	}


	public function delete_related($action){
		$status = $action->get_status();
		$type =$action->get_value("rec_type");
		$pid =$action->get_value("event_pid");
		if (($status == "deleted" || $status == "updated") && $type!=""){
			$this->scheduler->sql->query("DELETE FROM `".$this->prefix.$this->tableEventsRec."` WHERE event_pid='".$this->scheduler->sql->escape($action->get_id())."'");
		}
		if ($status == "deleted" && $pid !=0){
			$this->scheduler->sql->query("UPDATE `".$this->prefix.$this->tableEventsRec."` SET rec_type='none' WHERE event_id='".$this->scheduler->sql->escape($action->get_id())."'");
			$action->success();
		}
	}


	private function posts_table_builder($row) {
		$start = substr($row->get_value("post_date"), 0, 10)." 00:00:00";
		$row->set_value("post_date", $start);
		$start = date_parse($start);
		$endd = mktime($start['hour'], $start['minute'], $start['second'], $start['month'], $start['day'] + 1, $start['year']);
		$endd = date("Y-m-d", $endd)." 00:00:00";
		$row->set_value("post_date_gmt", $endd);
		$text = $row->get_value("post_title");
		$text = "<a href=\"".$row->get_value("guid")."\">".$text."</a>";
		$row->set_value("post_title", $text);
	}


	public function getProblems() {
		if (count($this->problems) == 0) {
			return "";
		}
		$problems = "<ul class='scheduler_problems'>";
		for ($i = 0; $i < count($this->problems); $i++) {
			$problems .= "<li>".$this->problems[$i]."</li>";
		}
		$problems .= "</ul>";
		return $problems;
	}


	protected function addProblem($problem) {
		if (!in_array($problem, $this->problems)) {
			$this->problems[] = $problem;
			return true;
		} else {
			return false;
		}
	}


	protected function replaceHostInURL($url) {
		$url_parsed = parse_url($url);
		$host = $_SERVER['SERVER_NAME'];
		$url = preg_replace("/".preg_quote($url_parsed['host'])."/", $host, $url, 1);
		return $url;
	}

}

?>