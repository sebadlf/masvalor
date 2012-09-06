<script src='<?php echo WP_PLUGIN_URL; ?>/event-calendar-scheduler/codebase/dhtmlx.js'></script>
<script src='<?php echo WP_PLUGIN_URL; ?>/event-calendar-scheduler/codebase/dhtmlxSchedulerConfigurator.js'></script>
<script src="<?php echo WP_PLUGIN_URL; ?>/event-calendar-scheduler/codebase/connector/connector.js" type="text/javascript" charset="utf-8"></script>
<link rel='STYLESHEET' type='text/css' href='<?php echo WP_PLUGIN_URL; ?>/event-calendar-scheduler/codebase/dhtmlx.css'>
<style>

ul.scheduler_problems {
	width: 47%;
	padding-top: 10px;
	padding-right: 10px;
	padding-bottom: 0px;
	padding-left: 14px;
	font-family: Tahoma;
	font-size: 12px;
	color: #555555;
	list-style-type: none;
}

ul.scheduler_problems li {
	background-color: #FFFBCC;
	border: 1px solid #E6DB55;
	padding-top: 10px;
	padding-left: 10px;
	padding-bottom: 10px;
}
</style>
<?php
if ($scheduler_loc != '') {
	echo '<script src="'.WP_PLUGIN_URL.'/event-calendar-scheduler/codebase/locale/locale_'.$scheduler_loc.'.js"></script>';
}
?>
<?php echo $scheduler_cfg->getProblems(); ?>
<?php if (get_site_option("scheduler_main") == 'on') { ?>
	<form method="post" action="<?php echo WP_PLUGIN_URL; ?>/event-calendar-scheduler/wpmu_options.php" id="scheduler_config_form">
<?php } else { ?>
	<form method="post" action="options.php" id="scheduler_config_form">
<?php } ?>
	<?php settings_fields('scheduler_options'); ?>
	<script>
		var conf;
		window.onload = function() {
			conf = new dhtmlxSchedulerConfig({
				parent: 'schedulerConfigurator',
				hidden: 'scheduler_xml',
				access: 'wp',
				url: '<?php echo WP_PLUGIN_URL; ?>/event-calendar-scheduler/codebase/',
				url_load: '<?php echo WP_PLUGIN_URL; ?>/event-calendar-scheduler/codebase/dhtmlxSchedulerConfiguratorLoad.php?task=loadxml',
				wp_specific: true
			});
		}
		
		function restore_scheduler_config() {
			document.getElementById('scheduler_xml').value = '<config>restore_default</config>';
			document.getElementById('scheduler_config_form').submit();
		}
	</script>
	<div id="schedulerConfigurator" style="position: relative; width: 800px; height: 620px; float: left; margin-top: 16px;"></div>
	<div style="clear: both;">&nbsp;</div>
	<input type="hidden" id="scheduler_xml_version" name="scheduler_xml_version" value="<?php echo $scheduler_cfg->getXmlVersion(); ?>" />
	<input type="hidden" id="scheduler_xml" name="scheduler_xml" value='' />

	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="page_options" value="scheduler_xml,scheduler_xml_version" />

	<h1>
	<?php do_settings_sections('scheduler_options'); ?>
	</h1>
	<p class="submit">
		<input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" />
		<input type="button" name="Restore" value="<?php _e('Restore default') ?>" onclick="restore_scheduler_config();" />
	</p>
</form>